@extends('livewire.webclubs.layouts.app', ['title' => 'Compartir mi historia - ' . tenantName()])

@section('content')
<main class="bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4">
        <a href="{{ route('webclubs.stories.index') }}" class="text-primary font-semibold">← Volver a las historias</a>
        <h1 class="text-3xl font-bold mt-6 mb-3">Comparte tu historia</h1>
        <p class="text-gray-600 mb-8">No necesitas registrarte. Revisaremos tu historia antes de publicarla. Tu correo es privado y solo se utiliza para gestionar el envío.</p>
        @include('webclubs.stories._notice')
        <form method="post" action="{{ route('webclubs.stories.store') }}" enctype="multipart/form-data" class="bg-white border rounded-2xl p-6 sm:p-8 space-y-6" data-story-upload>
            @csrf
            @include('webclubs.stories._identity')
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
                <textarea id="body" name="body" rows="8" required maxlength="10000" class="w-full rounded-lg border-gray-300">{{ old('body') }}</textarea>
            </div>
            <div>
                <label for="media" class="block font-semibold mb-2">Fotos y vídeos (opcional)</label>
                <input id="media" name="media[]" type="file" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/webm" class="w-full" aria-describedby="media-help media-error">
                <p id="media-help" class="text-sm text-gray-500 mt-2">Hasta 10 archivos: JPG, PNG y WebP (10 MB por imagen); MP4 y WebM (50 MB por vídeo). Aparecerán en el orden seleccionado. Si el envío tiene errores tendrás que seleccionarlos de nuevo.</p>
                <p id="media-error" data-upload-error role="alert" class="text-sm text-red-700 mt-2"></p>
                <ul data-upload-list class="text-sm text-gray-600 mt-2 space-y-1"></ul>
            </div>
            @include('webclubs.stories._consent')
            <button type="submit" class="bg-primary text-white font-semibold px-6 py-3 rounded-full">Enviar para revisión</button>
            <p data-upload-status role="status" class="text-sm text-gray-600"></p>
        </form>
    </div>
</main>
@endsection
