@php
    $displayDate = $match->status === 'completed' ? ($match->played_at ?? $match->scheduled_at) : $match->scheduled_at;
@endphp
<article wire:key="summary-match-{{ $match->id }}" class="match-card match-card--summary">
    <div class="match-card__meta">
        @if($match->phase)
            <span>{{ $match->phase->name }}</span>
        @endif
        @if($match->round)
            <span>Jornada {{ $match->round }}</span>
        @endif
        @if($displayDate)
            <time datetime="{{ $displayDate->toIso8601String() }}">{{ $displayDate->format('d/m · H:i') }}</time>
        @else
            <span>Fecha por definir</span>
        @endif
        @if($match->location)
            <span>{{ $match->location }}</span>
        @endif
        <span class="match-card__status">{{ $match->statusLabel() }}</span>
    </div>
    <div class="match-card__board">
        <div class="match-card__team match-card__team--home">
            <span class="match-card__team-name">{{ $match->homeTeam?->displayName() ?? 'Local por definir' }}</span>
        </div>
        <div class="match-card__score-wrap">
            @if($match->status === 'completed')
                <div class="match-card__score" aria-label="Resultado">
                    <span class="match-card__score-num">{{ ($match->home_score ?? 0) + ($match->home_score_extra ?? 0) }}</span>
                    <span class="match-card__score-sep">–</span>
                    <span class="match-card__score-num">{{ ($match->away_score ?? 0) + ($match->away_score_extra ?? 0) }}</span>
                </div>
                @if($match->penalty_winner)
                    <span class="match-card__penalties">Penaltis: {{ $match->penalty_winner === 'home' ? ($match->homeTeam?->displayName() ?? 'Local') : ($match->awayTeam?->displayName() ?? 'Visitante') }}</span>
                @endif
            @else
                <span class="match-card__versus">VS</span>
            @endif
        </div>
        <div class="match-card__team match-card__team--away">
            <span class="match-card__team-name">{{ $match->awayTeam?->displayName() ?? 'Visitante por definir' }}</span>
        </div>
    </div>
</article>
