<?php

namespace Tests\Feature;

use App\Models\ClubStory;
use App\Models\SportsSchool;
use App\Models\StoryCategory;
use App\Models\StoryMedia;
use App\Models\User;
use App\Services\ClubStorySubmission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ClubStoriesTest extends TestCase
{
    private SportsSchool $school;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'club_story_tests',
            'database.connections.club_story_tests' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'cache.default' => 'array',
            'session.driver' => 'array',
            'app.key' => 'base64:'.base64_encode(random_bytes(32)),
        ]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_11_24_111219_add_two_factor_columns_to_users_table.php',
            '2025_11_25_112454_create_sports_schools_table.php',
            '2025_11_25_112501_add_sports_school_fields_to_users_table.php',
            '2025_11_25_114450_create_permission_tables.php',
            '2026_02_11_000001_add_domain_to_sports_schools_table.php',
            '2026_10_09_110000_create_club_stories_tables.php',
        ] as $migration) {
            (require database_path('migrations/'.$migration))->up();
        }
        $this->withoutVite();
        Storage::fake('story-media');
        $this->school = SportsSchool::create(['name' => 'Club Historias', 'domain' => 'localhost', 'is_active' => true]);
        tenantService()->setCurrentSchool($this->school);
    }

    protected function tearDown(): void
    {
        DB::purge('club_story_tests');
        parent::tearDown();
    }

    private function submission(array $overrides = []): array
    {
        return array_merge([
            'author_name' => 'Aficionado', 'author_email' => 'private@example.test',
            'title' => 'Nuestro torneo inolvidable', 'body' => 'Una historia del club.',
            'category' => 'Torneo alevín', 'consent' => '1',
        ], $overrides);
    }

    private function story(bool $approved = false, ?SportsSchool $school = null): ClubStory
    {
        $story = app(ClubStorySubmission::class)->store(($school ?? $this->school)->id, $this->submission(), []);
        if ($approved) {
            $story->update(['status' => 'approved', 'published_at' => now()]);
        }

        return $story;
    }

    private function moderator(?SportsSchool $school = null, string $role = 'school_admin'): User
    {
        Role::findOrCreate($role, 'web');
        $user = User::factory()->create([
            'sports_school_id' => ($school ?? $this->school)->id,
            'role' => $role, 'is_active' => true,
        ]);
        $user->assignRole($role);

        return $user;
    }

    public function test_submission_is_pending_and_media_and_category_are_not_public(): void
    {
        $this->post('/historias', $this->submission([
            'status' => 'approved', 'sports_school_id' => 999,
            'media' => [UploadedFile::fake()->image('photo.jpg'), UploadedFile::fake()->create('clip.mp4', 200, 'video/mp4')],
        ]))->assertRedirect('/historias')->assertSessionHasNoErrors();
        $story = ClubStory::firstOrFail();
        $this->assertSame('pending', $story->status);
        $this->assertEquals($this->school->id, $story->sports_school_id);
        $this->assertCount(2, $story->media);
        $this->assertTrue($story->media[1]->isVideo());
        Storage::disk('story-media')->assertExists($story->media[0]->path);
        $this->get('/historias')->assertOk()->assertDontSee($story->title)->assertDontSee('Torneo alevín');
        $this->get("/historias/$story->id")->assertNotFound();
        $this->get('/historias/archivos/'.$story->media[0]->id)->assertNotFound();
    }

    public function test_categories_are_normalized_reused_and_isolated_by_club(): void
    {
        $this->story();
        app(ClubStorySubmission::class)->store($this->school->id, $this->submission(['category' => '  TORNEO   ALEVIN  ']), []);
        $this->assertSame(1, StoryCategory::count());
        $other = SportsSchool::create(['name' => 'Otro club', 'is_active' => true]);
        app(ClubStorySubmission::class)->store($other->id, $this->submission(), []);
        $this->assertSame(2, StoryCategory::withoutGlobalScopes()->count());
    }

    public function test_admin_can_review_story_with_all_media_and_publish_it(): void
    {
        $story = app(ClubStorySubmission::class)->store($this->school->id, $this->submission(), [UploadedFile::fake()->image('photo.png')]);
        $user = $this->moderator();
        $this->actingAs($user)->get('/gestion-historias')->assertOk()->assertSee($story->title);
        $this->get("/gestion-historias/$story->id")->assertOk()->assertSee('Foto 1');
        $this->get('/historias/archivos/'.$story->media->first()->id)->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        $this->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'approved', 'review_note' => 'Revisado'])->assertRedirect();
        $this->assertSame('approved', $story->fresh()->status);
        $this->assertEquals($user->id, $story->fresh()->reviewed_by);
        $this->assertNotNull($story->fresh()->published_at);
        auth()->forgetGuards();
        $this->get('/historias')->assertOk()->assertSee($story->title)->assertSee('Torneo alevín')->assertDontSee('private@example.test');
    }

    public function test_public_detail_displays_only_approved_comments_and_likes_and_escapes_content(): void
    {
        $story = $this->story(true);
        $story->update(['body' => '<script>alert(1)</script>']);
        foreach (['pending', 'approved', 'rejected'] as $status) {
            $story->comments()->create([
                'author_name' => 'Fan', 'author_email' => "$status@example.test", 'body' => "Comentario $status",
                'consented_at' => now(), 'status' => $status,
            ]);
            $story->likes()->create(['visitor_hash' => hash('sha256', $status), 'status' => $status]);
        }
        $this->get("/historias/$story->id")->assertOk()
            ->assertSee('Comentario approved')->assertDontSee('Comentario pending')->assertDontSee('Comentario rejected')
            ->assertSee('1 Me gusta')->assertDontSee('approved@example.test')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_comments_wait_for_moderation_and_cannot_target_unpublished_stories(): void
    {
        $pending = $this->story();
        $approved = $this->story(true);
        $data = ['author_name' => 'Fan', 'author_email' => 'fan@example.test', 'body' => 'Recuerdo nuevo', 'consent' => 1, 'status' => 'approved'];
        $this->post("/historias/$pending->id/comentarios", $data)->assertNotFound();
        $this->post("/historias/$approved->id/comentarios", $data)->assertRedirect()->assertSessionHasNoErrors();
        $comment = $approved->comments()->firstOrFail();
        $this->assertSame('pending', $comment->status);
        $this->get("/historias/$approved->id")->assertDontSee('Recuerdo nuevo');
        $this->actingAs($this->moderator())->post("/gestion-historias/comments/$comment->id/moderar", ['status' => 'approved'])->assertRedirect();
        $this->get("/historias/$approved->id")->assertSee('Recuerdo nuevo')->assertDontSee('fan@example.test');
    }

    public function test_likes_are_unique_per_browser_pending_and_moderated(): void
    {
        $story = $this->story(true);
        $visitor = (string) Str::uuid();
        $this->withCookie('story_visitor', $visitor)->post("/historias/$story->id/me-gusta")->assertRedirect();
        $this->post("/historias/$story->id/me-gusta")->assertRedirect();
        $this->assertSame(1, $story->likes()->count());
        $like = $story->likes()->firstOrFail();
        $this->assertSame('pending', $like->status);
        $this->assertSame(64, strlen($like->visitor_hash));
        $this->assertNotSame($visitor, $like->visitor_hash);
        $this->get("/historias/$story->id")->assertSee('0 Me gusta');
        $this->actingAs($this->moderator())->post("/gestion-historias/likes/$like->id/moderar", ['status' => 'approved'])->assertRedirect();
        $this->get("/historias/$story->id")->assertSee('1 Me gusta');
        $this->post("/gestion-historias/likes/$like->id/moderar", ['status' => 'rejected'])->assertRedirect();
        $this->get("/historias/$story->id")->assertSee('0 Me gusta');
    }

    public function test_missing_browser_cookie_is_rejected_and_public_pages_set_it(): void
    {
        $story = $this->story(true);
        $this->post("/historias/$story->id/me-gusta")->assertStatus(422);
        $this->get('/historias')->assertCookie('story_visitor');
        $this->get("/historias/$story->id")->assertCookie('story_visitor');
        $this->assertSame(0, $story->likes()->count());
    }

    public function test_other_clubs_cannot_read_interact_or_moderate_a_story_or_its_media(): void
    {
        $story = app(ClubStorySubmission::class)->store($this->school->id, $this->submission(), [UploadedFile::fake()->image('photo.jpg')]);
        $story->update(['status' => 'approved', 'published_at' => now()]);
        $other = SportsSchool::create(['name' => 'Otro club', 'is_active' => true]);
        $this->school->update(['domain' => null]);
        tenantService()->setCurrentSchool($other);
        $this->get("/historias/$story->id")->assertNotFound();
        $this->get('/historias/archivos/'.$story->media->first()->id)->assertNotFound();
        $this->post("/historias/$story->id/comentarios", [])->assertNotFound();
        $this->post("/historias/$story->id/me-gusta")->assertNotFound();
        $this->actingAs($this->moderator($other))->get("/gestion-historias/$story->id")->assertNotFound();
        $this->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'rejected'])->assertNotFound();
        $this->assertSame('approved', $story->fresh()->status);
    }

    public function test_coaches_and_inactive_admins_cannot_moderate(): void
    {
        $story = $this->story();
        $this->actingAs($this->moderator(role: 'coach'))->get('/gestion-historias')->assertForbidden();
        $this->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'approved'])->assertForbidden();
        $admin = $this->moderator();
        $admin->update(['is_active' => false]);
        $this->actingAs($admin)->get('/gestion-historias')->assertForbidden();
    }

    public function test_retracting_a_story_hides_media_category_and_interactions(): void
    {
        $story = app(ClubStorySubmission::class)->store($this->school->id, $this->submission(), [UploadedFile::fake()->image('photo.jpg')]);
        $story->update(['status' => 'approved', 'published_at' => now()]);
        $mediaId = $story->media->first()->id;
        $this->get("/historias/archivos/$mediaId")->assertOk();
        $this->actingAs($this->moderator())->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'rejected'])->assertRedirect();
        $this->assertNull($story->fresh()->published_at);
        $this->app['auth']->forgetGuards();
        $this->get("/historias/$story->id")->assertNotFound();
        $this->get("/historias/archivos/$mediaId")->assertNotFound();
        $this->get('/historias')->assertDontSee('Torneo alevín');
    }

    public function test_category_filter_and_pagination_are_applied(): void
    {
        $first = $this->story(true);
        $second = app(ClubStorySubmission::class)->store($this->school->id, $this->submission([
            'title' => 'Otra categoría', 'category' => 'Primer partido',
        ]), []);
        $second->update(['status' => 'approved', 'published_at' => now()]);
        $this->get('/historias?category='.$first->story_category_id)->assertOk()->assertSee($first->title)->assertDontSee('Otra categoría');
        for ($i = 0; $i < 12; $i++) {
            $this->story(true);
        }
        $response = $this->get('/historias')->assertOk();
        $this->assertCount(12, $response['stories']);
        $this->assertSame(14, $response['stories']->total());
        $this->get('/historias?page=2')->assertOk();
    }

    public function test_limits_accept_exact_image_and_video_thresholds_and_ten_files(): void
    {
        $files = [UploadedFile::fake()->create('image.jpg', 10240, 'image/jpeg'), UploadedFile::fake()->create('video.mp4', 51200, 'video/mp4')];
        for ($i = 0; $i < 8; $i++) {
            $files[] = UploadedFile::fake()->image("photo$i.png");
        }
        $this->post('/historias', $this->submission(['media' => $files]))->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(10, StoryMedia::count());
    }

    public function test_limits_reject_oversized_images_videos_and_more_than_ten_files(): void
    {
        $this->post('/historias', $this->submission(['media' => [
            UploadedFile::fake()->create('image.jpg', 10241, 'image/jpeg'),
            UploadedFile::fake()->create('video.mp4', 51201, 'video/mp4'),
        ]]))->assertSessionHasErrors(['media.0', 'media.1']);
        $files = [];
        for ($i = 0; $i < 11; $i++) {
            $files[] = UploadedFile::fake()->image("photo$i.png");
        }
        $this->post('/historias', $this->submission(['media' => $files]))->assertSessionHasErrors('media');
        $this->assertSame(0, ClubStory::count());
    }

    public function test_consent_honeypot_disallowed_files_and_required_fields_are_validated(): void
    {
        $this->post('/historias', $this->submission([
            'consent' => 0, 'website' => 'spam', 'title' => '', 'category' => '',
            'media' => [UploadedFile::fake()->create('script.svg', 1, 'image/svg+xml')],
        ]))->assertSessionHasErrors(['consent', 'website', 'title', 'category', 'media.0']);
        $this->assertSame(0, ClubStory::count());
    }

    public function test_storage_failure_rolls_back_database_and_cleans_uploaded_files(): void
    {
        StoryMedia::creating(function () {
            throw new RuntimeException('Simulated persistence failure');
        });
        try {
            app(ClubStorySubmission::class)->store($this->school->id, $this->submission(), [UploadedFile::fake()->image('photo.jpg')]);
            $this->fail('Storage failure must not be reported as success.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Simulated persistence failure', $exception->getMessage());
            $this->assertSame(0, ClubStory::count());
            $this->assertSame(0, StoryCategory::count());
            $this->assertSame([], Storage::disk('story-media')->allFiles());
        } finally {
            StoryMedia::flushEventListeners();
        }
    }

    public function test_public_pages_without_a_club_do_not_expose_all_stories(): void
    {
        $this->story(true);
        $this->school->update(['domain' => null]);
        tenantService()->setCurrentSchool(null);
        $this->get('/historias')->assertNotFound();
        $this->get('/historias/compartir')->assertNotFound();
        $this->post('/historias', $this->submission())->assertForbidden();
    }

    public function test_submission_rate_limit_blocks_excessive_requests(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/historias', $this->submission())->assertRedirect();
        }
        $this->post('/historias', $this->submission())->assertStatus(429);
        $this->assertSame(3, ClubStory::count());
    }

    public function test_media_supports_byte_ranges_and_is_not_publicly_cacheable(): void
    {
        $story = app(ClubStorySubmission::class)->store($this->school->id, $this->submission(), [UploadedFile::fake()->image('photo.jpg')]);
        $story->update(['status' => 'approved', 'published_at' => now()]);
        $this->get('/historias/archivos/'.$story->media->first()->id, ['Range' => 'bytes=0-9'])
            ->assertStatus(206)->assertHeader('Content-Length', '10')
            ->assertHeader('Cache-Control', 'no-store, private')->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_admin_lists_are_scoped_to_the_user_school_even_on_another_club_domain(): void
    {
        $story = $this->story();
        $comment = $story->comments()->create([
            'author_name' => 'Fan', 'author_email' => 'fan@example.test',
            'body' => 'Comentario propio', 'consented_at' => now(),
        ]);
        $other = SportsSchool::create(['name' => 'Otro club', 'is_active' => true]);
        $otherStory = $this->story(true, $other);
        $otherComment = $otherStory->comments()->create([
            'author_name' => 'Otro fan', 'author_email' => 'other@example.test',
            'body' => 'Comentario ajeno', 'consented_at' => now(),
        ]);
        $otherLike = $otherStory->likes()->create(['visitor_hash' => hash('sha256', 'other')]);
        $this->school->update(['domain' => null]);
        $other->update(['domain' => 'localhost']);
        tenantService()->setCurrentSchool($other);
        $this->actingAs($this->moderator())->get('/gestion-historias?kind=comments')
            ->assertOk()->assertSee('Comentario propio')->assertDontSee('Comentario ajeno');
        $this->get("/gestion-historias/$story->id")->assertOk()->assertSee('Torneo alevín');
        $this->post("/gestion-historias/comments/$otherComment->id/moderar", ['status' => 'approved'])->assertNotFound();
        $this->post("/gestion-historias/likes/$otherLike->id/moderar", ['status' => 'approved'])->assertNotFound();
        $this->post("/gestion-historias/comments/$comment->id/moderar", ['status' => 'approved'])->assertRedirect();
    }

    public function test_invalid_reviews_and_comment_consent_are_rejected(): void
    {
        $story = $this->story(true);
        $this->post("/historias/$story->id/comentarios", [
            'author_name' => 'Fan', 'author_email' => 'bad email',
            'body' => str_repeat('x', 2001), 'consent' => 0, 'website' => 'spam',
        ])->assertSessionHasErrors(['author_email', 'body', 'consent', 'website']);
        $this->assertSame(0, $story->comments()->count());
        $this->actingAs($this->moderator())->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'unknown'])
            ->assertSessionHasErrors('status');
        $this->assertSame('approved', $story->fresh()->status);
    }

    public function test_anonymous_users_cannot_access_moderation(): void
    {
        $story = $this->story();
        $this->get('/gestion-historias')->assertRedirect('/login');
        $this->post("/gestion-historias/stories/$story->id/moderar", ['status' => 'approved'])->assertRedirect('/login');
        $this->assertSame('pending', $story->fresh()->status);
    }
}
