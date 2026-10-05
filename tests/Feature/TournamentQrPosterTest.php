<?php

namespace Tests\Feature;

use App\Livewire\Tournaments\Show;
use App\Models\SportsSchool;
use App\Models\Tournament;
use App\Models\User;
use App\Services\TournamentQrPoster;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Mpdf\Output\Destination;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class TournamentQrPosterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'qr_poster_tests',
            'database.connections.qr_poster_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);
        Schema::create('sports_schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain')->nullable();
            $table->string('slug')->nullable();
            $table->string('logo')->nullable();
            $table->string('primary_color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->string('status')->default('in_progress');
            $table->boolean('live')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        DB::purge('qr_poster_tests');
        parent::tearDown();
    }

    private function tournament(array $schoolAttributes = [], array $attributes = []): Tournament
    {
        $school = SportsSchool::create(array_merge([
            'name' => 'Escuela de fútbol',
            'domain' => 'club.example.test',
            'slug' => 'mi-escuela',
            'is_active' => true,
        ], $schoolAttributes));

        return Tournament::create(array_merge([
            'sports_school_id' => $school->id,
            'name' => 'Torneo de otoño',
            'live' => true,
            'status' => 'in_progress',
        ], $attributes));
    }

    private function show(Tournament $tournament): Show
    {
        $this->actingAs((new User)->forceFill(['id' => 7, 'sports_school_id' => $tournament->sports_school_id]));
        $component = new Show;
        $component->tournament = $tournament;

        return $component;
    }

    public function test_url_uses_school_domain_instead_of_admin_host(): void
    {
        $tournament = $this->tournament();
        $this->assertSame(
            'https://club.example.test/live/'.$tournament->id,
            app(TournamentQrPoster::class)->publicUrl($tournament)
        );
    }

    public function test_domain_with_scheme_and_trailing_slash_is_normalized(): void
    {
        foreach (['https://club.example.test/', 'http://club.example.test/', 'club.example.test/'] as $domain) {
            $tournament = $this->tournament(['domain' => $domain]);
            $this->assertSame(
                'https://club.example.test/live/'.$tournament->id,
                app(TournamentQrPoster::class)->publicUrl($tournament)
            );
        }
    }

    public function test_slug_is_used_when_custom_domain_is_empty(): void
    {
        $tournament = $this->tournament(['domain' => null]);
        $this->assertSame(
            'https://mi-escuela.vaed.es/live/'.$tournament->id,
            app(TournamentQrPoster::class)->publicUrl($tournament)
        );
    }

    public function test_missing_or_invalid_domain_is_reported(): void
    {
        $tournament = $this->tournament(['domain' => null]);
        foreach ([
            ['domain' => null, 'slug' => null],
            ['domain' => 'https://club.example.test/path', 'slug' => 'mi-escuela'],
            ['domain' => 'user@club.example.test', 'slug' => 'mi-escuela'],
            ['domain' => 'invalid domain', 'slug' => 'mi-escuela'],
        ] as $attributes) {
            $tournament->sportsSchool->forceFill($attributes);
            try {
                app(TournamentQrPoster::class)->publicUrl($tournament);
                $this->fail('Invalid school URLs must be rejected.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey('qrPoster', $exception->errors());
            }
        }
    }

    public function test_poster_is_single_page_a4_with_embedded_vector_qr_and_live_link(): void
    {
        $tournament = $this->tournament();
        $pdf = app(TournamentQrPoster::class)->pdf($tournament);
        $output = $pdf->Output('', Destination::STRING_RETURN);

        $this->assertSame(1, $pdf->page);
        $this->assertEqualsWithDelta(210, $pdf->w, 0.01);
        $this->assertEqualsWithDelta(297, $pdf->h, 0.01);
        $this->assertStringStartsWith('%PDF-', $output);
        $this->assertStringContainsString('/MediaBox [0 0 595.280 841.890]', $output);
        $this->assertStringContainsString('https://club.example.test/live/'.$tournament->id, $output);
        $this->assertNotEmpty($pdf->formobjects, 'The SVG QR must be embedded as a vector object.');
        $qr = array_values($pdf->formobjects)[0];
        $this->assertMatchesRegularExpression(
            '/([\d.]+) 0 0 -?([\d.]+) [\d.-]+ [\d.-]+ cm \/FO'.$qr['i'].' Do/',
            $pdf->pages[1]
        );
        preg_match(
            '/([\d.]+) 0 0 -?([\d.]+) [\d.-]+ [\d.-]+ cm \/FO'.$qr['i'].' Do/',
            $pdf->pages[1],
            $placement
        );
        $this->assertEqualsWithDelta(190, (float) $placement[1] * $qr['w'] / \Mpdf\Mpdf::SCALE, 0.2);
        $this->assertEqualsWithDelta(190, abs((float) $placement[2] * $qr['h']) / \Mpdf\Mpdf::SCALE, 0.2);
        $this->assertStringContainsString('Sigue en directo', $pdf->title);
    }

    public function test_download_response_has_pdf_content_and_filename(): void
    {
        $component = $this->show($this->tournament());
        $response = $component->exportQrPdf();

        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('qr_torneo_torneo-de-otono.pdf', $response->headers->get('Content-Disposition'));
        ob_start();
        $response->sendContent();
        $output = ob_get_clean();
        $this->assertStringStartsWith('%PDF-', $output);
        $this->assertFalse(session()->has('error'));
    }

    public function test_poster_embeds_club_logo_and_color_on_one_a4_page(): void
    {
        Storage::fake('public');
        $image = imagecreatetruecolor(240, 120);
        imagefill($image, 0, 0, imagecolorallocate($image, 20, 80, 60));
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);
        Storage::disk('public')->put('schools/logos/club.png', $contents);
        $tournament = $this->tournament([
            'logo' => 'schools/logos/club.png',
            'primary_color' => '#123abc',
        ]);
        $pdf = app(TournamentQrPoster::class)->pdf($tournament);
        $output = $pdf->Output('', Destination::STRING_RETURN);

        $this->assertSame(1, $pdf->page);
        $this->assertNotEmpty($pdf->images, 'The club logo must be embedded in the PDF.');
        $this->assertNotEmpty($pdf->formobjects, 'The QR must remain a separate vector image.');
        $this->assertStringContainsString('https://club.example.test/live/'.$tournament->id, $output);
    }

    public function test_missing_club_logo_shows_an_explicit_error(): void
    {
        Storage::fake('public');
        $tournament = $this->tournament(['logo' => 'schools/logos/missing.png']);

        $this->assertNull($this->show($tournament)->exportQrPdf());
        $this->assertStringContainsString('No se encuentra el logo del club', session('error'));
    }

    public function test_tall_logo_and_long_names_still_fit_one_page(): void
    {
        Storage::fake('public');
        $image = imagecreatetruecolor(100, 300);
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);
        Storage::disk('public')->put('schools/logos/tall.png', $contents);
        $tournament = $this->tournament([
            'logo' => 'schools/logos/tall.png',
            'name' => 'Club Deportivo Escuela Municipal de Fútbol',
        ], ['name' => 'Torneo Internacional de Fútbol Base Ciudad de Madrid 2026']);

        $pdf = app(TournamentQrPoster::class)->pdf($tournament);
        $pdf->Output('', Destination::STRING_RETURN);

        $this->assertSame(1, $pdf->page);
        $this->assertNotEmpty($pdf->images);
    }

    public function test_download_before_live_is_enabled_warns_without_changing_tournament(): void
    {
        $tournament = $this->tournament([], ['live' => false]);
        $response = $this->show($tournament)->exportQrPdf();

        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('activa Live', session('error'));
        $this->assertFalse($tournament->fresh()->live);
    }

    public function test_cancelled_tournament_and_inactive_school_also_warn(): void
    {
        foreach ([
            [[], ['status' => 'cancelled']],
            [['is_active' => false], []],
        ] as [$schoolAttributes, $attributes]) {
            $tournament = $this->tournament($schoolAttributes, $attributes);
            $response = $this->show($tournament)->exportQrPdf();
            $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
            $this->assertStringContainsString('el enlace aún no está disponible', session('error'));
        }
    }

    public function test_missing_domain_returns_visible_error_not_download(): void
    {
        $tournament = $this->tournament(['domain' => null]);
        $tournament->sportsSchool->forceFill(['slug' => null])->save();

        $this->assertNull($this->show($tournament)->exportQrPdf());
        $this->assertStringContainsString('Configura el dominio', session('error'));
    }

    public function test_other_school_cannot_download(): void
    {
        $component = $this->show($this->tournament());
        $this->actingAs((new User)->forceFill(['id' => 8, 'sports_school_id' => 999]));

        $this->expectException(HttpException::class);
        $component->exportQrPdf();
    }

    public function test_button_has_download_action_and_loading_state_in_both_variants(): void
    {
        foreach ([false, true] as $mobile) {
            $html = view('livewire.tournaments._download-qr', compact('mobile'))->render();
            $this->assertStringContainsString('wire:click="exportQrPdf"', $html);
            $this->assertStringContainsString('wire:loading.attr="disabled"', $html);
            $this->assertStringContainsString('Descargar QR del torneo en PDF A4', $html);
        }
    }
}
