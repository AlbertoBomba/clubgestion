<div class="public-brackets">
    <style>
        .public-brackets { color: #142d28; }
        .public-bracket { background: #fff; border: 1px solid #dce5e1; border-radius: 18px; padding: 20px; margin-bottom: 20px; }
        .public-bracket h3 { font-size: 18px; font-weight: 800; margin: 0 0 8px; }
        .public-bracket-hint { font-size: 12px; color: #64748b; margin-bottom: 14px; }
        .public-bracket-scroll { overflow-x: auto; padding-bottom: 12px; }
        .public-bracket-columns { display: flex; width: max-content; }
        .public-bracket-round { width: 230px; flex-shrink: 0; }
        .public-bracket-round h4 { height: 32px; text-align: center; font-size: 13px; font-weight: 800; margin: 0; }
        .public-bracket-card { height: 112px; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 12px; background: #fff; overflow: hidden; }
        .public-bracket-meta { display: flex; justify-content: space-between; gap: 4px; padding: 7px 10px; font-size: 10px; background: #f1f5f9; color: #475569; }
        .public-bracket-team { display: flex; justify-content: space-between; gap: 8px; padding: 9px 10px; font-size: 12px; color: #334155; }
        .public-bracket-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .public-bracket-winner { background: #ecfdf5; color: #047857; font-weight: 800; }
        .public-bracket-live { color: #dc2626; font-weight: 800; }
        .public-bracket-third { margin-top: 16px; border-top: 1px dashed #cbd5e1; padding-top: 12px; }
        .public-bracket-third h4 { font-size: 13px; font-weight: 800; margin: 0 0 8px; }
        .public-bracket-third .public-bracket-card { max-width: 300px; }
    </style>
    @foreach ($bracketData as $phaseId => $bracket)
        <section @class(['public-bracket', 'public-bracket--desktop-hidden' => isset($desktopVisiblePhaseIds) && !in_array($phaseId, $desktopVisiblePhaseIds, true)]) wire:key="public-bracket-{{ $phaseId }}">
            <h3>{{ $bracket['phase']->name }} · Cuadro de cruces</h3>
            @if (!$bracket['hasMatches'])
                <p class="public-bracket-hint">Todavía no hay cruces generados para esta fase eliminatoria.</p>
            @else
                @php
                    $unit = 144;
                    $height = $bracket['rounds']->map(fn ($roundMatches, $round) => $roundMatches->count() * $unit * (2 ** ($round - $bracket['firstRound'])))->max();
                @endphp
                <p class="public-bracket-hint">Desliza horizontalmente para ver todas las rondas. Los ganadores aparecen destacados.</p>
                <div class="public-bracket-scroll" tabindex="0" aria-label="Cuadro de cruces de {{ $bracket['phase']->name }}">
                    <div class="public-bracket-columns">
                        @foreach ($bracket['rounds'] as $round => $roundMatches)
                            @php
                                $roundIndex = $round - $bracket['firstRound'];
                                $multiplier = 2 ** $roundIndex;
                                $label = match ($bracket['maxRound'] - $round) {
                                    0 => 'Final',
                                    1 => 'Semifinales',
                                    2 => 'Cuartos de final',
                                    3 => 'Octavos de final',
                                    4 => 'Dieciseisavos de final',
                                    default => 'Ronda ' . ($roundIndex + 1),
                                };
                            @endphp
                            <div class="public-bracket-round">
                                <h4>{{ $label }}</h4>
                                <div style="position: relative; height: {{ $height }}px;">
                                    @foreach ($roundMatches as $index => $match)
                                        <div style="position: absolute; width: 100%; top: {{ ($index + 0.5) * $unit * $multiplier - 56 }}px;">
                                            @include('livewire.webclubs._tournament-bracket-match')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if ($round < $bracket['maxRound'])
                                <div style="position: relative; width: 28px; flex-shrink: 0; margin-top: 32px; height: {{ $height }}px;" aria-hidden="true">
                                    @foreach ($bracket['rounds']->get($round + 1, collect()) as $index => $nextMatch)
                                        @php $top = ($index * 2 + 0.5) * $unit * $multiplier; @endphp
                                        <div style="position: absolute; left: 0; width: 14px; border: 2px solid #94a3b8; border-left: 0; top: {{ $top }}px; height: {{ $unit * $multiplier }}px;"></div>
                                        <div style="position: absolute; left: 14px; width: 14px; border-top: 2px solid #94a3b8; top: {{ ($index + 0.5) * $unit * $multiplier * 2 }}px;"></div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($bracket['thirdPlace'])
                <div class="public-bracket-third">
                    <h4>Tercer puesto</h4>
                    @include('livewire.webclubs._tournament-bracket-match', ['match' => $bracket['thirdPlace']])
                </div>
            @endif
        </section>
    @endforeach
</div>
