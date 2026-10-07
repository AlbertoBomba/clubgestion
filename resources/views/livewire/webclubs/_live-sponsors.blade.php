<footer class="live-sponsors" aria-label="Patrocinadores"
        wire:key="live-sponsors-{{ md5($liveSponsors->map(fn ($sponsor) => [$sponsor->id, $sponsor->name, $sponsor->logo])->toJson()) }}"
        wire:ignore x-data="liveSponsorCarousel({{ $liveSponsors->count() }})">
    <div class="live-sponsors__track" x-ref="track">
        @for ($copy = 0; $copy < 2; $copy++)
            <div class="live-sponsors__group" @if ($copy === 1) aria-hidden="true" @endif>
                <template x-for="repeat in repetitions" :key="repeat">
                    <div class="live-sponsors__set" :aria-hidden="repeat > 1 ? 'true' : 'false'">
                        @foreach ($liveSponsors as $sponsor)
                            <div class="live-sponsors__item">
                                <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                     alt="{{ $sponsor->name }}" class="live-sponsors__logo">
                            </div>
                        @endforeach
                    </div>
                </template>
            </div>
        @endfor
    </div>
</footer>
