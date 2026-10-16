@extends('livewire.webclubs.layouts.app', ['title' => 'Compartir mi historia - ' . tenantName()])

@section('content')
<main class="story-compose bg-gray-50 py-10 sm:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <a href="{{ route('webclubs.stories.index') }}" class="text-primary font-semibold">← Volver a las historias</a>
        <div class="grid lg:grid-cols-3 gap-8 lg:gap-12 mt-8">
        <aside class="lg:col-span-1">
            <span class="story-compose-badge">LOS RECUERDOS NOS UNEN</span>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight mt-5 mb-5">Tu historia también es parte del club.</h1>
            <p class="text-gray-600 leading-relaxed">Una grada, un gol, un equipo para siempre. Comparte ese momento que merece quedarse en la memoria de {{ tenantName() }}.</p>
            <div class="story-compose-note mt-8">
                <p class="font-bold">De tu móvil a nuestra historia</p>
                <ol class="space-y-4 mt-5 text-sm text-gray-600">
                    <li><strong class="text-primary">01.</strong> Elige tus fotos o graba un vídeo.</li>
                    <li><strong class="text-primary">02.</strong> Ponle palabras a ese recuerdo.</li>
                    <li><strong class="text-primary">03.</strong> El club lo revisa antes de publicarlo.</li>
                </ol>
            </div>
            <p class="text-sm text-gray-500 mt-6">Sin registro. Nombre y correo opcionales. Puedes compartir tu historia como Anónimo.</p>
        </aside>
        <div class="lg:col-span-2 min-w-0">
        @include('webclubs.stories._notice')
        <form method="post" action="{{ route('webclubs.stories.store') }}" enctype="multipart/form-data" class="story-compose-card bg-white rounded-2xl p-5 sm:p-8 space-y-8" data-story-upload>
            @csrf
            <section aria-labelledby="story-media-heading">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <h2 id="story-media-heading" class="text-xl font-bold">Dale vida a tu recuerdo</h2>
                    <span data-upload-count class="text-sm text-gray-500" aria-live="polite">0 / 10 archivos</span>
                </div>
                <div class="story-upload-zone">
                    <svg class="w-10 h-10 mx-auto text-primary mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4 4 4 4-6 4 6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1zM8 8h.01"/></svg>
                    <p class="font-semibold text-lg">Hay momentos que se cuentan mejor con imágenes</p>
                    <p class="text-sm text-gray-500 mt-2 mb-5">Añade varias fotos y vídeos, juntos o poco a poco.</p>
                    <label for="media" class="block text-sm font-semibold mb-2 text-left">Seleccionar fotos y vídeos</label>
                    <input id="media" name="media[]" type="file" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/webm,video/quicktime,.mov" class="story-file-input w-full text-sm" aria-describedby="media-help media-error">
                    <div data-capture-control hidden class="mt-4">
                        <button type="button" data-record-video class="story-record-button">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 8l5-3v14l-5-3M4 6h10a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/></svg>
                            Grabar vídeo con el móvil
                        </button>
                        <input data-video-capture type="file" accept="video/*" capture="environment" hidden disabled aria-label="Grabar un vídeo">
                        <p class="text-xs text-gray-500 mt-2">La cámara se abrirá en móviles compatibles; en otros dispositivos podrás elegir un vídeo.</p>
                    </div>
                </div>
                <p id="media-help" class="text-xs text-gray-500 leading-relaxed mt-3">Opcional · Hasta 10 archivos. JPG, PNG y WebP: 10 MB por foto. MP4, WebM y MOV (iPhone): 50 MB por vídeo. La reproducción depende del formato y del navegador. Si el envío tiene errores, selecciona los archivos de nuevo.</p>
                <p id="media-error" data-upload-error role="alert" class="text-sm text-red-700 mt-2"></p>
                <ul data-upload-list class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4" aria-label="Archivos seleccionados"></ul>
            </section>
            <section class="space-y-5 border-t border-gray-100 pt-6" aria-labelledby="story-text-heading">
            <h2 id="story-text-heading" class="text-xl font-bold">Ponle palabras a tu historia</h2>
            <div>
                <label for="title" class="block font-semibold mb-2">Título de tu historia</label>
                <input id="title" name="title" value="{{ old('title') }}" required maxlength="150" class="w-full rounded-lg border-gray-300" placeholder="Un torneo que nunca olvidaremos">
            </div>
            <div>
                <label for="category" class="block font-semibold mb-2">Categoría</label>
                <input id="category" name="category" list="story-categories" value="{{ old('category') }}" required maxlength="100" class="w-full rounded-lg border-gray-300" placeholder="Por ejemplo: Torneo alevín">
                <datalist id="story-categories">
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}"></option>
                    @endforeach
                </datalist>
                <p class="text-sm text-gray-500 mt-2">Elige una existente o escribe una nueva. La nueva categoría será pública cuando se apruebe una historia en ella.</p>
            </div>
            <div>
                <label for="body" class="block font-semibold mb-2">Cuéntanos lo que pasó</label>
                <textarea id="body" name="body" rows="6" required maxlength="10000" class="w-full rounded-lg border-gray-300" placeholder="¿Cuándo ocurrió? ¿Con quién estabas? ¿Qué hizo especial ese momento?">{{ old('body') }}</textarea>
            </div>
            </section>
            <section class="space-y-5 border-t border-gray-100 pt-6" aria-labelledby="story-author-heading">
            <h2 id="story-author-heading" class="text-xl font-bold">¿Quién está detrás del recuerdo?</h2>
            @include('webclubs.stories._identity')
            @include('webclubs.stories._consent')
            </section>
            <div class="border-t border-gray-100 pt-6">
                <button type="submit" class="story-submit bg-primary text-white font-semibold px-8 py-4 rounded-xl w-full sm:w-auto">Compartir mi historia →</button>
                <p class="text-xs text-gray-500 mt-3">Tu historia se publicará cuando el club la apruebe.</p>
            </div>
            <p data-upload-status role="status" class="text-sm text-gray-600"></p>
        </form>
        </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .story-compose { background-image: radial-gradient(ellipse at top left, #e8eef8, transparent 65%); }
    .story-compose-badge { display: inline-block; border: 1px solid #dbe2ec; border-radius: 999px; padding: .6rem 1rem; background: white; font-size: .65rem; font-weight: 800; letter-spacing: .13em; color: var(--color-primary); }
    .story-compose-note { background: #fff9; border: 1px solid white; border-radius: 1.25rem; padding: 1.5rem; }
    .story-compose-card { border: 1px solid #e5eaf1; box-shadow: 0 20px 60px -25px #182a4933; }
    .story-upload-zone { padding: 1.5rem; border: 2px dashed #ccd7e5; border-radius: 1rem; background: #f8fafc; text-align: center; }
    .story-file-input::file-selector-button { border: 0; border-radius: .6rem; padding: .7rem 1rem; margin-right: .75rem; background: var(--color-primary); color: white; cursor: pointer; }
    .story-record-button { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; border: 1px solid #cbd5e1; border-radius: .65rem; padding: .7rem 1rem; background: white; font-weight: 600; font-size: .875rem; }
    .story-compose input:not([type=checkbox]):not([type=file]), .story-compose textarea { background: #fafbfc; }
    .story-upload-preview { width: 100%; height: 9rem; object-fit: cover; background: #0f172a; }
    .story-upload-remove { position: absolute; top: .4rem; right: .4rem; width: 2rem; height: 2rem; border-radius: 999px; background: #0f172ae6; color: white; font-size: 1.2rem; }
    .story-submit { transition: opacity .2s, transform .2s; }
    .story-submit:hover { opacity: .9; transform: translateY(-1px); }
    .story-compose button:disabled { opacity: .6; cursor: wait; }
    @media (prefers-reduced-motion: reduce) { .story-submit { transition: none; } .story-submit:hover { transform: none; } }
</style>
@endpush
