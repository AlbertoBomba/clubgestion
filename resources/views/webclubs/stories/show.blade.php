@extends('livewire.webclubs.layouts.app', ['title' => $story->title . ' - ' . tenantName()])

@section('content')
<main class="bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <a href="{{ route('webclubs.stories.index') }}" class="text-primary font-semibold">← Todas las historias</a>
        <div class="mt-6">@include('webclubs.stories._notice')</div>
        <div class="grid md:grid-cols-2 gap-8 items-start">
            <div>@include('webclubs.stories._viewer')</div>
            <article class="bg-white border rounded-2xl p-6">
                <a href="{{ route('webclubs.stories.index', ['category' => $story->story_category_id]) }}" class="text-primary text-sm font-semibold">{{ $story->category->name }}</a>
                <h1 class="text-3xl font-bold mt-3">{{ $story->title }}</h1>
                <p class="text-gray-500 text-sm mt-3">{{ $story->author_name }} · {{ $story->published_at->format('d/m/Y') }}</p>
                <p class="whitespace-pre-wrap break-words mt-6 text-gray-700">{{ $story->body }}</p>
                <div class="border-t mt-6 pt-6">
                    <p class="font-semibold mb-3">{{ $story->approved_likes_count }} Me gusta</p>
                    @if($likeStatus)
                        <p class="text-sm text-gray-600">
                            @if($likeStatus === 'approved') Tu Me gusta ha sido aprobado.
                            @elseif($likeStatus === 'pending') Tu Me gusta está pendiente de revisión.
                            @else Tu Me gusta no ha sido aprobado por el club.
                            @endif
                        </p>
                    @else
                        <form method="post" action="{{ route('webclubs.stories.like', $story) }}">
                            @csrf
                            <button class="bg-primary text-white rounded-full px-5 py-2 font-semibold">♡ Me gusta</button>
                        </form>
                        <p class="text-xs text-gray-500 mt-2">Un Me gusta por navegador. Se contabiliza después de su aprobación.</p>
                    @endif
                </div>
            </article>
        </div>
        <section class="max-w-3xl mx-auto mt-12" aria-label="Comentarios">
            <h2 class="text-2xl font-bold mb-6">Comentarios</h2>
            <div class="space-y-4">
                @forelse($comments as $comment)
                    <article class="bg-white border rounded-xl p-5">
                        <p class="font-semibold">{{ $comment->author_name }} <span class="font-normal text-sm text-gray-500">· {{ $comment->created_at->format('d/m/Y') }}</span></p>
                        <p class="whitespace-pre-wrap break-words mt-3 text-gray-700">{{ $comment->body }}</p>
                    </article>
                @empty
                    <p class="text-gray-500">Todavía no hay comentarios publicados. Comparte tu recuerdo.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $comments->links() }}</div>
            <form method="post" action="{{ route('webclubs.stories.comment', $story) }}" class="bg-white border rounded-2xl p-6 space-y-5 mt-8">
                @csrf
                <h3 class="text-xl font-bold">Añadir un comentario</h3>
                <p class="text-sm text-gray-500">El club revisará tu comentario antes de publicarlo. Tu correo no se mostrará.</p>
                @include('webclubs.stories._identity')
                <div>
                    <label for="body" class="block font-semibold mb-2">Tu comentario</label>
                    <textarea id="body" name="body" required maxlength="2000" rows="4" class="w-full rounded-lg border-gray-300">{{ old('body') }}</textarea>
                </div>
                @include('webclubs.stories._consent')
                <button class="bg-primary text-white rounded-full px-6 py-3 font-semibold">Enviar para revisión</button>
            </form>
        </section>
    </div>
</main>
@endsection
