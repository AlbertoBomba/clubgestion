@php $hasLive = $liveMatches->isNotEmpty(); @endphp
<div wire:poll.5s class="live-screen {{ $liveSponsors->isNotEmpty() ? 'live-screen--with-sponsors' : '' }}">

    {{-- ══════════════════════════════════════════════════════
         HEADER — Tournament name + live badge
    ══════════════════════════════════════════════════════ --}}
    <header class="live-header">
        <div class="live-header__inner">
            {{-- Logo --}}
            @if($tournament->logo)
                <div class="live-header__logo-wrap">
                    <img src="{{ Storage::url($tournament->logo) }}"
                         alt="{{ $tournament->name }}"
                         class="live-header__logo">
                </div>
            @else
                <div class="live-header__logo-wrap live-header__logo-wrap--placeholder">
                    <span>🏆</span>
                </div>
            @endif

            {{-- Title --}}
            <div class="live-header__text">
                <p class="live-header__suptitle">Resultados en Vivo</p>
                <h1 class="live-header__title">{{ $tournament->name }}</h1>
            </div>

            {{-- Live badge --}}
            <div class="live-badge">
                <span class="live-badge__dot"></span>
                <span class="live-badge__text">EN VIVO</span>
            </div>
        </div>
    </header>

    {{-- ══════════════════════════════════════════════════════
         MAIN GRID:
         Left  = Classification
         Right = Top scorers and match summary
    ══════════════════════════════════════════════════════ --}}
    <section class="live-section">
        <div class="live-section__inner">
            <div class="live-main-grid">

                {{-- ── LEFT: Classification ── --}}
                <div class="live-col live-col--classification {{ count($desktopBracketPhaseIds) > 0 ? 'live-col--bracket-ready' : '' }}" x-data="{ panel: '{{ $standings->isEmpty() && $bracketData->isNotEmpty() ? 'bracket' : 'standings' }}' }">
                    @if ($bracketData->isNotEmpty())
                        <div class="live-panel-controls" style="display: flex; gap: 8px; margin-bottom: 14px; flex-shrink: 0;">
                            <button type="button" @click="panel = 'standings'" :aria-pressed="panel === 'standings'"
                                    :style="{ backgroundColor: panel === 'standings' ? '#176b51' : 'transparent', color: panel === 'standings' ? '#ffffff' : 'inherit' }"
                                    style="padding: 8px 12px; border: 1px solid #94a3b8; border-radius: 8px;">Clasificación</button>
                            <button type="button" @click="panel = 'bracket'" :aria-pressed="panel === 'bracket'"
                                    :style="{ backgroundColor: panel === 'bracket' ? '#176b51' : 'transparent', color: panel === 'bracket' ? '#ffffff' : 'inherit' }"
                                    style="padding: 8px 12px; border: 1px solid #94a3b8; border-radius: 8px;">Cuadro de cruces</button>
                        </div>
                        <div class="live-bracket-panel" x-show="panel === 'bracket'" x-cloak style="overflow: auto; min-height: 0;">
                            @include('livewire.webclubs._tournament-bracket', ['desktopVisiblePhaseIds' => $desktopBracketPhaseIds, 'showTeamLogos' => true])
                        </div>
                    @endif
                    <div class="live-standings-panel" x-show="panel === 'standings'" style="display: flex; flex-direction: column; overflow: auto; min-height: 0;">
                    <h2 class="live-section__heading">
                        <svg class="live-section__heading-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 4h18v3H3zM3 10.5h18v3H3zM3 17h18v3H3z"/>
                        </svg>
                        Clasificación
                    </h2>

                    @if($standingGroups->isEmpty())
                        <div class="live-empty">
                            <span class="live-empty__icon">📊</span>
                            <p>Clasificación no disponible aún</p>
                        </div>
                    @else
                        <div class="standings-list">
                            @foreach($standingGroups as $groupKey => $group)
                            @php
                                $groupName = $group['name'];
                                $groupStandings = $group['rows'];
                            @endphp
                            <div wire:key="standings-group-{{ $groupKey }}" class="standings-group">
                                <h3 class="standings-group__name">{{ $groupName }}</h3>

                                <div class="standings-table-wrap">
                                    <table class="standings-table">
                                        <thead>
                                            <tr>
                                                <th class="standings-table__pos">#</th>
                                                <th class="standings-table__team-col">Equipo</th>
                                                <th class="standings-table__pts">Pts</th>
                                                <th class="standings-table__stat standings-table__desktop-hidden">PJ</th>
                                                <th class="standings-table__stat standings-table__stat--g standings-table__desktop-hidden">G</th>
                                                <th class="standings-table__stat standings-table__desktop-hidden">E</th>
                                                <th class="standings-table__stat standings-table__stat--p standings-table__desktop-hidden">P</th>
                                                <th class="standings-table__stat standings-table__stat--hide-sm standings-table__desktop-hidden">GF</th>
                                                <th class="standings-table__stat standings-table__stat--hide-sm standings-table__desktop-hidden">GC</th>
                                                <th class="standings-table__stat standings-table__stat--dg">DG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($groupStandings as $i => $standing)
                                            <tr wire:key="standing-{{ $standing->id }}" class="standings-row {{ $i === 0 ? 'standings-row--gold' : ($i === 1 ? 'standings-row--silver' : ($i === 2 ? 'standings-row--bronze' : '')) }}">
                                                <td class="standings-table__pos">
                                                    @if($i === 0)
                                                        <span class="pos-badge pos-badge--1">1</span>
                                                    @elseif($i === 1)
                                                        <span class="pos-badge pos-badge--2">2</span>
                                                    @elseif($i === 2)
                                                        <span class="pos-badge pos-badge--3">3</span>
                                                    @else
                                                        <span class="pos-num">{{ $i + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td class="standings-table__team-col">
                                                    <span class="standings-team">
                                                        {{-- @dump($standing) --}}
                                                        {{-- @if($teamLogo = $standing->tournamentTeam?->logoUrl())
                                                            <img src="{{ $teamLogo }}" alt="" class="standings-team-logo">
                                                        @endif --}}
                                                        <span class="standings-team-name">{{ $standing->tournamentTeam?->displayName() ?? '—' }}</span>
                                                    </span>
                                                </td>
                                                <td class="standings-table__pts">
                                                    <span class="standings-pts">{{ $standing->points }}</span>
                                                </td>
                                                <td class="standings-table__stat standings-table__desktop-hidden">{{ $standing->played }}</td>
                                                <td class="standings-table__stat standings-table__stat--g standings-table__desktop-hidden">{{ $standing->won }}</td>
                                                <td class="standings-table__stat standings-table__desktop-hidden">{{ $standing->drawn }}</td>
                                                <td class="standings-table__stat standings-table__stat--p standings-table__desktop-hidden">{{ $standing->lost }}</td>
                                                <td class="standings-table__stat standings-table__stat--hide-sm standings-table__desktop-hidden">{{ $standing->goals_for }}</td>
                                                <td class="standings-table__stat standings-table__stat--hide-sm standings-table__desktop-hidden">{{ $standing->goals_against }}</td>
                                                <td class="standings-table__stat standings-table__stat--dg {{ ($standing->goals_for - $standing->goals_against) >= 0 ? 'standings-table__stat--pos' : 'standings-table__stat--neg' }}">
                                                    {{ ($standing->goals_for - $standing->goals_against) >= 0 ? '+' : '' }}{{ $standing->goals_for - $standing->goals_against }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            @include('livewire.webclubs._pending-standings', ['pendingCount' => $group['pending'], 'assignedCount' => $groupStandings->count(), 'compactDesktop' => true])
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                    </div>
                </div>{{-- /live-col--classification --}}

                <aside class="live-col live-col--summary">
                <section class="live-summary-section">
                    <h2 class="live-section__heading live-section__heading--live">
                        <span class="live-section__heading-dot"></span>
                        Partidos en Juego
                    </h2>

                    @if($hasLive)
                    <div class="live-matches-stack">
                        @foreach($liveMatches as $match)
                        <div wire:key="live-match-{{ $match->id }}" class="match-card match-card--live">
                            <div class="match-card__meta">
                                @if($match->phase)
                                    <span>{{ $match->phase->name }}</span>
                                    @if($match->round) <span class="match-card__meta-sep">·</span> <span>Jornada {{ $match->round }}</span> @endif
                                @elseif($match->round)
                                    <span>Jornada {{ $match->round }}</span>
                                @endif
                                @if($match->location)
                                    <span class="match-card__meta-sep">·</span>
                                    <span>{{ $match->location }}</span>
                                @endif
                            </div>

                            <div class="match-card__board">
                                <div class="match-card__team match-card__team--home">
                                    <span class="match-card__team-name">{{ $match->homeTeam?->displayName() ?? 'Local' }}</span>
                                </div>

                                <div class="match-card__score-wrap">
                                    <div class="match-card__score">
                                        <span class="match-card__score-num">{{ $match->home_score ?? 0 }}</span>
                                        <span class="match-card__score-sep">–</span>
                                        <span class="match-card__score-num">{{ $match->away_score ?? 0 }}</span>
                                    </div>
                                    <div class="match-card__live-pill">
                                        <span class="match-card__live-dot"></span>
                                        EN JUEGO
                                    </div>
                                </div>

                                <div class="match-card__team match-card__team--away">
                                    <span class="match-card__team-name">{{ $match->awayTeam?->displayName() ?? 'Visitante' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="live-empty live-empty--compact">
                            <p>No hay partidos en juego</p>
                        </div>
                    @endif
                </section>

                @if($hasPlayers)
                <section class="live-summary-section live-summary-section--scorers">
                    <h2 class="live-section__heading">
                        <svg class="live-section__heading-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke-linecap="round"/>
                        </svg>
                        Máximos Goleadores
                    </h2>

                    @if($topScorers->isEmpty())
                        <div class="live-empty">
                            <span class="live-empty__icon">⚽</span>
                            <p>Sin goleadores registrados aún</p>
                        </div>
                    @else
                        <div class="scorers-list">
                            @foreach($topScorers as $i => $scorer)
                            <div wire:key="scorer-{{ $scorer->player->id }}" class="scorer-row {{ $i === 0 ? 'scorer-row--top' : '' }}">
                                <div class="scorer-row__rank">
                                    @if($i === 0)
                                        <span class="scorer-rank scorer-rank--gold">🥇</span>
                                    @elseif($i === 1)
                                        <span class="scorer-rank scorer-rank--silver">🥈</span>
                                    @elseif($i === 2)
                                        <span class="scorer-rank scorer-rank--bronze">🥉</span>
                                    @else
                                        <span class="scorer-rank">{{ $i + 1 }}</span>
                                    @endif
                                </div>

                                <div class="scorer-row__avatar">
                                    @if($scorer->player?->photoUrl())
                                        <img src="{{ $scorer->player->photoUrl() }}" alt="{{ $scorer->player->fullName() }}">
                                    @else
                                        <span>{{ mb_substr($scorer->player?->fullName() ?? '?', 0, 1) }}</span>
                                    @endif
                                </div>

                                <div class="scorer-row__info">
                                    <span class="scorer-row__name">{{ $scorer->player?->fullName() ?? '—' }}</span>
                                    <span class="scorer-row__team">{{ $scorer->team?->displayName() ?? '—' }}</span>
                                </div>

                                <div class="scorer-row__goals">
                                    <span class="scorer-goals-num">{{ $scorer->goals }}</span>
                                    <span class="scorer-goals-label">goles</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </section>
                @endif
                @foreach([
                    ['key' => 'recent', 'title' => 'Últimos resultados', 'matches' => $recentMatches, 'empty' => 'No hay partidos finalizados aún'],
                    ['key' => 'upcoming', 'title' => 'Próximos partidos', 'matches' => $upcomingMatches, 'empty' => 'No hay próximos partidos programados'],
                ] as $matchSection)
                    <section class="live-summary-section live-summary-section--{{ $matchSection['key'] }}">
                        <h2 class="live-section__heading">{{ $matchSection['title'] }}</h2>
                        <div class="live-matches-stack">
                            @forelse($matchSection['matches'] as $match)
                                @include('livewire.webclubs._live-summary-match', ['match' => $match])
                            @empty
                                <div class="live-empty live-empty--compact">
                                    <p>{{ $matchSection['empty'] }}</p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
                </aside>

            </div>{{-- /live-main-grid --}}
        </div>
    </section>

    {{-- Footer timestamp --}}
    <div class="live-footer">
        <span class="live-footer__refresh">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="live-footer__icon">
                <path d="M23 4v6h-6M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
            </svg>
            Actualización automática cada 5 segundos · Última: {{ now()->format('H:i:s') }}
        </span>
    </div>

    @if ($liveSponsors->isNotEmpty())
        @include('livewire.webclubs._live-sponsors')
    @endif

    {{-- ══════════════════════════════════════════════════════
         LIVE EVENT MODAL — Goal / Card notification
         Goals without player data show the team name and logo instead,
         using the club team's image when the tournament team has no logo.
         wire:ignore → preserves Alpine state (queue/timer) across
         every wire:poll re-render, otherwise the modal would be
         reset every 10s and the notification would be lost.
    ══════════════════════════════════════════════════════ --}}
    <div
        wire:ignore
        x-data="liveEventModal"
        x-show="visible"
        x-transition:enter="modal-enter"
        x-transition:enter-start="modal-enter-start"
        x-transition:enter-end="modal-enter-end"
        x-transition:leave="modal-leave"
        x-transition:leave-start="modal-leave-start"
        x-transition:leave-end="modal-leave-end"
        @live-event-notification.window="enqueue($event.detail)"
        class="live-event-overlay"
        style="display:none"
    >
        {{-- Animated background burst --}}
        <div class="live-event-burst" :class="current?.type === 'goal' ? 'live-event-burst--goal' : (current?.card_type === 'yellow' ? 'live-event-burst--yellow' : 'live-event-burst--red')"></div>

        <div class="live-event-modal" :class="current?.type === 'goal' ? 'live-event-modal--goal' : (current?.card_type === 'yellow' ? 'live-event-modal--yellow' : 'live-event-modal--red')">

            {{-- Icon / badge at top --}}
            <div class="live-event-icon-wrap">
                <template x-if="current?.type === 'goal'">
                    <div class="live-event-icon live-event-icon--goal">⚽</div>
                </template>
                <template x-if="current?.type === 'card' && current?.card_type === 'yellow'">
                    <div class="live-event-icon live-event-icon--yellow">
                        <span class="live-card-shape live-card-shape--yellow"></span>
                    </div>
                </template>
                <template x-if="current?.type === 'card' && current?.card_type !== 'yellow'">
                    <div class="live-event-icon live-event-icon--red">
                        <span class="live-card-shape live-card-shape--red"></span>
                    </div>
                </template>
            </div>

            {{-- Event label — big animated "¡Goooll!!" for goals, plain label for cards --}}
            <template x-if="current?.type === 'goal'">
                <p class="live-event-goal-shout">
                    <span class="live-event-goal-shout__text">¡Goooll!!</span>
                </p>
            </template>
            {{-- <template x-if="current?.type !== 'goal'">
                <p class="live-event-type-label" x-text="current?.label ?? ''"></p>
            </template> --}}

            {{-- Player photo or scoring team logo --}}
            {{-- <div class="live-event-photo-wrap">
                <template x-if="participantPhoto">
                    <img :src="participantPhoto" :alt="participantName" class="live-event-photo" :class="{ 'live-event-photo--team': isTeamGoal }">
                </template>
                <template x-if="!participantPhoto">
                    <div class="live-event-photo-placeholder" x-text="(participantName || '?').charAt(0)"></div>
                </template>
            </div> --}}

            {{-- Player name or scoring team name --}}
            {{-- <h2 class="live-event-player" x-text="participantName"></h2> --}}
            <h2 class="live-event-player" x-text="current?.team_name ?? ''"></h2> 
            {{-- Team --}}
            {{-- <p class="live-event-team">
                <svg viewBox="0 0 24 24" fill="currentColor" class="live-event-team-icon"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z"/></svg>
                <span x-text="current?.team_name ?? ''"></span>
            </p> --}}

            {{-- Minute --}}
            <p class="live-event-minute" x-show="current?.minute">
                <span x-text="current?.minute ? 'min. ' + current.minute + '\'': ''"></span>
            </p>

            {{-- Progress bar for 15s countdown --}}
            <div class="live-event-progress-track">
                <div class="live-event-progress-bar" :style="'animation-duration:' + duration + 'ms'"></div>
            </div>

            {{-- Queue indicator --}}
            <p class="live-event-queue" x-show="queue.length > 0" x-text="'+' + queue.length + ' más'"></p>
        </div>
    </div>

</div>

@push('styles')
<style>
/* ═══════════════════════════════════════════════
   LIVE SCREEN — Dark Glassmorphism TV Design
   ═══════════════════════════════════════════════ */

.live-screen {
    --live-sponsors-height: clamp(80px, 8vw, 150px);
    --live-bg:              #080c14;
    --live-surface:         rgba(255,255,255,0.04);
    --live-surface-hover:   rgba(255,255,255,0.08);
    --live-border:          rgba(255,255,255,0.08);
    --live-text:            #f0f4ff;
    --live-text-muted:      rgba(240,244,255,0.5);
    --live-text-dim:        rgba(240,244,255,0.25);
    --live-green:           #22c55e;
    --live-red:             #ef4444;

    min-height: 100vh;
    background: var(--live-bg);
    background-image:
        radial-gradient(ellipse 80% 50% at 15% 10%, rgba(30,64,175,0.2) 0%, transparent 55%),
        radial-gradient(ellipse 60% 40% at 85% 85%, rgba(16,185,129,0.12) 0%, transparent 55%);
    color: var(--live-text);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing: antialiased;
}

.live-screen--with-sponsors { padding-bottom: calc(var(--live-sponsors-height) + env(safe-area-inset-bottom, 0px)); }
.live-sponsors {
    position: fixed;
    inset: auto 0 0;
    z-index: 60;
    height: calc(var(--live-sponsors-height) + env(safe-area-inset-bottom, 0px));
    padding-bottom: env(safe-area-inset-bottom, 0px);
    background: #fff;
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -8px 24px rgba(0,0,0,0.15);
    overflow: hidden;
}
.live-sponsors__track { display: flex; width: max-content; height: var(--live-sponsors-height); animation: liveSponsorsMove var(--sponsors-duration, 30s) linear infinite; }
.live-sponsors__group, .live-sponsors__set { display: flex; flex-shrink: 0; }
.live-sponsors__item { width: clamp(160px, 16vw, 320px); height: var(--live-sponsors-height); padding: 14px 24px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.live-sponsors__logo { width: 100%; height: 100%; object-fit: contain; }
@keyframes liveSponsorsMove {
    from { transform: translateX(-50%); }
    to { transform: translateX(0); }
}
@media (prefers-reduced-motion: reduce) {
    .live-sponsors { overflow-x: auto; }
    .live-sponsors__track { animation: none; }
    .live-sponsors__group[aria-hidden="true"], .live-sponsors__set[aria-hidden="true"] { display: none; }
}

/* ── Header ── */
.live-header {
    background: rgba(8,12,20,0.96);
    border-bottom: 1px solid var(--live-border);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    position: sticky;
    top: 0;
    z-index: 50;
}
.live-header__inner {
    width: 100%;
    margin: 0 auto;
    padding: 1.25rem 2.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.live-header__logo-wrap {
    width: 68px;
    height: 68px;
    border-radius: 16px;
    overflow: hidden;
    flex-shrink: 0;
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--live-border);
    display: flex;
    align-items: center;
    justify-content: center;
}
.live-header__logo-wrap--placeholder { font-size: 2rem; }
.live-header__logo { width: 100%; height: 100%; object-fit: contain; padding: 6px; }
.live-header__text { flex: 1; min-width: 0; }
.live-header__suptitle {
    font-size: clamp(0.55rem, 1.2vw, 0.7rem);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.22em;
    color: var(--live-text-muted);
    margin-bottom: 0.2rem;
}
.live-header__title {
    font-size: clamp(1.5rem, 4.5vw, 3rem);
    font-weight: 900;
    line-height: 1;
    letter-spacing: -0.03em;
    color: var(--live-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.live-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(239,68,68,0.12);
    border: 1px solid rgba(239,68,68,0.35);
    border-radius: 100px;
    padding: 0.55rem 1.4rem;
    flex-shrink: 0;
    backdrop-filter: blur(12px);
}
.live-badge__dot {
    width: 10px;
    height: 10px;
    background: #ef4444;
    border-radius: 50%;
    animation: livePulse 1.4s ease-in-out infinite;
}
@keyframes livePulse {
    0%   { box-shadow: 0 0 0 0 rgba(239,68,68,0.6); }
    70%  { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
    100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
}
.live-badge__text {
    font-size: clamp(0.6rem, 1.3vw, 0.78rem);
    font-weight: 900;
    letter-spacing: 0.18em;
    color: #f87171;
}

/* ── Sections ── */
.live-section { padding: 2rem 0; }
.live-section__inner {
    width: 100%;
    margin: 0 auto;
    padding: 0 2.5rem;
}
.live-section__heading {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: clamp(0.9rem, 2.2vw, 1.4rem);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--live-text);
    margin-bottom: 1.25rem;
}
.live-section__heading--live { color: #f87171; }
.live-section__heading-dot {
    width: 12px;
    height: 12px;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
    animation: livePulse 1.4s ease-in-out infinite;
}
.live-section__heading-icon {
    width: 1.2em;
    height: 1.2em;
    flex-shrink: 0;
    color: var(--color-primary);
    opacity: 0.8;
}

/* ── Live Matches ── */
.live-matches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(100%, 500px), 1fr));
    gap: 1.25rem;
}
.match-card {
    background: var(--live-surface);
    border: 1px solid var(--live-border);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
}
.match-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.04) 0%, transparent 50%);
    pointer-events: none;
}
.match-card--live {
    border-color: rgba(239,68,68,0.28);
    background: rgba(239,68,68,0.06);
    animation: matchGlow 3s ease-in-out infinite;
}
@keyframes matchGlow {
    0%, 100% { box-shadow: 0 0 20px rgba(239,68,68,0.08), 0 8px 40px rgba(0,0,0,0.5); }
    50%       { box-shadow: 0 0 40px rgba(239,68,68,0.18), 0 8px 40px rgba(0,0,0,0.5); }
}
.match-card__meta {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: clamp(0.58rem, 1.1vw, 0.72rem);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--live-text-muted);
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}
.match-card__meta-sep { opacity: 0.3; }
.match-card__board {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 1rem;
}
.match-card__team { display: flex; flex-direction: column; }
.match-card__team--home { align-items: flex-end; text-align: right; }
.match-card__team--away { align-items: flex-start; text-align: left; }
.match-card__team-name {
    font-size: clamp(1.1rem, 3.2vw, 1.75rem);
    font-weight: 800;
    color: var(--live-text);
    line-height: 1.1;
    letter-spacing: -0.02em;
}
.match-card__score-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}
.match-card__score {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0,0,0,0.45);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 0.5rem 1.5rem;
}
.match-card__score-num {
    font-size: clamp(2.2rem, 6vw, 4.5rem);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: var(--live-text);
    min-width: 1ch;
    text-align: center;
    font-variant-numeric: tabular-nums;
    line-height: 1;
}
.match-card__score-sep {
    font-size: clamp(1.5rem, 4vw, 3rem);
    font-weight: 200;
    color: var(--live-text-dim);
    line-height: 1;
}
.match-card__live-pill {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(239,68,68,0.18);
    border: 1px solid rgba(239,68,68,0.35);
    border-radius: 100px;
    padding: 0.2rem 0.75rem;
    font-size: 0.6rem;
    font-weight: 900;
    letter-spacing: 0.14em;
    color: #f87171;
}
.match-card__live-dot {
    width: 6px;
    height: 6px;
    background: #ef4444;
    border-radius: 50%;
    animation: livePulse 1.4s ease-in-out infinite;
}

