@if($story->media->isNotEmpty())
    <section data-story-viewer class="story-viewer rounded-2xl overflow-hidden bg-black text-white relative mx-auto" aria-label="Fotos y vídeos de la historia" tabindex="0">
        <div class="absolute top-0 inset-x-0 z-10 p-4 bg-gradient-to-b from-black to-transparent">
            <div class="flex gap-1 mb-3" aria-hidden="true">
                @foreach($story->media as $media)
                    <div class="h-1 flex-1 bg-gray-600 rounded-full overflow-hidden"><div data-story-progress class="bg-white h-full" style="width:0%"></div></div>
                @endforeach
            </div>
            <div class="flex justify-between gap-3 items-center">
                <span data-story-counter aria-live="polite" class="text-sm">1 / {{ $story->media->count() }}</span>
                <button type="button" data-story-play class="text-sm bg-black px-3 py-2 rounded-lg" aria-pressed="false">Reproducción automática</button>
            </div>
        </div>
        @foreach($story->media as $media)
            <div data-story-slide @if(!$loop->first) hidden @endif class="story-slide">
                @if($media->isVideo())
                    <video controls playsinline preload="metadata" class="w-full h-full object-contain" src="{{ route('webclubs.stories.media', $media) }}" aria-label="Vídeo {{ $loop->iteration }} de {{ $story->title }}"></video>
                @else
                    <img src="{{ route('webclubs.stories.media', $media) }}" alt="Foto {{ $loop->iteration }} de {{ $story->title }}" class="w-full h-full object-contain" @if(!$loop->first) loading="lazy" @endif>
                @endif
            </div>
        @endforeach
        <div class="absolute bottom-16 inset-x-0 flex justify-between px-3 pointer-events-none">
            <button type="button" data-story-prev class="pointer-events-auto bg-black rounded-full w-10 h-10 border border-gray-600" aria-label="Archivo anterior">←</button>
            <button type="button" data-story-next class="pointer-events-auto bg-black rounded-full w-10 h-10 border border-gray-600" aria-label="Archivo siguiente">→</button>
        </div>
    </section>
    <p class="text-sm text-gray-500 text-center mt-3">Usa las flechas, desliza a los lados o activa la reproducción automática.</p>
    <noscript>
        <div class="space-y-4 mt-4">
            @foreach($story->media->skip(1) as $media)
                @if($media->isVideo())
                    <video controls playsinline class="w-full" src="{{ route('webclubs.stories.media', $media) }}"></video>
                @else
                    <img src="{{ route('webclubs.stories.media', $media) }}" alt="{{ $story->title }}" class="w-full">
                @endif
            @endforeach
        </div>
    </noscript>
    @push('styles')
        <style>
            .story-viewer { width: 100%; max-width: 430px; }
            .story-slide { height: min(75vh, 740px); min-height: 320px; }
            .story-slide[hidden] { display: none; }
        </style>
    @endpush
@endif
