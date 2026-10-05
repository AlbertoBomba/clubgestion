@php
    $winner = $match->winner();
    $showScore = in_array($match->status, ['completed', 'in_progress']);
@endphp
<div class="public-bracket-card" wire:key="public-bracket-match-{{ $match->id }}">
    <div class="public-bracket-meta">
        <span class="{{ $match->status === 'in_progress' ? 'public-bracket-live' : '' }}">{{ $match->statusLabel() }}</span>
        <span>{{ $match->scheduled_at?->format('d/m H:i') }}</span>
    </div>
    @foreach (['home', 'away'] as $side)
        @php
            $team = $side === 'home' ? $match->homeTeam : $match->awayTeam;
            $score = $side === 'home' ? $match->home_score : $match->away_score;
            $extra = $side === 'home' ? $match->home_score_extra : $match->away_score_extra;
            $isWinner = $winner && $team && $winner->id === $team->id;
        @endphp
        <div class="public-bracket-team {{ $isWinner ? 'public-bracket-winner' : '' }}">
            <span class="public-bracket-name" title="{{ $team?->displayName() ?? 'Por definir' }}">{{ $team?->displayName() ?? 'Por definir' }}</span>
            <strong style="flex-shrink: 0;">
                @if ($showScore)
                    {{ ($score ?? 0) + ($extra ?? 0) }}
                @else
                    —
                @endif
                @if ($isWinner && $match->penalty_winner) <small>(pen.)</small> @endif
            </strong>
        </div>
    @endforeach
</div>
