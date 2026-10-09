<x-app-layout>
    <x-slot name="header"><h1 class="font-bold text-2xl">Revisar historia</h1></x-slot>
    <div class="max-w-5xl mx-auto py-8 px-4 space-y-8">
        <a href="{{ route('stories.index') }}" class="text-primary font-semibold">← Volver a moderación</a>
        @include('webclubs.stories._notice')
        <article class="bg-white border rounded-2xl p-6">
            <p class="text-primary font-semibold">{{ $story->category?->name }}</p>
            <h2 class="text-3xl font-bold mt-2">{{ $story->title }}</h2>
            <p class="text-sm text-gray-500 mt-3">{{ $story->author_name }} · {{ $story->author_email }} · {{ $story->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-sm font-semibold mt-3">Estado: {{ ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$story->status] }}</p>
            <p class="whitespace-pre-wrap break-words mt-6">{{ $story->body }}</p>
            <div class="grid sm:grid-cols-2 gap-4 mt-6">
                @foreach($story->media as $media)
                    <div class="bg-gray-900 rounded-xl overflow-hidden">
                        @if($media->isVideo())
                            <video controls playsinline preload="metadata" src="{{ route('webclubs.stories.media', $media) }}" class="w-full h-80 object-contain"></video>
                        @else
                            <a href="{{ route('webclubs.stories.media', $media) }}" target="_blank" rel="noopener">
                                <img src="{{ route('webclubs.stories.media', $media) }}" alt="Foto {{ $loop->iteration }} de la historia" loading="lazy" class="w-full h-80 object-contain">
                            </a>
                        @endif
                        <p class="text-white text-sm p-3">Archivo {{ $loop->iteration }} · {{ number_format($media->size / 1024 / 1024, 1) }} MB</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-gray-500">Al aprobar la historia se publican todos sus archivos y su categoría. Al retirarla, también se ocultan sus comentarios, Me gusta y archivos.</p>
            @include('stories._review', ['kind' => 'stories', 'item' => $story])
        </article>
        <section>
            <h2 class="text-2xl font-bold mb-4">Comentarios</h2>
            @forelse($comments as $comment)
                <article class="bg-white border rounded-xl p-5 mb-4">
                    <p class="font-semibold">{{ $comment->author_name }} · {{ $comment->author_email }}</p>
                    <p class="text-sm text-gray-500">{{ ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$comment->status] }}</p>
                    <p class="whitespace-pre-wrap break-words mt-3">{{ $comment->body }}</p>
                    @include('stories._review', ['kind' => 'comments', 'item' => $comment])
                </article>
            @empty
                <p class="text-gray-500">Sin comentarios recibidos.</p>
            @endforelse
            {{ $comments->links() }}
        </section>
        <section>
            <h2 class="text-2xl font-bold mb-4">Me gusta</h2>
            @forelse($likes as $like)
                <article class="bg-white border rounded-xl p-5 mb-4">
                    <p class="font-semibold">Me gusta #{{ $like->id }} · {{ $like->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-sm text-gray-500">{{ ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$like->status] }} · visitante anónimo</p>
                    @include('stories._review', ['kind' => 'likes', 'item' => $like])
                </article>
            @empty
                <p class="text-gray-500">Sin Me gusta recibidos.</p>
            @endforelse
            {{ $likes->links() }}
        </section>
    </div>
</x-app-layout>