/* ── Main Grid ── */
.live-main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: start;
}
@media (max-width: 960px) {
    .live-main-grid { grid-template-columns: 1fr; }
}

/* ── Empty ── */
.live-empty {
    background: var(--live-surface);
    border: 1px solid var(--live-border);
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    color: var(--live-text-muted);
}
.live-empty__icon { font-size: 3rem; display: block; margin-bottom: 0.75rem; opacity: 0.35; }
.live-empty p { font-size: 1rem; font-weight: 600; }

/* ── Standings ── */
.standings-list { display: flex; flex-direction: column; gap: 1.5rem; }
.standings-group__name {
    font-size: clamp(0.72rem, 1.4vw, 0.85rem);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--color-primary);
    margin-bottom: 0.75rem;
    padding-left: 0.75rem;
    border-left: 3px solid var(--color-primary);
}
.standings-table-wrap {
    background: var(--live-surface);
    border: 1px solid var(--live-border);
    border-radius: 16px;
    overflow: hidden;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}
.standings-table { width: 100%; border-collapse: collapse; }
.standings-table thead tr { border-bottom: 1px solid var(--live-border); }
.standings-table thead th {
    font-size: clamp(0.52rem, 1.1vw, 0.68rem);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--live-text-dim);
    padding: 0.8rem 0.5rem;
    text-align: center;
}
.standings-table__pos     { width: 52px; }
.standings-table__team-col{ text-align: left !important; padding-left: 1rem !important; padding-right: 0.5rem !important; }
.standings-table__pts     { width: 52px; }
.standings-table__stat    { width: 38px; }
@media (max-width: 600px) {
    .standings-table__stat--hide-sm { display: none; }
    .standings-table__stat--dg      { display: none; }
}
.standings-row { border-bottom: 1px solid rgba(255,255,255,0.03); transition: background 0.15s; }
.standings-row:last-child { border-bottom: none; }
.standings-row:hover { background: var(--live-surface-hover); }
.standings-row--gold   { background: rgba(255,215,0,0.05); }
.standings-row--silver { background: rgba(176,184,200,0.04); }
.standings-row--bronze { background: rgba(205,127,50,0.04); }
.standings-table tbody td {
    font-size: clamp(0.78rem, 1.7vw, 0.95rem);
    color: var(--live-text-muted);
    padding: 0.9rem 0.5rem;
    text-align: center;
    font-variant-numeric: tabular-nums;
}
.pos-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    font-size: 0.68rem;
    font-weight: 900;
    color: #000;
}
.pos-badge--1 { background: linear-gradient(135deg, #ffd700, #ffb300); box-shadow: 0 2px 10px rgba(255,215,0,0.35); }
.pos-badge--2 { background: linear-gradient(135deg, #e8eef8, #b8c4d8); }
.pos-badge--3 { background: linear-gradient(135deg, #e8a86a, #cd7f32); }
.pos-num { font-size: 0.75rem; font-weight: 600; color: var(--live-text-dim); }
.standings-team { display: flex; align-items: center; gap: 0.5rem; }
.standings-team-logo { width: 32px; height: 32px; object-fit: contain; flex-shrink: 0; }
.standings-team-name { font-size: clamp(0.82rem, 1.8vw, 1rem); font-weight: 700; color: var(--live-text); min-width: 0; }
.standings-pts { font-size: clamp(0.95rem, 2vw, 1.15rem); font-weight: 900; color: var(--live-text); }
.standings-table__stat--g   { color: var(--live-green) !important; font-weight: 700 !important; }
.standings-table__stat--p   { color: var(--live-red)   !important; font-weight: 700 !important; }
.standings-table__stat--pos { color: var(--live-green) !important; font-weight: 700 !important; }
.standings-table__stat--neg { color: var(--live-red)   !important; font-weight: 700 !important; }

/* ── Scorers ── */
.scorers-list { display: flex; flex-direction: column; gap: 0.5rem; }
.scorer-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--live-surface);
    border: 1px solid var(--live-border);
    border-radius: 14px;
    padding: 0.9rem 1.25rem;
    transition: background 0.15s, transform 0.15s;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}
.scorer-row:hover { background: var(--live-surface-hover); transform: translateX(3px); }
.scorer-row--top { background: rgba(255,215,0,0.06); border-color: rgba(255,215,0,0.18); }
.scorer-row__rank { width: 36px; text-align: center; flex-shrink: 0; }
.scorer-rank { font-size: 0.78rem; font-weight: 600; color: var(--live-text-dim); }
.scorer-rank--gold, .scorer-rank--silver, .scorer-rank--bronze { font-size: 1.4rem; }
.scorer-row__avatar {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    overflow: hidden;
    background: rgba(255,255,255,0.07);
    border: 1px solid var(--live-border);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 800;
    color: var(--live-text-muted);
}
.scorer-row__avatar img { width: 100%; height: 100%; object-fit: cover; }
.scorer-row__info { flex: 1; min-width: 0; }
.scorer-row__name {
    display: block;
    font-size: clamp(0.88rem, 1.9vw, 1.05rem);
    font-weight: 700;
    color: var(--live-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.scorer-row__team {
    display: block;
    font-size: clamp(0.68rem, 1.3vw, 0.8rem);
    color: var(--live-text-muted);
    margin-top: 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.scorer-row__goals { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
.scorer-goals-num {
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--live-text);
    line-height: 1;
    font-variant-numeric: tabular-nums;
}
.scorer-goals-label {
    font-size: 0.58rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--live-text-dim);
}

/* ── Footer ── */
.live-footer {
    width: 100%;
    margin: 0 auto;
    padding: 1.5rem 2.5rem 3rem;
    display: flex;
    justify-content: center;
}
.live-footer__refresh {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--live-text-dim);
}
.live-footer__icon {
    width: 14px;
    height: 14px;
    animation: spinSlow 4s linear infinite;
    flex-shrink: 0;
}
@keyframes spinSlow { to { transform: rotate(360deg); } }

/* ═══════════════ RESPONSIVE ═══════════════ */
@media (max-width: 1024px) {
    .live-header__inner  { padding: 1rem 1.5rem; }
    .live-section__inner { padding: 0 1.5rem; }
}
@media (max-width: 640px) {
    .live-header__logo-wrap { width: 48px; height: 48px; border-radius: 12px; }
    .live-header__inner { gap: 0.75rem; padding: 0.875rem 1rem; }
    .live-header__title { font-size: 1.25rem; }
    .live-badge { padding: 0.35rem 0.8rem; }
    .live-section__inner { padding: 0 0.875rem; }
    .live-section { padding: 1.25rem 0; }
    .match-card { padding: 1rem 1rem; }
    .match-card__score-num { font-size: 2.5rem; }
    .match-card__team-name { font-size: 1rem; }
    .live-footer { padding: 1rem 1rem 2rem; }
}
/* TV / Wide screens */
@media (min-width: 1600px) {
    .live-header__logo-wrap { width: 88px; height: 88px; }
    .live-header__inner { padding: 1.5rem 3rem; }
    .live-section__inner { padding: 0 3rem; }
    .live-header__title { font-size: 3.75rem; }
    .match-card { padding: 2rem 2.75rem; }
    .match-card__score-num { font-size: 5.5rem; }
    .match-card__team-name { font-size: 2.2rem; }
    .standings-table tbody td { font-size: 1.1rem; padding: 1rem 0.75rem; }
    .standings-team-name { font-size: 1.2rem; }
    .standings-pts { font-size: 1.35rem; }
    .scorer-row { padding: 1.1rem 1.75rem; gap: 1.25rem; }
    .scorer-goals-num { font-size: 2.75rem; }
    .scorer-row__name { font-size: 1.2rem; }
    .scorer-row__team { font-size: 0.92rem; }
    .scorer-row__avatar { width: 58px; height: 58px; }
    .live-section__heading { font-size: 1.8rem; margin-bottom: 1.5rem; }
    .pos-badge { width: 34px; height: 34px; font-size: 0.8rem; }
}

.live-col { min-width: 0; }
.live-col--summary { display: flex; flex-direction: column; gap: 1.5rem; }
.live-summary-section--scorers { order: -1; }
.live-matches-stack { display: flex; flex-direction: column; gap: 0.75rem; }
.live-empty--compact { padding: 1.25rem; border-radius: 12px; }
.live-col--summary .live-empty { padding: 1.25rem; }
.live-col--summary .live-empty__icon { font-size: 1.5rem; }
.live-col--summary .live-section__heading { font-size: 0.95rem; margin-bottom: 0.75rem; }
.live-col--summary .match-card { padding: 1rem; border-radius: 14px; }
.live-col--summary .match-card__meta { font-size: 0.6rem; margin-bottom: 0.75rem; letter-spacing: 0.05em; }
.live-col--summary .match-card__board { grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr); gap: 0.6rem; }
.live-col--summary .match-card__team-name { font-size: 0.95rem; line-height: 1.3; overflow-wrap: anywhere; }
.live-col--summary .match-card__score { padding: 0.4rem 0.65rem; border-radius: 10px; }
.live-col--summary .match-card__score-num { font-size: 1.75rem; }
.live-col--summary .match-card__score-sep { font-size: 1.25rem; }
.match-card__versus { font-size: 0.8rem; font-weight: 800; color: var(--live-text-muted); }
.match-card__penalties { font-size: 0.65rem; color: var(--live-text-muted); text-align: center; max-width: 100px; overflow-wrap: anywhere; }
.match-card__status { margin-left: auto; color: var(--live-text); }
.live-col--summary .scorer-row { padding: 0.75rem; gap: 0.65rem; }
.live-col--summary .scorer-row__avatar { width: 36px; height: 36px; }
.live-col--summary .scorer-row__rank { width: 28px; }
.live-col--summary .scorer-row__name { font-size: 0.9rem; }
.live-col--summary .scorer-row__team { font-size: 0.72rem; }
.live-col--summary .scorer-goals-num { font-size: 1.6rem; }

.live-bracket-panel .public-brackets {
    --bracket-line: rgba(240,244,255,0.3);
    color: var(--live-text);
}
.live-bracket-panel .public-bracket {
    background: var(--live-surface);
    border-color: var(--live-border);
    backdrop-filter: blur(20px);
    padding: 1.25rem;
}
.live-bracket-panel .public-bracket h3 {
    color: var(--live-text);
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.75rem;
}
.live-bracket-panel .public-bracket-hint { color: var(--live-text-muted); }
.live-bracket-panel .public-bracket-round h4 { color: var(--live-text-muted); text-transform: uppercase; letter-spacing: 0.06em; }
.live-bracket-panel .public-bracket-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
    border-color: rgba(255,255,255,0.14);
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    display: grid;
    grid-template-rows: 28px 1fr 1fr;
}
.live-bracket-panel .public-bracket-meta {
    align-items: center;
    background: rgba(0,0,0,0.2);
    color: var(--live-text-muted);
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.live-bracket-panel .public-bracket-team { align-items: center; color: var(--live-text); padding: 5px 10px; font-weight: 700; min-height: 0; }
.live-bracket-panel .public-bracket-team + .public-bracket-team { border-top: 1px solid var(--live-border); }
.live-bracket-panel .public-bracket-team strong {
    background: rgba(0,0,0,0.3);
    border-radius: 6px;
    padding: 2px 6px;
    min-width: 1.8em;
    text-align: center;
    font-size: 1.15em;
    font-variant-numeric: tabular-nums;
}
.live-bracket-panel .public-bracket-winner { background: rgba(34,197,94,0.12); color: #86efac; box-shadow: inset 3px 0 var(--live-green); }
.live-bracket-panel .public-bracket-live { color: #f87171; }
.live-bracket-panel .public-bracket-third { border-color: var(--live-border); }
.live-bracket-panel .public-bracket-third h4 { color: #fbbf24; text-transform: uppercase; letter-spacing: 0.06em; }
.live-bracket-panel .public-bracket-scroll { scrollbar-color: var(--bracket-line) transparent; scrollbar-width: thin; }
.live-bracket-panel .public-bracket-scroll:focus-visible { outline: 2px solid var(--live-green); outline-offset: 4px; }

@media (min-width: 961px) {
    .live-bracket-panel .public-brackets {
        --bracket-unit: calc(var(--live-unit) * 8);
        --bracket-card-height: calc(var(--live-unit) * 6);
        --bracket-heading-height: calc(var(--live-unit) * 2.5);
        --bracket-connector-width: calc(var(--live-unit) * 1.5);
    }
    .live-bracket-panel .public-bracket { padding: var(--live-unit); border-radius: calc(var(--live-unit) * 0.9); margin-bottom: var(--live-unit); }
    .live-bracket-panel .public-bracket h3 { font-size: calc(var(--live-unit) * 1.1); margin-bottom: calc(var(--live-unit) * 0.75); }
    .live-bracket-panel .public-bracket-hint { font-size: calc(var(--live-unit) * 0.7); margin-bottom: var(--live-unit); }
    .live-bracket-panel .public-bracket-round { width: calc(var(--live-unit) * 14); }
    .live-bracket-panel .public-bracket-round h4,
    .live-bracket-panel .public-bracket-third h4 { font-size: calc(var(--live-unit) * 0.8); }
    .live-bracket-panel .public-bracket-card { grid-template-rows: calc(var(--live-unit) * 1.5) 1fr 1fr; border-radius: calc(var(--live-unit) * 0.65); }
    .live-bracket-panel .public-bracket-meta { font-size: calc(var(--live-unit) * 0.6); padding: 0 calc(var(--live-unit) * 0.6); }
    .live-bracket-panel .public-bracket-team { font-size: calc(var(--live-unit) * 0.85); padding: calc(var(--live-unit) * 0.3) calc(var(--live-unit) * 0.6); }
    .live-bracket-panel .public-bracket-identity { gap: calc(var(--live-unit) * 0.4); }
    .live-bracket-panel .public-bracket-logo { width: calc(var(--live-unit) * 1.6); height: calc(var(--live-unit) * 1.6); }
    .live-bracket-panel .public-bracket-third { margin-top: var(--live-unit); padding-top: var(--live-unit); }
    .live-bracket-panel .public-bracket-third .public-bracket-card { max-width: calc(var(--live-unit) * 18); }
    .live-panel-controls,
    .live-bracket-panel,
    .live-bracket-panel .public-bracket--desktop-hidden { display: none !important; }
    .live-standings-panel { display: flex !important; }
    .live-col--bracket-ready .live-bracket-panel { display: block !important; }
    .live-col--bracket-ready .live-standings-panel { display: none !important; }
    .live-screen {
        --live-unit: clamp(14px, 0.95vw, 36px);
        --live-text-muted: rgba(240,244,255,0.75);
        --live-text-dim: rgba(240,244,255,0.6);
    }
    .live-header__inner { padding: var(--live-unit) calc(var(--live-unit) * 1.25); gap: var(--live-unit); }
    .live-header__logo-wrap { width: calc(var(--live-unit) * 3.5); height: calc(var(--live-unit) * 3.5); }
    .live-header__title { font-size: calc(var(--live-unit) * 2.25); }
    .live-header__suptitle, .live-badge__text { font-size: calc(var(--live-unit) * 0.7); }
    .live-section { padding: calc(var(--live-unit) * 1.25) 0; }
    .live-section__inner { padding: 0 calc(var(--live-unit) * 1.25); }
    .live-main-grid { grid-template-columns: minmax(0, 1.65fr) minmax(340px, 1fr); gap: calc(var(--live-unit) * 1.5); }
    .live-section__heading, .live-col--summary .live-section__heading {
        font-size: calc(var(--live-unit) * 1.1);
        margin-bottom: var(--live-unit);
        letter-spacing: 0.04em;
    }
    .standings-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--live-unit); align-items: start; }
    .standings-group { min-width: 0; }
    .standings-group__name { font-size: calc(var(--live-unit) * 0.9); }
    .standings-table { table-layout: fixed; }
    .standings-table .standings-table__desktop-hidden { display: none !important; }
    .standings-table__pos, .standings-table__pts { width: calc(var(--live-unit) * 2.5); }
    .standings-table__stat--dg { width: calc(var(--live-unit) * 2.75); }
    .standings-table__team-col { padding-left: 0.5rem !important; }
    .standings-table thead th { padding: calc(var(--live-unit) * 0.6) calc(var(--live-unit) * 0.3); font-size: calc(var(--live-unit) * 0.75); }
    .standings-table tbody td { padding: calc(var(--live-unit) * 0.65) calc(var(--live-unit) * 0.3); font-size: var(--live-unit); }
    .standings-team-name { font-size: var(--live-unit); line-height: 1.3; overflow-wrap: anywhere; }
    .standings-team-logo { width: calc(var(--live-unit) * 2); height: calc(var(--live-unit) * 2); }
    .standings-pts { font-size: calc(var(--live-unit) * 1.15); }
    .pos-badge { width: calc(var(--live-unit) * 1.75); height: calc(var(--live-unit) * 1.75); font-size: calc(var(--live-unit) * 0.8); border-radius: 7px; }
    .pos-num { font-size: calc(var(--live-unit) * 0.9); }
    .standings-table-wrap { border-radius: 12px; }
    .live-col--summary { gap: calc(var(--live-unit) * 1.25); }
    .live-summary-section { min-width: 0; }
    .live-matches-stack { gap: calc(var(--live-unit) * 0.65); }
    .live-col--summary .match-card { padding: var(--live-unit); }
    .live-col--summary .match-card__meta { font-size: calc(var(--live-unit) * 0.7); margin-bottom: calc(var(--live-unit) * 0.7); }
    .live-col--summary .match-card__team-name { font-size: var(--live-unit); }
    .live-col--summary .match-card__score-num { font-size: calc(var(--live-unit) * 2); }
    .live-col--summary .match-card__score-sep { font-size: calc(var(--live-unit) * 1.4); }
    .live-col--summary .match-card__live-pill { font-size: calc(var(--live-unit) * 0.65); }
    .match-card__versus { font-size: var(--live-unit); }
    .match-card__penalties { font-size: calc(var(--live-unit) * 0.75); max-width: calc(var(--live-unit) * 7); }
    .live-col--summary .scorer-row { padding: calc(var(--live-unit) * 0.7); gap: calc(var(--live-unit) * 0.65); }
    .live-col--summary .scorer-row__avatar { width: calc(var(--live-unit) * 2.5); height: calc(var(--live-unit) * 2.5); }
    .live-col--summary .scorer-row__rank { width: calc(var(--live-unit) * 2); }
    .scorer-rank--gold, .scorer-rank--silver, .scorer-rank--bronze { font-size: calc(var(--live-unit) * 1.4); }
    .live-col--summary .scorer-row__name { font-size: var(--live-unit); }
    .live-col--summary .scorer-row__team { font-size: calc(var(--live-unit) * 0.8); }
    .live-col--summary .scorer-goals-num { font-size: calc(var(--live-unit) * 1.8); }
    .scorer-goals-label { font-size: calc(var(--live-unit) * 0.65); }
    .live-empty p, .live-col--summary .live-empty p { font-size: var(--live-unit); }
    .live-footer { padding: var(--live-unit); }
    .live-footer__refresh { font-size: calc(var(--live-unit) * 0.7); }

    /* Fit the whole dashboard to the screen height (TV); columns scroll internally if needed. */
    .live-screen {
        box-sizing: border-box;
        height: 100vh;
        height: 100dvh;
        min-height: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .live-header, .live-footer { flex-shrink: 0; }
    .live-section { flex: 1; min-height: 0; display: flex; }
    .live-section__inner { flex: 1; min-height: 0; display: flex; flex-direction: column; }
    .live-main-grid { flex: 1; min-height: 0; align-items: stretch; }
    .live-col { min-height: 0; overflow-y: auto; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent; }
    .live-col--classification { display: flex; flex-direction: column; overflow: hidden; }
    .live-standings-panel, .live-bracket-panel { flex: 1; min-height: 0; overflow-y: auto !important; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent; }
    .live-footer { padding-top: calc(var(--live-unit) * 0.5); padding-bottom: calc(var(--live-unit) * 0.5); }
}

@media (min-width: 1280px) {
    .live-main-grid { grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr); }
    .live-col--summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: start;
    }
}

@media (min-width: 1600px) {
    .live-main-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

/* ═══════════════════════════════════════════════
   LIVE EVENT MODAL — Goal / Card notification
   ═══════════════════════════════════════════════ */

.live-event-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(4, 7, 14, 0.78);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Animated radial burst behind the card */
.live-event-burst {
    position: absolute;
    inset: 0;
    pointer-events: none;
    animation: burstPulse 1.8s ease-in-out infinite;
}
.live-event-burst--goal   { background: radial-gradient(ellipse 55% 55% at 50% 50%, rgba(34,197,94,0.22) 0%, transparent 70%); }
.live-event-burst--yellow { background: radial-gradient(ellipse 55% 55% at 50% 50%, rgba(234,179,8,0.22) 0%, transparent 70%); }
.live-event-burst--red    { background: radial-gradient(ellipse 55% 55% at 50% 50%, rgba(239,68,68,0.22) 0%, transparent 70%); }
@keyframes burstPulse {
    0%,100% { opacity: 0.7; transform: scale(1); }
    50%     { opacity: 1;   transform: scale(1.12); }
}

.live-event-modal {
    position: relative;
    background: rgba(12, 18, 32, 0.96);
    border-radius: 28px;
    padding: clamp(2rem, 5vw, 4rem) clamp(2.5rem, 6vw, 5rem);
    max-width: min(640px, 94vw);
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    backdrop-filter: blur(32px);
    -webkit-backdrop-filter: blur(32px);
    box-shadow: 0 40px 120px rgba(0,0,0,0.8);
    overflow: hidden;
}
.live-event-modal--goal   { border: 2px solid rgba(34,197,94,0.45);  box-shadow: 0 0 60px rgba(34,197,94,0.25), 0 40px 120px rgba(0,0,0,0.8); }
.live-event-modal--yellow { border: 2px solid rgba(234,179,8,0.5);   box-shadow: 0 0 60px rgba(234,179,8,0.2),  0 40px 120px rgba(0,0,0,0.8); }
.live-event-modal--red    { border: 2px solid rgba(239,68,68,0.5);   box-shadow: 0 0 60px rgba(239,68,68,0.2),  0 40px 120px rgba(0,0,0,0.8); }

/* ── Alpine transitions ── */
.modal-enter         { transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.22,1,0.36,1); }
.modal-enter-start   { opacity: 0; transform: scale(0.85) translateY(20px); }
.modal-enter-end     { opacity: 1; transform: scale(1) translateY(0); }
.modal-leave         { transition: opacity 0.3s ease, transform 0.3s ease; }
.modal-leave-start   { opacity: 1; transform: scale(1); }
.modal-leave-end     { opacity: 0; transform: scale(0.9) translateY(-10px); }

/* ── Icon wrapper ── */
.live-event-icon-wrap { margin-bottom: 0.25rem; }
.live-event-icon {
    width: clamp(64px, 10vw, 96px);
    height: clamp(64px, 10vw, 96px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: clamp(2rem, 5vw, 3.5rem);
}
.live-event-icon--goal   { background: rgba(34,197,94,0.18);  border: 2px solid rgba(34,197,94,0.4);  animation: iconBounce 0.6s cubic-bezier(0.22,1,0.36,1) both; }
.live-event-icon--yellow { background: rgba(234,179,8,0.18);  border: 2px solid rgba(234,179,8,0.45); animation: iconBounce 0.6s cubic-bezier(0.22,1,0.36,1) both; }
.live-event-icon--red    { background: rgba(239,68,68,0.18);  border: 2px solid rgba(239,68,68,0.4);  animation: iconBounce 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes iconBounce {
    0%   { transform: scale(0.5) rotate(-15deg); opacity: 0; }
    60%  { transform: scale(1.15) rotate(5deg); }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}

/* Card shape (tarjeta) */
.live-card-shape {
    display: block;
    width: clamp(26px, 4vw, 42px);
    height: clamp(36px, 5.5vw, 58px);
    border-radius: 5px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
}
.live-card-shape--yellow { background: linear-gradient(135deg, #fde047, #ca8a04); }
.live-card-shape--red    { background: linear-gradient(135deg, #f87171, #b91c1c); }

/* ── Event type label ── */
.live-event-type-label {
    font-size: clamp(0.65rem, 1.5vw, 0.85rem);
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.22em;
    color: rgba(240,244,255,0.5);
    margin: 0;
}

/* ── "¡Goooll!!" shout — vibrant green celebration text ── */
.live-event-goal-shout {
    margin: 0.25rem 0 0.35rem;
    line-height: 1;
    animation: goalShoutPop 0.55s cubic-bezier(0.22,1.4,0.36,1) both;
}
.live-event-goal-shout__text {
    display: inline-block;
    font-size: clamp(2.6rem, 7.5vw, 5rem);
    font-weight: 900;
    letter-spacing: -0.02em;
    text-transform: uppercase;
    background: linear-gradient(180deg, #86efac 0%, #22c55e 45%, #15803d 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent;
    filter: drop-shadow(0 0 18px rgba(34,197,94,0.55))
            drop-shadow(0 6px 20px rgba(0,0,0,0.55));
    text-shadow: 0 0 1px rgba(134,239,172,0.35);
    animation: goalShoutGlow 1.4s ease-in-out infinite alternate;
    transform-origin: center;
}
@keyframes goalShoutPop {
    0%   { opacity: 0; transform: scale(0.4) rotate(-6deg); }
    60%  { opacity: 1; transform: scale(1.15) rotate(2deg); }
    100% { opacity: 1; transform: scale(1) rotate(0); }
}
@keyframes goalShoutGlow {
    from { filter: drop-shadow(0 0 12px rgba(34,197,94,0.45)) drop-shadow(0 6px 20px rgba(0,0,0,0.55)); }
    to   { filter: drop-shadow(0 0 28px rgba(34,197,94,0.85)) drop-shadow(0 6px 20px rgba(0,0,0,0.55)); }
}

/* ── Player photo ── */
/* .live-event-photo-wrap { margin: 0.5rem 0; } */
/* .live-event-photo {
    width: clamp(160px, 24vw, 260px);
    height: clamp(160px, 24vw, 260px);
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.18);
    box-shadow: 0 12px 50px rgba(0,0,0,0.7);
    animation: photoAppear 0.5s 0.1s cubic-bezier(0.22,1,0.36,1) both;
} */
/* .live-event-photo--team {
    object-fit: contain;
    padding: 12px;
} */
.live-Ç
@keyframes photoAppear {
    0%   { opacity: 0; transform: scale(0.7); }
    100% { opacity: 1; transform: scale(1); }
}

/* ── Player name ── */
.live-event-player {
    font-size: clamp(1.6rem, 4.5vw, 3rem);
    font-weight: 900;
    letter-spacing: -0.03em;
    color: #f0f4ff;
    line-height: 1.05;
    margin: 0.25rem 0 0;
    animation: slideUp 0.4s 0.15s ease both;
}

/* ── Team ── */
.live-event-team {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    font-size: clamp(0.85rem, 2vw, 1.1rem);
    font-weight: 600;
    color: rgba(240,244,255,0.6);
    margin: 0;
    animation: slideUp 0.4s 0.2s ease both;
}
.live-event-team-icon {
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    opacity: 0.5;
}

/* ── Minute ── */
.live-event-minute {
    font-size: clamp(0.78rem, 1.6vw, 0.95rem);
    font-weight: 700;
    color: rgba(240,244,255,0.35);
    margin: 0;
    letter-spacing: 0.05em;
}

/* ── Progress countdown bar ── */
.live-event-progress-track {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(255,255,255,0.06);
    overflow: hidden;
    border-radius: 0 0 28px 28px;
}
.live-event-progress-bar {
    height: 100%;
    width: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0.55), rgba(255,255,255,0.15));
    transform-origin: left;
    animation: progressShrink linear forwards;
}
@keyframes progressShrink {
    from { transform: scaleX(1); }
    to   { transform: scaleX(0); }
}

/* ── Queue badge ── */
.live-event-queue {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: rgba(240,244,255,0.3);
    margin: 0.25rem 0 0;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
    /**
     * Alpine component that receives live-event-notification browser events
     * dispatched from the LiveDetail Livewire component (goals / cards) and
     * shows them one at a time in the fullscreen modal for ~15s each.
     *
     * IMPORTANT: this component sits inside a wire:ignore wrapper so its
     * state (queue, timer, visible flag) survives every wire:poll re-render.
     */
    document.addEventListener('alpine:init', () => {
        Alpine.data('liveSponsorCarousel', (sponsorCount) => ({
            repetitions: 1,
            observer: null,

            init() {
                this.observer = new ResizeObserver(() => this.resize());
                this.observer.observe(this.$el);
                this.$nextTick(() => this.resize());
            },

            resize() {
                const item = this.$el.querySelector('.live-sponsors__item');
                if (!item) return;

                const setWidth = item.getBoundingClientRect().width * sponsorCount;
                this.repetitions = Math.max(1, Math.ceil(this.$el.clientWidth / setWidth));
                this.$refs.track.style.setProperty('--sponsors-duration', `${setWidth * this.repetitions / 45}s`);
            },

            destroy() {
                this.observer.disconnect();
            },
        }));
        Alpine.data('liveEventModal', () => ({
            visible: false,
            queue: [],
            current: null,
            duration: 15000,
            timer: null,

            get isTeamGoal() {
                return this.current?.type === 'goal' && !this.current?.player_name;
            },

            get participantName() {
                return (this.isTeamGoal ? this.current?.team_name : this.current?.player_name) ?? '';
            },

            get participantPhoto() {
                return (this.isTeamGoal ? this.current?.team_logo : this.current?.player_photo) ?? null;
            },

            enqueue(detail) {
                // Livewire 3 may deliver the payload either as a plain object
                // (named-args dispatch) or wrapped in an array (positional).
                // Normalise both shapes so the template can bind directly.
                let payload = detail;
                if (Array.isArray(detail)) {
                    payload = detail[0];
                } else if (detail && typeof detail === 'object' && detail[0] !== undefined && detail.type === undefined) {
                    payload = detail[0];
                }
                if (!payload) return;

                this.queue.push(payload);
                if (!this.visible) {
                    this.showNext();
                }
            },

            showNext() {
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }

                if (this.queue.length === 0) {
                    this.visible = false;
                    this.current = null;
                    return;
                }

                this.current = this.queue.shift();
                this.visible = true;

                this.timer = setTimeout(() => this.showNext(), this.duration);
            },
        }));
    });
</script>
@endpush
