@extends('livewire.webclubs.layouts.app', ['title' => 'Cuéntanos tu historia - ' . tenantName()])

@section('content')
<main class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-primary font-semibold uppercase tracking-wider text-sm">La memoria de nuestra afición</p>
                <h1 class="text-3xl sm:text-5xl font-bold mt-3">Cuéntanos tu historia</h1>
                <p class="text-gray-600 mt-4 max-w-2xl">Ese torneo inolvidable, tu primer partido, los amigos de siempre. Comparte los momentos que nos unen a {{ tenantName() }}.</p>
            </div>
            <a href="{{ route('webclubs.stories.create') }}" class="bg-primary text-white font-semibold px-6 py-3 rounded-full">+ Compartir mi historia</a>
        </div>
        @include('webclubs.stories._notice')
        <form method="get" action="{{ route('webclubs.stories.index') }}" class="flex flex-wrap items-end gap-3 mb-8">
            <div>
                <label for="category" class="block text-sm font-semibold mb-2">Explorar por categoría</label>
                <select id="category" name="category" class="rounded-lg border-gray-300">
                    <option value="">Todas las historias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="rounded-lg border border-gray-300 bg-white px-5 py-2">Filtrar</button>
        </form>
        @if($stories->isNotEmpty())
            <div class="flex gap-5 overflow-x-auto pb-6 mb-4" aria-label="Historias recientes">
                @foreach($stories as $story)
                    <a href="{{ route('webclubs.stories.show', $story) }}" class="flex-shrink-0 text-center w-24">
                        <div class="rounded-full border-4 border-primary p-1 w-20 h-20 mx-auto bg-white">
                            @if($story->media->first() && !$story->media->first()->isVideo())
                                <img src="{{ route('webclubs.stories.media', $story->media->first()) }}" alt="" loading="lazy" class="rounded-full w-full h-full object-cover">
                            @else
                                <span class="flex items-center justify-center rounded-full w-full h-full bg-gray-100 text-primary text-2xl font-bold">{{ mb_substr($story->author_name, 0, 1) }}</span>
                            @endif
                        </div>
                        <span class="block mt-2 text-sm truncate">{{ $story->author_name }}</span>
                    </a>
                @endforeach
            </div>
        @endif
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($stories as $story)
                <article class="rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm">
                    <a href="{{ route('webclubs.stories.show', $story) }}" class="block relative bg-gray-900">
                        @if($story->media->first())
                            @if($story->media->first()->isVideo())
                                <video src="{{ route('webclubs.stories.media', $story->media->first()) }}" preload="metadata" muted playsinline class="w-full h-72 object-cover" aria-label="Vídeo de {{ $story->title }}"></video>
                                <span class="absolute bottom-4 left-4 bg-black text-white rounded-full px-3 py-1 text-sm">Ver vídeo</span>
                            @else
                                <img src="{{ route('webclubs.stories.media', $story->media->first()) }}" alt="{{ $story->title }}" loading="lazy" class="w-full h-72 object-cover">
                            @endif
                            <span class="absolute top-4 right-4 rounded-full bg-black text-white px-3 py-1 text-sm">{{ $story->media->count() }} archivos</span>
                        @else
                            <div class="h-72 flex items-center justify-center bg-primary text-white text-7xl font-bold">{{ mb_substr($story->author_name, 0, 1) }}</div>
                        @endif
                    </a>
                    <div class="p-5">
                        <a href="{{ route('webclubs.stories.index', ['category' => $story->story_category_id]) }}" class="text-xs font-semibold text-primary">{{ $story->category->name }}</a>
                        <h2 class="font-bold text-xl mt-2"><a href="{{ route('webclubs.stories.show', $story) }}">{{ $story->title }}</a></h2>
                        <p class="text-sm text-gray-500 mt-2">{{ $story->author_name }} · {{ $story->published_at->format('d/m/Y') }}</p>
                        <p class="text-gray-600 mt-3">{{ \Illuminate\Support\Str::limit($story->body, 160) }}</p>
                        <div class="flex items-center justify-between border-t mt-5 pt-4 text-sm">
                            <span>{{ $story->approved_likes_count }} Me gusta · {{ $story->approved_comments_count }} comentarios</span>
                            <a class="text-primary font-semibold" href="{{ route('webclubs.stories.show', $story) }}">Ver historia</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 rounded-2xl bg-white border p-12 text-center">
                    <h2 class="font-bold text-2xl">Aquí empieza nuestra historia</h2>
                    <p class="text-gray-600 mt-3">Todavía no hay historias publicadas en esta selección. ¡Anímate a compartir la tuya!</p>
                </div>
            @endforelse
        </div>
        <div class="mt-8">{{ $stories->links() }}</div>
        <p class="text-center text-sm text-gray-500 mt-8">Todas las historias, comentarios y Me gusta se revisan antes de hacerse públicos.</p>
    </div>
</main>
@endsection
