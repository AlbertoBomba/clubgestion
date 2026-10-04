@php
    $winner = $match->winner();
    $showScore = in_array($match->status, ['completed', 'in_progress']);
@endphp
<div wire:key="mobile-bracket-match-{{ $match->id }}"
     class="flex flex-col w-full h-full rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if (filled($match->notes))
        <div class="shrink-0 px-3 py-2 bg-primary/5 border-b border-gray-100">
            <span class="block text-[10px] leading-4 font-bold text-titanium break-words" title="{{ $match->notes }}"
                  style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{ $match->notes }}</span>
        </div>
    @endif
<button type="button"
        wire:click="openGoalsModal({{ $match->id }})"
        @disabled(!$match->home_team_id || !$match->away_team_id)
        aria-label="Ver partido: {{ $match->homeTeam?->displayName() ?? 'Por definir' }} contra {{ $match->awayTeam?->displayName() ?? 'Por definir' }}"
        class="flex flex-col flex-1 min-h-0 w-full text-left bg-white enabled:active:scale-95 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary disabled:cursor-default">
    <div class="w-full shrink-0 px-3 py-1.5 bg-gray-50 flex justify-between items-center gap-2">
        <span class="text-[9px] font-bold {{ $match->status === 'in_progress' ? 'text-red-500' : 'text-gray-400' }}">{{ $match->statusLabel() }}</span>
        <span class="text-[9px] text-gray-400">{{ $match->scheduled_at?->format('d/m H:i') }}</span>
    </div>
    @foreach (['home', 'away'] as $side)
        @php
            $team = $side === 'home' ? $match->homeTeam : $match->awayTeam;
            $score = $side === 'home' ? $match->home_score : $match->away_score;
            $extraScore = $side === 'home' ? $match->home_score_extra : $match->away_score_extra;
            $isWinner = $winner && $team && $winner->id === $team->id;
        @endphp
        <div class="w-full shrink-0 flex items-center justify-between gap-2 px-3 py-2 {{ $isWinner ? 'bg-green-50 text-green-700' : 'text-gray-600' }}">
            <span class="text-xs truncate {{ $isWinner ? 'font-black' : 'font-bold' }}">{{ $team?->displayName() ?? 'Por definir' }}</span>
            <span class="shrink-0 text-xs font-black">
                @if ($showScore)
                    {{ ($score ?? 0) + ($extraScore ?? 0) }}
                @else
                    —
                @endif
                @if ($isWinner && $match->penalty_winner)
                    <span class="text-[9px]">(pen.)</span>
                @endif
            </span>
        </div>
    @endforeach
</button>
</div>
