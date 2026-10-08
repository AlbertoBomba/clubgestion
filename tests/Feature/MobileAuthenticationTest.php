<?php

namespace Tests\Feature;

use App\Models\SportsSchool;
use App\Models\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MobileAuthenticationTest extends TestCase
{
    private const BASE = '/api/v1/auth';

    private ?DatabaseManager $databaseManager = null;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'mobile_auth_tests',
            'database.connections.mobile_auth_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'cache.default' => 'array',
            'sanctum.expiration' => null,
            'app.key' => 'base64:'.base64_encode(random_bytes(32)),
        ]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_11_24_111219_add_two_factor_columns_to_users_table.php',
            '2025_11_24_111252_create_personal_access_tokens_table.php',
            '2025_11_25_112454_create_sports_schools_table.php',
            '2025_11_25_112501_add_sports_school_fields_to_users_table.php',
            '2025_11_25_114450_create_permission_tables.php',
            '2025_12_03_155844_add_documents_to_users_table.php',
            '2026_02_11_000001_add_domain_to_sports_schools_table.php',
            '2026_10_08_180000_add_web_role_to_users.php',
        ] as $migration) {
            (require database_path('migrations/'.$migration))->up();
        }
    }

    protected function tearDown(): void
    {
        if ($this->databaseManager !== null) {
            DB::swap($this->databaseManager);
        }

        DB::purge('mobile_auth_tests');
        $this->travelBack();

        parent::tearDown();
    }

    private function registration(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Usuario Android',
            'email' => 'android@example.test',
            'password' => 'secure-password-123',
            'password_confirmation' => 'secure-password-123',
            'device_name' => 'Android',
        ], $overrides);
    }

    private function user(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'Usuario existente',
            'email' => 'existing@example.test',
            'password' => Hash::make('secure-password-123'),
            'role' => 'web',
            'is_active' => true,
        ], $overrides));
    }

    private function token(User $user): string
    {
        return $user->createToken('Android', ['mobile:profile'], now()->addDays(30))->plainTextToken;
    }

    private function getMe(string $token)
    {
        $this->app['auth']->forgetGuards();

        return $this->getJson(self::BASE.'/me', ['Authorization' => 'Bearer '.$token]);
    }

    public function test_registration_creates_a_web_user_and_a_hashed_expiring_token(): void
    {
        $this->travelTo(now()->startOfSecond());
        $response = $this->postJson(self::BASE.'/register', $this->registration([
            'name' => ' Usuario Android ',
            'email' => ' ANDROID@EXAMPLE.TEST ',
            'documents' => ['private'],
        ]));

        $response->assertCreated()->assertJsonStructure([
            'token', 'token_type', 'expires_at',
            'user' => ['id', 'name', 'email', 'role', 'sports_school_id', 'is_active', 'email_verified_at', 'created_at'],
        ])->assertJsonPath('token_type', 'Bearer')
            ->assertJsonPath('expires_at', now()->addDays(30)->toISOString())
            ->assertJsonPath('user.name', 'Usuario Android')
            ->assertJsonPath('user.email', 'android@example.test')
            ->assertJsonPath('user.role', 'web')
            ->assertJsonPath('user.sports_school_id', null)
            ->assertJsonPath('user.email_verified_at', null);
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        $user = User::findOrFail($response->json('user.id'));
        $this->assertTrue(Hash::check('secure-password-123', $user->password));
        $this->assertNotSame('secure-password-123', $user->password);
        $this->assertTrue($user->hasRole('web'));
        $this->assertSame(0, $user->getAllPermissions()->count());
        $this->assertNull($user->documents);

        $token = PersonalAccessToken::findToken($response->json('token'));
        $this->assertSame(['mobile:profile'], $token->abilities);
        $this->assertNotSame($response->json('token'), $token->token);
        $this->assertTrue($token->expires_at->equalTo(now()->addDays(30)));
        $this->getMe($response->json('token'))->assertOk()->assertJsonPath('user.id', $user->id);
    }

    public function test_registration_rejects_privileged_fields(): void
    {
        $this->postJson(self::BASE.'/register', $this->registration([
            'role' => 'master',
            'sports_school_id' => 1,
            'is_active' => false,
            'email_verified_at' => now()->toISOString(),
        ]))->assertUnprocessable()->assertJsonValidationErrors([
            'role', 'sports_school_id', 'is_active', 'email_verified_at',
        ]);

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_registration_requires_valid_basic_fields_and_password_confirmation(): void
    {
        $this->postJson(self::BASE.'/register', [
            'name' => ' ',
            'email' => 'invalid',
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertUnprocessable()->assertJsonValidationErrors([
            'name', 'email', 'password', 'device_name',
        ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_passwords_above_bcrypt_byte_limit(): void
    {
        $password = str_repeat("\u{00E9}", 40);
        $this->postJson(self::BASE.'/register', $this->registration([
            'password' => $password,
            'password_confirmation' => $password,
        ]))->assertUnprocessable()->assertJsonValidationErrors('password');

        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_duplicate_emails_without_logging_in_the_existing_user(): void
    {
        $user = $this->user(['email' => 'ANDROID@EXAMPLE.TEST']);
        $this->postJson(self::BASE.'/register', $this->registration())
            ->assertUnprocessable()->assertJsonValidationErrors('email');

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('personal_access_tokens', 0);
        $this->assertSame('Usuario existente', $user->fresh()->name);
    }

    public function test_registration_rolls_back_if_role_assignment_fails(): void
    {
        Role::findByName('web', 'web')->delete();
        $this->postJson(self::BASE.'/register', $this->registration())->assertStatus(500);

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_login_returns_only_allowlisted_user_fields_without_changing_an_existing_role(): void
    {
        $school = SportsSchool::create(['name' => 'Escuela privada', 'slug' => 'private']);
        $user = $this->user([
            'email' => 'EXISTING@EXAMPLE.TEST',
            'role' => 'coach',
            'sports_school_id' => $school->id,
            'documents' => [['path' => 'private-document.pdf']],
        ]);

        $response = $this->postJson(self::BASE.'/login', [
            'email' => ' existing@example.test ',
            'password' => 'secure-password-123',
            'device_name' => 'Android',
        ])->assertOk()->assertJsonPath('user.role', 'coach')
            ->assertJsonPath('user.sports_school_id', $school->id);

        $this->assertSame([
            'id', 'name', 'email', 'role', 'sports_school_id', 'is_active', 'email_verified_at', 'created_at',
        ], array_keys($response->json('user')));
        $this->assertSame('coach', $user->fresh()->role);
        $this->getMe($response->json('token'))->assertOk()->assertJsonPath('user.email', $user->email);
    }

    public function test_login_does_not_create_users_and_returns_the_same_error_for_wrong_credentials(): void
    {
        $this->user();
        $wrong = $this->postJson(self::BASE.'/login', [
            'email' => 'existing@example.test',
            'password' => 'wrong',
            'device_name' => 'Android',
        ])->assertUnauthorized()->assertJsonPath('code', 'invalid_credentials');
        $missing = $this->postJson(self::BASE.'/login', [
            'email' => 'missing@example.test',
            'password' => 'wrong',
            'device_name' => 'Android',
        ])->assertUnauthorized();

        $this->assertSame($wrong->json(), $missing->json());
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_inactive_accounts_cannot_login_or_continue_using_mobile_tokens(): void
    {
        $user = $this->user(['is_active' => false]);
        $this->postJson(self::BASE.'/login', [
            'email' => $user->email,
            'password' => 'secure-password-123',
            'device_name' => 'Android',
        ])->assertForbidden()->assertJsonPath('code', 'account_inactive');
        $this->assertDatabaseCount('personal_access_tokens', 0);

        $token = $this->token($user);
        $this->getMe($token)->assertForbidden()->assertJsonPath('code', 'account_inactive');
        $this->assertNull(PersonalAccessToken::findToken($token));
    }

    public function test_two_factor_accounts_cannot_bypass_the_second_factor(): void
    {
        $user = $this->user();
        $user->forceFill([
            'two_factor_secret' => encrypt('secret'),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $this->postJson(self::BASE.'/login', [
            'email' => $user->email,
            'password' => 'secure-password-123',
            'device_name' => 'Android',
        ])->assertForbidden()->assertJsonPath('code', 'two_factor_required');
        $this->assertDatabaseCount('personal_access_tokens', 0);

        $token = $this->token($user);
        $this->getMe($token)->assertForbidden()->assertJsonPath('code', 'two_factor_required');
        $this->assertNull(PersonalAccessToken::findToken($token));
    }

    public function test_me_rejects_missing_invalid_expired_and_insufficient_tokens(): void
    {
        $this->getJson(self::BASE.'/me')->assertUnauthorized();
        $this->getMe('invalid')->assertUnauthorized();

        $user = $this->user();
        $expired = $user->createToken('Old', ['mobile:profile'], now()->subSecond())->plainTextToken;
        $this->getMe($expired)->assertUnauthorized();
        $other = $user->createToken('Other', ['read'], now()->addDay())->plainTextToken;
        $this->getMe($other)->assertForbidden()->assertJsonPath('code', 'token_forbidden');
    }

    public function test_mobile_tokens_expire_after_thirty_days_without_sliding_expiration(): void
    {
        $this->travelTo(now()->startOfSecond());
        $user = $this->user();
        $token = $this->token($user);

        $this->travel(29)->days();
        $this->getMe($token)->assertOk();
        $this->travel(1)->days();
        $this->travel(1)->seconds();
        $this->getMe($token)->assertUnauthorized();
    }

    public function test_web_sessions_cannot_replace_mobile_bearer_tokens(): void
    {
        $this->actingAs($this->user(), 'web')
            ->getJson(self::BASE.'/me')
            ->assertUnauthorized()->assertJsonPath('code', 'unauthenticated');
    }

    public function test_logout_revokes_only_the_current_device_token(): void
    {
        $user = $this->user();
        $token = $this->token($user);
        $other = $this->token($user);

        $this->postJson(self::BASE.'/logout', [], ['Authorization' => 'Bearer '.$token])
            ->assertOk()->assertJsonPath('message', 'Sesión cerrada correctamente.');
        $this->assertNull(PersonalAccessToken::findToken($token));
        $this->getMe($token)->assertUnauthorized();
        $this->getMe($other)->assertOk();
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_legacy_user_endpoint_does_not_serialize_private_relationships(): void
    {
        $user = $this->user(['documents' => [['path' => 'private.pdf']]]);
        $this->getJson('/api/user', ['Authorization' => 'Bearer '.$this->token($user)])
            ->assertOk()->assertExactJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'web',
                'sports_school_id' => null,
                'is_active' => true,
                'email_verified_at' => null,
                'created_at' => $user->created_at->toISOString(),
            ]);
    }

    public function test_new_web_users_cannot_access_administrative_routes(): void
    {
        $response = $this->postJson(self::BASE.'/register', $this->registration())->assertCreated();
        $this->app['auth']->forgetGuards();

        $this->getJson('/sports-schools', ['Authorization' => 'Bearer '.$response->json('token')])
            ->assertForbidden();
    }

    public function test_legacy_user_endpoint_still_accepts_web_sessions(): void
    {
        $user = $this->user();
        $this->actingAs($user, 'web')->getJson('/api/user')
            ->assertOk()->assertJsonPath('id', $user->id);
    }

    public function test_public_api_still_uses_its_existing_contract_without_authentication(): void
    {
        $this->getJson('/api/v1/public/matches')
            ->assertStatus(400)->assertJson([
                'success' => false,
                'message' => 'Domain parameter is required',
            ])->assertHeader('Access-Control-Allow-Origin', '*');
    }

    public function test_login_limits_are_normalized_and_return_retry_after(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson(self::BASE.'/login', [
                'email' => $attempt % 2 === 0 ? 'MISSING@EXAMPLE.TEST' : ' missing@example.test ',
                'password' => 'wrong',
                'device_name' => 'Android',
            ])->assertUnauthorized();
        }

        $response = $this->postJson(self::BASE.'/login', [
            'email' => 'missing@example.test',
            'password' => 'wrong',
            'device_name' => 'Android',
        ])->assertTooManyRequests()->assertHeader('Retry-After');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_registration_limits_requests_per_ip(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson(self::BASE.'/register', [])->assertUnprocessable();
        }

        $this->postJson(self::BASE.'/register', [])
            ->assertTooManyRequests()->assertHeader('Retry-After');
    }

    public function test_login_also_limits_requests_with_different_emails_from_the_same_ip(): void
    {
        for ($attempt = 0; $attempt < 20; $attempt++) {
            $this->postJson(self::BASE.'/login', [
                'email' => 'missing'.$attempt.'@example.test',
                'password' => 'wrong',
                'device_name' => 'Android',
            ])->assertUnauthorized();
        }

        $this->postJson(self::BASE.'/login', [
            'email' => 'another@example.test',
            'password' => 'wrong',
            'device_name' => 'Android',
        ])->assertTooManyRequests()->assertHeader('Retry-After');
    }

    public function test_registration_also_limits_requests_over_an_hour(): void
    {
        for ($minute = 0; $minute < 4; $minute++) {
            for ($attempt = 0; $attempt < 5; $attempt++) {
                $this->postJson(self::BASE.'/register', [])->assertUnprocessable();
            }
            $this->travel(61)->seconds();
        }

        $this->postJson(self::BASE.'/register', [])
            ->assertTooManyRequests()->assertHeader('Retry-After');
    }

    public function test_authenticated_requests_are_limited_per_user_across_devices(): void
    {
        $user = $this->user();
        $token = $this->token($user);

        for ($attempt = 0; $attempt < 60; $attempt++) {
            $this->getMe($token)->assertOk();
        }

        $this->getMe($this->token($user))->assertTooManyRequests()->assertHeader('Retry-After');
    }

    public function test_errors_are_json_even_without_an_accept_header(): void
    {
        $this->get(self::BASE.'/me')->assertUnauthorized()->assertJsonStructure(['message']);
        $this->post(self::BASE.'/register', [])->assertUnprocessable()->assertJsonStructure(['message', 'errors']);
    }

    public function test_web_role_migration_preserves_existing_roles_and_blocks_unsafe_rollback(): void
    {
        $this->user(['role' => 'master']);
        $this->user(['email' => 'web@example.test']);
        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No se puede retirar el rol web');
        $migration->down();
    }

    public function test_web_role_migration_can_be_rolled_back_without_web_users(): void
    {
        $user = $this->user(['role' => 'master']);
        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->down();

        $this->assertSame('master', $user->fresh()->role);
        $this->assertFalse(Role::where('name', 'web')->exists());
        $this->assertTrue(Schema::hasColumn('users', 'role'));
        $migration->up();
        $this->assertTrue(Role::where('name', 'web')->exists());
        $this->assertSame('master', $user->fresh()->role);
    }

    private function mysqlRoleColumn(array $overrides = []): void
    {
        $this->databaseManager = DB::getFacadeRoot();
        $connection = DB::connection();
        DB::partialMock();
        DB::shouldReceive('connection')->andReturn($connection);
        DB::shouldReceive('getDriverName')->andReturn('mysql');
        DB::shouldReceive('selectOne')->once()->withArgs(function (string $sql, array $bindings): bool {
            return str_starts_with($sql, 'SHOW FULL COLUMNS FROM ') && $bindings === ['role'];
        })->andReturn((object) array_merge([
            'Type' => "enum('master','school_admin','coach','student','judge','custom,role','coach\\'s')",
            'Null' => 'NO',
            'Default' => 'student',
            'Collation' => 'utf8mb4_unicode_ci',
            'Comment' => 'Roles existentes',
            'Extra' => '',
        ], $overrides));
    }

    public function test_mysql_migration_preserves_every_existing_enum_value_and_column_attribute(): void
    {
        $this->mysqlRoleColumn();
        DB::shouldReceive('statement')->once()->withArgs(function (string $sql): bool {
            return str_contains($sql, "enum('master','school_admin','coach','student','judge','custom,role','coach\\'s','web')")
                && str_contains($sql, "COLLATE `utf8mb4_unicode_ci` NOT NULL DEFAULT 'student' COMMENT 'Roles existentes'");
        })->andReturn(true);

        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->up();
        $this->assertTrue(Role::where('name', 'web')->exists());
    }

    public function test_mysql_migration_preserves_nullable_column_and_null_default(): void
    {
        $this->mysqlRoleColumn(['Null' => 'YES', 'Default' => null]);
        DB::shouldReceive('statement')->once()->withArgs(function (string $sql): bool {
            return str_contains($sql, "COLLATE `utf8mb4_unicode_ci` NULL DEFAULT NULL COMMENT 'Roles existentes'");
        })->andReturn(true);

        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->up();
        $this->assertTrue(Role::where('name', 'web')->exists());
    }

    public function test_mysql_migration_can_retry_when_web_is_already_in_the_enum(): void
    {
        $this->mysqlRoleColumn(['Type' => "enum('master','judge','web')"]);
        DB::shouldReceive('statement')->never();

        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->up();
        $this->assertTrue(Role::where('name', 'web')->exists());
    }

    public function test_mysql_rollback_removes_only_web_and_preserves_custom_roles(): void
    {
        $this->mysqlRoleColumn(['Type' => "enum('master','web','student','judge')"]);
        DB::shouldReceive('statement')->once()->withArgs(function (string $sql): bool {
            return str_contains($sql, "enum('master','student','judge')")
                && str_contains($sql, "NOT NULL DEFAULT 'student'");
        })->andReturn(true);

        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->down();
        $this->assertFalse(Role::where('name', 'web')->exists());
    }

    public function test_mysql_rollback_does_not_remove_a_default_web_role(): void
    {
        $this->mysqlRoleColumn(['Type' => "enum('student','web')", 'Default' => 'web']);
        DB::shouldReceive('statement')->never();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No se puede retirar web mientras sea el rol predeterminado.');
        $migration = require database_path('migrations/2026_10_08_180000_add_web_role_to_users.php');
        $migration->down();
    }
}
