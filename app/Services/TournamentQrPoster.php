<?php

namespace App\Services;

use App\Models\Tournament;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class TournamentQrPoster
{
    public function publicUrl(Tournament $tournament): string
    {
        $school = $tournament->sportsSchool;
        if (!$school) {
            throw ValidationException::withMessages(['qrPoster' => 'El torneo no tiene una escuela asociada.']);
        }

        $host = trim($school->domain ?? '');
        if ($host !== '') {
            $host = rtrim(preg_replace('#^https?://#i', '', $host), '/');
        } elseif (!empty($school->slug)) {
            $host = $school->slug . '.vaed.es';
        } else {
            throw ValidationException::withMessages(['qrPoster' => 'Configura el dominio o subdominio de la escuela antes de descargar el QR.']);
        }

        if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw ValidationException::withMessages(['qrPoster' => 'El dominio de la escuela no es válido. Revisa su configuración antes de descargar el QR.']);
        }

        return 'https://' . $host . route('webclubs.live.detail', $tournament, false);
    }

    public function pdf(Tournament $tournament): Mpdf
    {
        $publicUrl = $this->publicUrl($tournament);
        $writer = new Writer(new ImageRenderer(new RendererStyle(800, 40), new SvgImageBackEnd));
        $qrSvg = $writer->writeString($publicUrl, 'UTF-8', ErrorCorrectionLevel::M());
        $school = $tournament->sportsSchool;
        $clubLogo = null;
        $logoWidth = 0;
        $logoHeight = 0;
        if ($school->logo) {
            $disk = Storage::disk('public');
            if (!$disk->exists($school->logo)) {
                throw ValidationException::withMessages(['qrPoster' => 'No se encuentra el logo del club. Vuelve a subirlo en la configuración de la escuela.']);
            }
            $contents = $disk->get($school->logo);
            $dimensions = $contents ? getimagesizefromstring($contents) : false;
            if (!$dimensions) {
                throw ValidationException::withMessages(['qrPoster' => 'El logo del club no es una imagen válida. Revisa la imagen en la configuración de la escuela.']);
            }
            $scale = min(40 / $dimensions[0], 14 / $dimensions[1]);
            $logoWidth = $dimensions[0] * $scale;
            $logoHeight = $dimensions[1] * $scale;
            $clubLogo = 'data:' . $dimensions['mime'] . ';base64,' . base64_encode($contents);
        }
        $primaryColor = preg_match('/^#[0-9a-f]{6}$/i', $school->primary_color ?? '')
            ? $school->primary_color
            : '#176b51';

        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 8,
            'margin_bottom' => 8,
            'margin_left' => 8,
            'margin_right' => 8,
            'tempDir' => config('pdf.temp_dir') ?: storage_path('app'),
        ]);
        $pdf->SetTitle('Sigue en directo: ' . $tournament->name);
        $pdf->SetAuthor($tournament->sportsSchool->name);
        $pdf->showImageErrors = true;
        $pdf->WriteHTML(view('pdfs.tournament-qr', [
            'tournament' => $tournament,
            'school' => $tournament->sportsSchool,
            'publicUrl' => $publicUrl,
            'qrImage' => 'data:image/svg+xml;base64,' . base64_encode($qrSvg),
            'clubLogo' => $clubLogo,
            'logoWidth' => $logoWidth,
            'logoHeight' => $logoHeight,
            'primaryColor' => $primaryColor,
        ])->render());

        return $pdf;
    }
}
