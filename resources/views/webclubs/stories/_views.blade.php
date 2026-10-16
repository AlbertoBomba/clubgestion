@php($views = (int) ($media->views_count ?? 0))
<span class="{{ $class ?? '' }}" title="Reproducciones del vídeo">
    <span aria-hidden="true">👁</span>
    <span data-story-view-count="{{ $media->id }}">{{ number_format($views, 0, ',', '.') }} {{ $views === 1 ? 'reproducción' : 'reproducciones' }}</span>
</span>
