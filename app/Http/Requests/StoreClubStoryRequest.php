<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;

class StoreClubStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return currentSchool() !== null;
    }

    public function rules(): array
    {
        return [
            'author_name' => ['required', 'string', 'max:100'],
            'author_email' => ['required', 'email', 'max:255'],
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:10000'],
            'category' => ['required', 'string', 'max:100'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
            'media' => ['nullable', 'array', 'max:10'],
            'media.*' => ['required', 'file', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webm', 'max:51200'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            foreach ($this->file('media', []) as $index => $file) {
                if ($file instanceof UploadedFile && $file->isValid() && str_starts_with($file->getMimeType() ?? '', 'image/') && $file->getSize() > 10 * 1024 * 1024) {
                    $validator->errors()->add("media.$index", 'Cada imagen debe ocupar como máximo 10 MB.');
                }
            }
        }];
    }

    public function messages(): array
    {
        return [
            'media.max' => 'Puedes adjuntar como máximo 10 archivos.',
            'media.*.max' => 'Cada vídeo debe ocupar como máximo 50 MB.',
            'media.*.mimetypes' => 'Solo se permiten imágenes JPG, PNG, WebP y vídeos MP4 o WebM.',
            'consent.accepted' => 'Debes aceptar la publicación y confirmar que tienes permiso para compartir el contenido.',
            'website.max' => 'No se ha podido validar el envío.',
        ];
    }
}
