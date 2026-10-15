<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class StoryUploadLimitsTest extends TestCase
{
    public function test_oversized_story_post_returns_a_readable_413_before_session_or_tenant_middleware(): void
    {
        Log::shouldReceive('warning')->once()->with(
            'Story upload exceeded the PHP POST limit.',
            \Mockery::on(fn (array $context) => isset($context['content_length'], $context['post_max_size'])),
        );

        $this->call('POST', '/historias', [], [], [], ['CONTENT_LENGTH' => (string) PHP_INT_MAX])
            ->assertStatus(413)
            ->assertSee('No se ha guardado la historia.')
            ->assertSee('Volver a compartir mi historia')
            ->assertDontSee('PostTooLargeException');
    }

    public function test_oversized_json_story_post_preserves_the_413_status_and_json_contract(): void
    {
        Log::shouldReceive('warning')->once();

        $this->call('POST', '/historias', [], [], [], [
            'CONTENT_LENGTH' => (string) PHP_INT_MAX,
            'HTTP_ACCEPT' => 'application/json',
        ])->assertStatus(413)->assertJsonStructure(['message'])
            ->assertJsonFragment(['message' => 'El envío supera el tamaño total permitido por el servidor. No se ha guardado la historia. Vuelve al formulario y selecciona de nuevo los archivos, o contacta con el club si tu vídeo ocupa menos de 50 MB.']);
    }

    public function test_cgi_configuration_accepts_the_full_ten_video_batch_with_multipart_overhead(): void
    {
        $settings = parse_ini_file(public_path('.user.ini'));

        $this->assertSame('50M', $settings['upload_max_filesize']);
        $this->assertSame('520M', $settings['post_max_size']);
        $this->assertGreaterThan(10 * 50, (int) $settings['post_max_size']);
    }
}
