/**
 * SVA Club Portal - Matches Widget
 * Versión 1.0
 * 
 * Uso:
 * <script src="https://vaed.es/widget/matches.js"></script>
 * <div id="club-matches" data-limit="10" data-team-id="" data-upcoming="false"></div>
 */

(function() {
    'use strict';
    
    // IMPORTANTE: Cambia esta URL por la URL de tu servidor portal
    // Donde está alojado Laravel con la API
    const API_BASE_URL = window.CLUB_PORTAL_API_URL || 'https://vaed.es';
    const API_ENDPOINT = '/api/v1/public/matches';
    
    // Auto-detect domain
    const currentDomain = window.location.hostname.replace(/^www\./, '');
    
    // Default configuration
    const defaultConfig = {
        containerId: 'club-matches',
        limit: 25,
        teamId: null,
        upcoming: false,
        past: false,
        apiUrl: API_BASE_URL + API_ENDPOINT,
        showTeamFilter: true,
        showLogo: false,
        locale: 'es',
    };
    
    // Translations
    const translations = {
        es: {
            loading: 'Cargando partidos...',
            error: 'Error al cargar los partidos',
            noMatches: 'No hay partidos disponibles',
            noActiveSeason: 'El club no tiene ninguna temporada activa',
            noActiveSeasonDesc: 'No se pueden mostrar partidos hasta que se active una nueva temporada',
            vs: 'vs',
            home: 'Local',
            away: 'Visitante',
            matchday: 'Jornada',
            time: 'Hora',
            meeting: 'Citación',
            allTeams: 'Todos los equipos',
        },
    };
    
    // ==========================================
    // PLANTILLAS HTML - Fácil de editar
    // ==========================================
    const TEMPLATES = {
        'loading': `
            <div style="text-align: center; padding: 40px; color: #666;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <p style="margin-top: 16px;">{{loading}}</p>
            </div>
            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `,
        
        'error': `
            <div style="background: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 16px; color: #c33; text-align: center;">
                <strong>{{error}}</strong>
                <p style="margin-top: 8px; font-size: 14px;">{{message}}</p>
            </div>
        `,
        
        'no-matches': `
            <div style="text-align: center; padding: 40px; color: #999;">
                <p>{{noMatches}}</p>
            </div>
        `,
        
        'no-active-season': `
            <div style="text-align: center; padding: 40px;">
                <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 12px; padding: 24px; max-width: 500px; margin: 0 auto;">
                    <svg style="width: 48px; height: 48px; color: #ff9800; margin-bottom: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 style="margin: 0 0 12px 0; color: #856404; font-size: 18px; font-weight: 700;">{{title}}</h3>
                    <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.5;">{{description}}</p>
                </div>
            </div>
        `,
        
        'logo': ``,
        
        'team-filter': `
            <div style="margin-bottom: 28px; position: relative;">
                <div class="team-filter-container" style="position: relative;">
                    <button class="nav-btn nav-left" onclick="window.clubMatchesWidget.scrollTeams('left')" style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; background: #ffffff; border: 2px solid #e0e0e0; border-radius: 50%; display: none; align-items: center; justify-content: center; cursor: pointer; z-index: 3; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                        <svg style="width: 20px; height: 20px; color: #333;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="nav-btn nav-right" onclick="window.clubMatchesWidget.scrollTeams('right')" style="position: absolute; right: -15px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; background: #ffffff; border: 2px solid #e0e0e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 3; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                        <svg style="width: 20px; height: 20px; color: #333;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <div class="fade-left" style="position: absolute; left: 0; top: 0; bottom: 24px; width: 30px; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%); pointer-events: none; z-index: 2; opacity: 0; transition: opacity 0.3s ease;"></div>
                    <div class="fade-right" style="position: absolute; right: 0; top: 0; bottom: 24px; width: 30px; background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%); pointer-events: none; z-index: 2; opacity: 1; transition: opacity 0.3s ease;"></div>
                    <div class="team-filter-scroll" style="display: flex; gap: 12px; overflow-x: auto; overflow-y: hidden; padding: 12px 4px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
                        <button onclick="window.clubMatchesWidget.filterByTeam('')" 
                                class="team-filter-card {{allActive}}" 
                                style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 90px; padding: 12px 16px; background: {{allBg}}; border-radius: 16px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: {{allShadow}}; border: none;">
                            <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.9); border-radius: 12px; transition: transform 0.3s ease;">
                                <svg style="width: 24px; height: 24px; color: {{allIconColor}};" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span style="font-size: 12px; font-weight: 600; color: {{allColor}}; text-align: center; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90px;">{{allTeams}}</span>
                        </button>
                        {{teams}}
                    </div>
                </div>
                <div class="scroll-indicator-container" style="position: relative; height: 24px; padding-top: 8px;">
                    <div class="scroll-hint" style="text-align: center; color: #999; font-size: 11px; margin-bottom: 4px; opacity: 1; transition: opacity 0.3s ease;">
                        <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; animation: slideHint 1.5s ease-in-out infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Desliza para ver más
                        <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; animation: slideHint 1.5s ease-in-out infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <div class="scroll-indicator" style="height: 6px; background: #e8e8e8; border-radius: 3px; overflow: hidden;">
                        <div class="scroll-progress" style="height: 100%; background: linear-gradient(90deg, #000000, #404040); border-radius: 3px; width: 0%; transition: width 0.1s ease;"></div>
                    </div>
                </div>
            </div>
        `,
        
        'team-filter-button': `
            <button onclick="window.clubMatchesWidget.filterByTeam('{{teamId}}')" 
                    class="team-filter-card {{active}}"
                    style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 90px; max-width: 110px; padding: 12px 8px; background: {{bg}}; border-radius: 16px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: {{shadow}}; border: none;">
                <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.9); border-radius: 12px; padding: 6px; transition: transform 0.3s ease;">
                    {{logo}}
                </div>
                <span style="font-size: 11px; font-weight: 600; color: {{color}}; text-align: center; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; width: 100%; word-break: break-word;">{{teamName}}</span>
            </button>
        `,
        
        'matches-grid': `
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                {{matches}}
            </div>
        `,
        
        'match-header': `
            <div style="background: #000000; padding: 12px 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 6px; color: white;">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span style="font-weight: 600; font-size: 13px;">{{date}}</span>
                        {{hour}}
                    </div>
                    {{matchday}}
                </div>
            </div>
        `,
        
        'team': `
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 12px; padding: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                    {{logo}}
                </div>
                <div style="text-align: center;">
                    <div style="font-weight: 700; font-size: 14px; color: #1e293b; line-height: 1.3;">{{teamName}}</div>
                    {{category}}
                </div>
            </div>
        `,
        
        'team-logo': `
            <img src="{{logoUrl}}" alt="{{teamName}}" style="width: 100%; height: 100%; object-fit: contain;">
        `,
        
        'team-icon': `
            <svg style="width: 40px; height: 40px; color: #64748b;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        `,
        
        'score-result': `
            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; min-width: 80px;">
                <div class="match-score-display" style="display: flex; align-items: center; gap: 10px; background: #f5f5f5; padding: 12px 20px; border-radius: 8px; border: 2px solid #e0e0e0;">
                    <span class="match-score-number" style="font-size: 32px; font-weight: 900; color: {{colorLeft}}; line-height: 1;">{{goalsLeft}}</span>
                    <span class="match-score-separator" style="font-size: 20px; color: #666666; font-weight: 600;">VS</span>
                    <span class="match-score-number" style="font-size: 32px; font-weight: 900; color: {{colorRight}}; line-height: 1;">{{goalsRight}}</span>
                </div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #666666; font-weight: 600;">Final</div>
            </div>
        `,
        
        'score-upcoming': `
            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; min-width: 80px;">
                <div style="background: #333333; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">VS</div>
                {{hour}}
            </div>
        `,
        
        'site-info': `
            <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 12px; color: #64748b;">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span style="font-weight: 600;">{{siteName}}</span>
                {{badge}}
            </div>
        `,
        
        'site-badge': `
            <span style="margin-left: 6px; font-size: 10px; background: {{bgColor}}; color: {{textColor}}; padding: 2px 8px; border-radius: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;">
                {{label}}
            </span>
        `,
        
        'match-modal': `
            <div id="match-modal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; animation: fadeIn 0.3s ease;">
                <div style="background: #ffffff; border-radius: 8px; max-width: 900px; width: 100%; max-height: 90vh; overflow-y: auto; position: relative;">
                    <div style="position: sticky; top: 0; background: #000000; color: white; padding: 20px; border-radius: 8px 8px 0 0; z-index: 10; display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0; font-size: 20px; font-weight: 700;">Detalles del Partido</h3>
                        <button onclick="window.clubMatchesWidget.closeModal()" style="background: transparent; border: none; color: white; font-size: 28px; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; line-height: 1;">&times;</button>
                    </div>
                    <div id="match-modal-content" style="padding: 24px;">
                        {{content}}
                    </div>
                </div>
            </div>
        `,
        
        'modal-loading': `
            <div style="text-align: center; padding: 40px;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #000000; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <p style="margin-top: 16px; color: #666;">Cargando detalles...</p>
            </div>
        `,
        
        'modal-content': `
            <div style="margin-bottom: 24px; padding: 16px; background: #f8fafc; border-radius: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 20px;">
                    <div style="flex: 1; text-align: center;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 12px; padding: 12px;">
                            {{leftLogo}}
                        </div>
                        <div style="font-weight: 700; font-size: 16px;">{{leftName}}</div>
                        <div style="font-size: 12px; color: #666;">{{leftCategory}}</div>
                        {{leftGoals}}
                    </div>
                    <div style="flex-shrink: 0; text-align: center;">
                        {{separator}}
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 12px; padding: 12px;">
                            {{rightLogo}}
                        </div>
                        <div style="font-weight: 700; font-size: 16px;">{{rightName}}</div>
                        <div style="font-size: 12px; color: #666;">{{rightCategory}}</div>
                        {{rightGoals}}
                    </div>
                </div>
                <div style="text-align: center; padding-top: 12px; border-top: 2px solid #e0e0e0;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 4px;">{{date}} • {{hour}}</div>
                    <div style="font-size: 13px; color: #999;">{{siteName}}</div>
                </div>
            </div>
            
            {{webDescription}}
            
            {{gallery}}
            
            {{lineup}}
        `,
        
        'web-description': `
            <div style="margin-bottom: 24px; padding: 16px; background: #fff; border: 2px solid #e0e0e0; border-radius: 12px;">
                <h4 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 700; color: #000;">Descripción del Partido</h4>
                <div style="font-size: 14px; line-height: 1.6; color: #333;">{{description}}</div>
            </div>
        `,
        
        'match-gallery': `
            <div style="margin-bottom: 24px;">
                <h4 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: #000; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Galería del Partido
                </h4>
                <div class="match-gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                    {{images}}
                </div>
            </div>
        `,
        
        'gallery-image': `
            <div style="position: relative; border-radius: 12px; overflow: hidden; aspect-ratio: 4/3; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <img src="{{imageUrl}}" alt="Imagen del partido" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.3), transparent); pointer-events: none;"></div>
            </div>
        `,
        
        'lineup-section': `
            <div style="margin-bottom: 24px;">
                <h4 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 700; color: #000; text-align: center;">Alineación Titular</h4>
                <div style="margin-bottom: 16px; text-align: center; padding: 8px; background: #000; color: white; border-radius: 8px; font-weight: 600;">
                  
                </div>
                <div style="background: linear-gradient(180deg, #2d5016 0%, #3d7022 50%, #2d5016 100%); border-radius: 12px; padding: 24px; position: relative; min-height: 500px;">
                    <!-- Campo de fútbol -->
                    <div style="position: absolute; top: 24px; left: 24px; right: 24px; bottom: 24px; border: 3px solid rgba(255,255,255,0.5); border-radius: 8px;">
                        <!-- Línea central -->
                        <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 3px; background: rgba(255,255,255,0.5); transform: translateX(-50%);"></div>
                        <!-- Círculo central -->
                        <div style="position: absolute; left: 50%; top: 50%; width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.5); border-radius: 50%; transform: translate(-50%, -50%);"></div>
                        <!-- Área superior -->
                        <div style="position: absolute; top: 0; left: 50%; width: 40%; height: 20%; border: 3px solid rgba(255,255,255,0.5); border-top: none; transform: translateX(-50%);"></div>
                        <!-- Área inferior -->
                        <div style="position: absolute; bottom: 0; left: 50%; width: 40%; height: 20%; border: 3px solid rgba(255,255,255,0.5); border-bottom: none; transform: translateX(-50%);"></div>
                        
                        <!-- Jugadores -->
                        {{players}}
                    </div>
                </div>
            </div>
        `,
        
        'player-position': `
            <div style="position: absolute; left: {{x}}%; top: {{y}}%; transform: translate(-50%, -50%); text-align: center; z-index: 2;">
                <div style="position: relative; width: 60px; height: 60px;">
                    {{image}}
                    <div style="position: absolute; bottom: -2px; right: -2px; width: 22px; height: 22px; background: #000000; border: 2px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 11px; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        {{number}}
                    </div>
                </div>
                <div style="margin-top: 4px; font-size: 11px; font-weight: 700; color: white; background: rgba(0,0,0,0.7); padding: 4px 8px; border-radius: 6px; white-space: nowrap; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                    {{name}}
                </div>
            </div>
        `,
        
        'bench-section': `
            <div style="margin-bottom: 24px;">
                <h4 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: #000;">Banquillo</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;">
                    {{players}}
                </div>
            </div>
        `,
        
        'bench-player': `
            <div style="background: #f8fafc; border: 2px solid #e0e0e0; border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 10px;">
                <div style="position: relative; width: 44px; height: 44px; flex-shrink: 0;">
                    {{image}}
                    <div style="position: absolute; bottom: -2px; right: -2px; width: 18px; height: 18px; background: #000000; border: 2px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 10px;">
                        {{number}}
                    </div>
                </div>
                <div style="font-size: 13px; font-weight: 600; color: #333; overflow: hidden; text-overflow: ellipsis;">{{name}}</div>
            </div>
        `,
    };
    
    // Template Manager - Gestiona las plantillas HTML
    class TemplateManager {
        constructor() {
            this.templates = TEMPLATES;
            this.loaded = true;
        }
        
        async loadTemplates() {
            // Las plantillas ya están cargadas en el objeto TEMPLATES
            return Promise.resolve();
        }
        
        get(templateName, data = {}) {
            let template = this.templates[templateName] || '';
            
            // Reemplazar variables {{variable}}
            Object.keys(data).forEach(key => {
                const regex = new RegExp(`{{${key}}}`, 'g');
                template = template.replace(regex, data[key] !== undefined ? data[key] : '');
            });
            
            return template;
        }
    }
    
    class ClubMatchesWidget {
        constructor(config) {
            this.config = { ...defaultConfig, ...config };
            this.container = document.getElementById(this.config.containerId);
            this.t = translations[this.config.locale] || translations.es;
            this.templateManager = new TemplateManager();
            
            if (!this.container) {
                console.error(`Container with id "${this.config.containerId}" not found`);
                return;
            }
            
            this.init();
        }
        
        async init() {
            this.showLoading();
            
            try {
                // Cargar plantillas primero
                await this.templateManager.loadTemplates();
                
                const matches = await this.fetchMatches();
                
                // Verificar si hay temporada activa (mensaje del backend)
                if (!matches.success && matches.message && matches.message.toLowerCase().includes('temporada activa')) {
                    this.showNoActiveSeason();
                    return;
                }
                
                const teams = this.config.showTeamFilter ? await this.fetchTeams() : [];
                this.render(matches, teams);
            } catch (error) {
                this.showError(error.message);
            }
        }
        
        async fetchMatches() {
            const params = new URLSearchParams({
                domain: currentDomain,
                limit: this.config.limit,
            });
            
            if (this.config.teamId) params.append('team_id', this.config.teamId);
            if (this.config.upcoming) params.append('upcoming', 'true');
            if (this.config.past) params.append('past', 'true');
            
            const response = await fetch(`${this.config.apiUrl}?${params.toString()}`);
            
            if (!response.ok) {
                throw new Error('Failed to fetch matches');
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Unknown error');
            }
            
            return data;
        }
        
        async fetchTeams() {
            const params = new URLSearchParams({
                domain: currentDomain,
            });
            
            const response = await fetch(`${API_BASE_URL}/api/v1/public/teams?${params.toString()}`);
            
            if (!response.ok) return [];
            
            const data = await response.json();
            return data.success ? data.data : [];
        }
        
        showLoading() {
            this.container.innerHTML = this.getLoadingTemplate();
        }
        
        showError(message) {
            this.container.innerHTML = this.getErrorTemplate(message);
        }
        
        showNoActiveSeason() {
            const styles = this.getStyles();
            this.container.innerHTML = `
                <div class="club-matches-widget">
                    ${this.getNoActiveSeasonTemplate()}
                </div>
                ${styles}
            `;
        }
        
        render(data, teams) {
            // Guardar el logo de la escuela para usar en las plantillas
            this.schoolLogo = data.meta.sports_school.logo;
            
            const header = this.getHeaderTemplate(data.meta.sports_school, teams);
            const styles = this.getStyles();
            const title = `<h2 style="text-align: center; color: #000000; font-size: 32px; font-weight: 700; margin: 0 0 32px 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Partidos y Resultados.</h2>`;
            
            // Si no hay partidos, mostrar mensaje pero mantener el header con filtros
            if (!data.data || data.data.length === 0) {
                this.container.innerHTML = `
                    <div class="club-matches-widget">
                        ${title}
                        ${header}
                        ${this.getNoMatchesTemplate()}
                    </div>
                    ${styles}
                `;
                return;
            }
            
            const matchesGrid = this.getMatchesGridTemplate(data.data);
            
            this.container.innerHTML = `
                <div class="club-matches-widget">
                    ${title}
                    ${header}
                    ${matchesGrid}
                </div>
                ${styles}
            `;
        }
        
        renderMatch(match) {
            const hasResult = (match.goals_team !== null && match.goals_team !== undefined) || 
                            (match.goals_oponent !== null && match.goals_oponent !== undefined);
            
            const goalsTeam = match.goals_team ?? 0;
            const goalsOponent = match.goals_oponent ?? 0;
            
            const header = this.getMatchCardHeaderTemplate(match);
            const content = this.getMatchCardContentTemplate(match, hasResult, goalsTeam, goalsOponent);
            const footer = this.getMatchCardFooterTemplate(match);
            
            return `
                <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; transition: all 0.3s ease; border: 2px solid #e0e0e0; cursor: pointer;" 
                     onclick="window.clubMatchesWidget.openMatchDetails(${match.id})"
                     onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'; this.style.borderColor='#000000';" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'; this.style.borderColor='#e0e0e0';">
                    ${header}
                    ${content}
                    ${footer}
                </div>
            `;
        }
        
        
        // ==========================================
        // TEMPLATE METHODS
        // ==========================================
        
        getLoadingTemplate() {
            return this.templateManager.get('loading', {
                loading: this.t.loading
            });
        }
        
        getErrorTemplate(message) {
            return this.templateManager.get('error', {
                error: this.t.error,
                message: message
            });
        }
        
        getNoMatchesTemplate() {
            return this.templateManager.get('no-matches', {
                noMatches: this.t.noMatches
            });
        }
        
        getNoActiveSeasonTemplate() {
            return this.templateManager.get('no-active-season', {
                title: this.t.noActiveSeason,
                description: this.t.noActiveSeasonDesc
            });
        }
        
        getHeaderTemplate(sportsSchool, teams) {
            let html = '';
            
            // Logo
            if (this.config.showLogo && sportsSchool.logo) {
                html += this.templateManager.get('logo', {
                    logoUrl: sportsSchool.logo,
                    schoolName: sportsSchool.name
                });
            }
            
            // Team filter
            if (this.config.showTeamFilter && teams.length > 0) {
                const isAllActive = !this.config.teamId;
                const teamsButtons = teams.map(team => {
                    const isActive = this.config.teamId == team.id;
                    const logoHtml = this.schoolLogo ? 
                        `<img src="${this.schoolLogo}" alt="${team.name}" style="width: 100%; height: 100%; object-fit: contain;">` :
                        `<svg style="width: 28px; height: 28px; color: #999999;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>`;
                    
                    return this.templateManager.get('team-filter-button', {
                        teamId: team.id,
                        teamName: team.name + (team.category ? '\n' + team.category : ''),
                        logo: logoHtml,
                        active: isActive ? 'active' : '',
                        bg: isActive ? 'linear-gradient(135deg, #000000 0%, #2d2d2d 100%)' : '#ffffff',
                        color: isActive ? '#ffffff' : '#1a1a1a',
                        shadow: isActive ? '0 8px 24px rgba(0,0,0,0.25), 0 0 0 2px #000000' : '0 2px 8px rgba(0,0,0,0.08)'
                    });
                }).join('');
                
                html += this.templateManager.get('team-filter', {
                    allTeams: this.t.allTeams,
                    teams: teamsButtons,
                    allActive: isAllActive ? 'active' : '',
                    allBg: isAllActive ? 'linear-gradient(135deg, #000000 0%, #2d2d2d 100%)' : '#ffffff',
                    allColor: isAllActive ? '#ffffff' : '#1a1a1a',
                    allIconColor: isAllActive ? '#ffffff' : '#666666',
                    allShadow: isAllActive ? '0 8px 24px rgba(0,0,0,0.25), 0 0 0 2px #000000' : '0 2px 8px rgba(0,0,0,0.08)'
                });
            }
            
            return html;
        }
        
        getMatchesGridTemplate(matches) {
            const matchesHtml = matches.map(match => this.renderMatch(match)).join('');
            return this.templateManager.get('matches-grid', {
                matches: matchesHtml
            });
        }
        
        getMatchCardHeaderTemplate(match) {
            const hourHtml = match.hour_match ? `<span style="font-size: 12px; opacity: 0.9;">• ${match.hour_match}</span>` : '';
            const matchdayHtml = match.matchday ? `<span style="font-size: 11px; background: #333333; color: white; padding: 4px 10px; border-radius: 4px; font-weight: 600;">Jornada ${match.matchday}</span>` : '';
            
            return this.templateManager.get('match-header', {
                date: this.formatDate(match.date),
                hour: hourHtml,
                matchday: matchdayHtml
            });
        }
        
        getMatchCardContentTemplate(match, hasResult, goalsTeam, goalsOponent) {
            return `
                <div style="padding: 24px 20px; background: white;">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
                        ${match.sites === 'home' 
                            ? this.getHomeMatchLayoutTemplate(match, hasResult, goalsTeam, goalsOponent)
                            : this.getAwayMatchLayoutTemplate(match, hasResult, goalsTeam, goalsOponent)
                        }
                    </div>
                </div>
            `;
        }
        
        getHomeMatchLayoutTemplate(match, hasResult, goalsTeam, goalsOponent) {
            return `
                ${this.getTeamTemplate(match.team, match.escudo_team)}
                ${this.getScoreTemplate(hasResult, goalsTeam, goalsOponent, match.hour_match)}
                ${this.getOpponentTemplate(match.opponent, match.escudo_team_oponent)}
            `;
        }
        
        getAwayMatchLayoutTemplate(match, hasResult, goalsTeam, goalsOponent) {
            return `
                ${this.getOpponentTemplate(match.opponent, match.escudo_team_oponent)}
                ${this.getScoreTemplate(hasResult, goalsOponent, goalsTeam, match.hour_match)}
                ${this.getTeamTemplate(match.team, match.escudo_team)}
            `;
        }
        
        getTeamTemplate(team, escudo) {
            return `
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 8px; padding: 8px; border: 1px solid #e0e0e0;">
                        ${this.schoolLogo ? `
                            <img src="${this.schoolLogo}" alt="${team.name}" style="width: 100%; height: 100%; object-fit: contain;">
                        ` : `
                            <svg style="width: 40px; height: 40px; color: #666666;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        `}
                    </div>
                    <div style="text-align: center;">
                        <div style="font-weight: 700; font-size: 14px; color: #000000; line-height: 1.3;">${team.name}</div>
                        ${team.category ? `<div style="font-size: 11px; color: #666666; margin-top: 2px;">${team.category}</div>` : ''}
                    </div>
                </div>
            `;
        }
        
        getOpponentTemplate(opponentName, escudo) {
            return `
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 8px; padding: 8px; border: 1px solid #e0e0e0;">
                        ${escudo ? `
                            <img src="${escudo}" alt="${opponentName}" style="width: 100%; height: 100%; object-fit: contain;">
                        ` : `
                            <svg style="width: 40px; height: 40px; color: #666666;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        `}
                    </div>
                    <div style="text-align: center;">
                        <div style="font-weight: 700; font-size: 14px; color: #000000; line-height: 1.3;">${opponentName}</div>
                    </div>
                </div>
            `;
        }
        
        getScoreTemplate(hasResult, goalsLeft, goalsRight, hourMatch) {
            if (hasResult) {
                return `
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; min-width: 80px;">
                        <div style="display: flex; align-items: center; gap: 10px; background: #f5f5f5; padding: 12px 20px; border-radius: 8px; border: 2px solid #e0e0e0;">
                            <span style="font-size: 32px; font-weight: 900; color: ${goalsLeft > goalsRight ? '#000000' : goalsLeft < goalsRight ? '#666666' : '#333333'}; line-height: 1;">${goalsLeft}</span>
                            <span style="font-size: 20px; color: #666666; font-weight: 600;">-</span>
                            <span style="font-size: 32px; font-weight: 900; color: ${goalsRight > goalsLeft ? '#000000' : goalsRight < goalsLeft ? '#666666' : '#333333'}; line-height: 1;">${goalsRight}</span>
                        </div>
                        <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #666666; font-weight: 600;">Final</div>
                    </div>
                `;
            } else {
                return `
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; min-width: 80px;">
                        <div style="background: #333333; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">VS</div>
                        ${hourMatch ? `<div style="font-size: 11px; color: #666666; font-weight: 600; margin-top: 4px;">${hourMatch}</div>` : ''}
                    </div>
                `;
            }
        }
        
        getMatchCardFooterTemplate(match) {
            if (!match.site && !match.web_description) {
                return '';
            }
            
            return `
                <div style="background: #f5f5f5; padding: 12px 16px; border-top: 1px solid #e0e0e0;">
                    ${match.site ? `
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 12px; color: #333333;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span style="font-weight: 600;">${match.site}</span>
                            ${match.sites ? `
                                <span style="margin-left: 6px; font-size: 10px; background: ${match.sites === 'home' ? '#000000' : '#666666'}; color: #ffffff; padding: 2px 8px; border-radius: 4px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;">
                                    ${match.sites === 'home' ? 'Local' : 'Visitante'}
                                </span>
                            ` : ''}
                        </div>
                    ` : ''}
                    ${match.web_description ? `
                        <div style="margin-top: ${match.site ? '10px' : '0'};">
                            <div style="font-size: 12px; color: #333333; line-height: 1.5; text-align: left; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                ${match.web_description}
                            </div>
                            <div style="margin-top: 6px; text-align: center;">
                                <span style="font-size: 11px; color: #000000; font-weight: 600; cursor: pointer; text-decoration: underline;">Leer más</span>
                            </div>
                        </div>
                    ` : ''}
                </div>
            `;
        }
        
        // ==========================================
        // UTILITY METHODS
        // ==========================================
        
        formatDate(dateString) {
            const date = new Date(dateString);
            const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
            return date.toLocaleDateString(this.config.locale, options);
        }
        
        filterByTeam(teamId) {
            this.config.teamId = teamId || null;
            this.init();
        }
        
        scrollTeams(direction) {
            const scrollContainer = document.querySelector('.team-filter-scroll');
            if (!scrollContainer) return;
            
            const scrollAmount = 300; // Desplazamiento en pixels
            const currentScroll = scrollContainer.scrollLeft;
            
            if (direction === 'left') {
                scrollContainer.scrollLeft = currentScroll - scrollAmount;
            } else {
                scrollContainer.scrollLeft = currentScroll + scrollAmount;
            }
        }
        
        async openMatchDetails(matchId) {
            // Crear y mostrar el modal con loading
            const modalHtml = this.templateManager.get('match-modal', {
                content: this.templateManager.get('modal-loading', {})
            });
            
            // Añadir modal al DOM
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = modalHtml;
            document.body.appendChild(modalContainer.firstElementChild);
            
            // Obtener detalles del partido
            try {
                const matchDetails = await this.fetchMatchDetails(matchId);
                const content = this.renderModalContent(matchDetails);
                
                // Actualizar contenido del modal
                document.getElementById('match-modal-content').innerHTML = content;
            } catch (error) {
                console.error('Error loading match details:', error);
                document.getElementById('match-modal-content').innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <p>Error al cargar los detalles del partido</p>
                    </div>
                `;
            }
        }
        
        closeModal() {
            const modal = document.getElementById('match-modal');
            if (modal) {
                modal.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => modal.remove(), 300);
            }
        }
        
        async fetchMatchDetails(matchId) {
            const url = `${API_BASE_URL}/api/v1/public/matches/${matchId}?domain=${currentDomain}`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error('Failed to fetch match details');
            }
            
            const result = await response.json();
            return result.data;
        }
        
        renderModalContent(match) {
            const hasResult = match.goals_team !== null && match.goals_oponent !== null;
            
            // Team logo (escuela)
            const teamLogoHtml = this.schoolLogo 
                ? `<img src="${this.schoolLogo}" alt="${match.team.name}" style="width: 100%; height: 100%; object-fit: contain;">`
                : `<svg style="width: 50px; height: 50px; color: #999;" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/></svg>`;
            
            // Opponent logo
            const opponentLogoHtml = match.escudo_team_oponent 
                ? `<img src="${match.escudo_team_oponent}" alt="${match.opponent}" style="width: 100%; height: 100%; object-fit: contain;">`
                : `<svg style="width: 50px; height: 50px; color: #999;" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/></svg>`;
            
            // Determinar el orden según si es local o visitante
            const isHome = match.sites === 'home';
            const leftLogo = isHome ? teamLogoHtml : opponentLogoHtml;
            const leftName = isHome ? match.team.name : match.opponent;
            const leftCategory = isHome ? (match.team.category || '') : '';
            const rightLogo = isHome ? opponentLogoHtml : teamLogoHtml;
            const rightName = isHome ? match.opponent : match.team.name;
            const rightCategory = isHome ? '' : (match.team.category || '');
            
            // Goles por lado
            let leftGoals = '';
            let rightGoals = '';
            let separator = '';
            
            if (hasResult) {
                const teamGoals = match.goals_team ?? 0;
                const opponentGoals = match.goals_oponent ?? 0;
                
                // Invertir goles según si es local o visitante (igual que en la vista general)
                // Si isHome: escuela(teamGoals) - rival(opponentGoals)
                // Si away: rival(opponentGoals) - escuela(teamGoals)
                const leftGoalsValue = isHome ? teamGoals : opponentGoals;
                const rightGoalsValue = isHome ? opponentGoals : teamGoals;
                
                leftGoals = `<div class="modal-score-result" style="font-size: 48px; font-weight: 900; color: #000; margin-top: 12px;">${leftGoalsValue}</div>`;
                rightGoals = `<div class="modal-score-result" style="font-size: 48px; font-weight: 900; color: #000; margin-top: 12px;">${rightGoalsValue}</div>`;
                separator = `<div style="font-size: 32px; font-weight: 700; color: #666;">VS</div>`;
            } else {
                separator = `<div style="background: #333; color: white; padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 700;">VS</div>`;
            }
            
            // Web description
            let webDescriptionHtml = '';
            if (match.web_description && match.web_description.trim !== '') {
                webDescriptionHtml = this.templateManager.get('web-description', {
                    description: match.web_description
                });
            }
            
            // Match Gallery
            let galleryHtml = '';
            if (match.match_images && match.match_images.length > 0) {
                let imagesHtml = '';
                match.match_images.forEach(imageUrl => {
                    imagesHtml += this.templateManager.get('gallery-image', {
                        imageUrl: imageUrl
                    });
                });
                galleryHtml = this.templateManager.get('match-gallery', {
                    images: imagesHtml
                });
            }
            
            // Lineup
            let lineupHtml = '';
            if (match.formation && match.lineup && match.lineup.starters && match.lineup.starters.length > 0) {
                lineupHtml = this.renderLineup(match.formation, match.lineup);
            }
            
            return this.templateManager.get('modal-content', {
                leftLogo: leftLogo,
                leftName: leftName,
                leftCategory: leftCategory,
                leftGoals: leftGoals,
                rightLogo: rightLogo,
                rightName: rightName,
                rightCategory: rightCategory,
                rightGoals: rightGoals,
                separator: separator,
                date: this.formatDate(match.date),
                hour: match.hour_match || '-',
                siteName: match.site || 'Por confirmar',
                webDescription: webDescriptionHtml,
                gallery: galleryHtml,
                lineup: lineupHtml
            });
        }
        
        renderLineup(formation, lineup) {
            const positions = this.getFormationPositions(formation);
            
            // Renderizar jugadores titulares
            let playersHtml = '';
            lineup.starters.forEach((player, index) => {
                if (positions[index]) {
                    const playerImage = player.player_photo 
                        ? `<img src="${player.player_photo}" alt="${player.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">`
                        : `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; border: 3px solid #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px;">${(player.name || 'J').charAt(0).toUpperCase()}</div>`;
                    
                    playersHtml += this.templateManager.get('player-position', {
                        x: positions[index].x,
                        y: positions[index].y,
                        image: playerImage,
                        number: player.number || index + 1,
                        name: player.name || 'Jugador'
                    });
                }
            });
            
            const lineupSectionHtml = this.templateManager.get('lineup-section', {
                formation: formation || 'No especificado',
                players: playersHtml
            });
            
            // Renderizar banquillo
            let benchHtml = '';
            if (lineup.bench && lineup.bench.length > 0) {
                let benchPlayersHtml = '';
                lineup.bench.forEach(player => {
                    const playerImage = player.player_photo 
                        ? `<img src="${player.player_photo}" alt="${player.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 2px solid #e0e0e0;">`
                        : `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px;">${(player.name || 'J').charAt(0).toUpperCase()}</div>`;
                    
                    benchPlayersHtml += this.templateManager.get('bench-player', {
                        image: playerImage,
                        number: player.number || '-',
                        name: player.name || 'Jugador'
                    });
                });
                
                benchHtml = this.templateManager.get('bench-section', {
                    players: benchPlayersHtml
                });
            }
            
            return lineupSectionHtml + benchHtml;
        }
        
        getFormationPositions(formation) {
            // Posiciones en el campo (x, y como porcentaje)
            // x: 0-100 (izquierda a derecha), y: 0-100 (arriba hacia abajo, atacando hacia arriba)
            const formations = {
                '4-4-2': [
                    // Portero
                    { x: 50, y: 90 },
                    // Defensas
                    { x: 20, y: 75 },
                    { x: 40, y: 75 },
                    { x: 60, y: 75 },
                    { x: 80, y: 75 },
                    // Centrocampistas
                    { x: 20, y: 50 },
                    { x: 40, y: 50 },
                    { x: 60, y: 50 },
                    { x: 80, y: 50 },
                    // Delanteros
                    { x: 35, y: 20 },
                    { x: 65, y: 20 }
                ],
                '4-3-3': [
                    { x: 50, y: 90 },
                    { x: 20, y: 75 },
                    { x: 40, y: 75 },
                    { x: 60, y: 75 },
                    { x: 80, y: 75 },
                    { x: 30, y: 55 },
                    { x: 50, y: 55 },
                    { x: 70, y: 55 },
                    { x: 20, y: 20 },
                    { x: 50, y: 20 },
                    { x: 80, y: 20 }
                ],
                '4-2-3-1': [
                    { x: 50, y: 90 },
                    { x: 20, y: 75 },
                    { x: 40, y: 75 },
                    { x: 60, y: 75 },
                    { x: 80, y: 75 },
                    { x: 35, y: 60 },
                    { x: 65, y: 60 },
                    { x: 20, y: 40 },
                    { x: 50, y: 40 },
                    { x: 80, y: 40 },
                    { x: 50, y: 15 }
                ],
                '3-5-2': [
                    { x: 50, y: 90 },
                    { x: 30, y: 75 },
                    { x: 50, y: 75 },
                    { x: 70, y: 75 },
                    { x: 15, y: 50 },
                    { x: 35, y: 50 },
                    { x: 50, y: 50 },
                    { x: 65, y: 50 },
                    { x: 85, y: 50 },
                    { x: 40, y: 20 },
                    { x: 60, y: 20 }
                ],
                '3-4-3': [
                    { x: 50, y: 90 },
                    { x: 30, y: 75 },
                    { x: 50, y: 75 },
                    { x: 70, y: 75 },
                    { x: 20, y: 55 },
                    { x: 40, y: 55 },
                    { x: 60, y: 55 },
                    { x: 80, y: 55 },
                    { x: 20, y: 20 },
                    { x: 50, y: 20 },
                    { x: 80, y: 20 }
                ]
            };
            
            // Si no se encuentra la formación, usar 4-4-2 por defecto
            return formations[formation] || formations['4-4-2'];
        }
        
        getStyles() {
            return `
                <style>
                    .club-matches-widget {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                        padding: 20px 40px;
                    }
                    .team-filter-scroll::-webkit-scrollbar {
                        display: none;
                    }
                    .team-filter-scroll {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }
                    .team-filter-card {
                        position: relative;
                        overflow: hidden;
                    }
                    .team-filter-card::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: linear-gradient(135deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 100%);
                        opacity: 0;
                        transition: opacity 0.3s ease;
                        pointer-events: none;
                    }
                    .team-filter-card:hover::before {
                        opacity: 1;
                    }
                    .team-filter-card:not(.active):hover {
                        transform: translateY(-4px) scale(1.02);
                        box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
                    }
                    .team-filter-card:not(.active):hover div {
                        transform: scale(1.1);
                    }
                    .team-filter-card:active {
                        transform: scale(0.96);
                    }
                    .team-filter-card.active {
                        animation: pulse 0.5s ease;
                    }
                    @keyframes pulse {
                        0%, 100% { transform: scale(1); }>
                        50% { transform: scale(1.05); }
                    }
                    @keyframes slideHint {
                        0%, 100% { transform: translateX(0); opacity: 1; }
                        50% { transform: translateX(4px); opacity: 0.6; }
                    }
                    .nav-btn:hover {
                        background: #000000 !important;
                        border-color: #000000 !important;
                        transform: translateY(-50%) scale(1.1) !important;
                    }
                    .nav-btn:hover svg {
                        color: #ffffff !important;
                    }
                    .nav-btn:active {
                        transform: translateY(-50%) scale(0.95) !important;
                    }
                    @media (max-width: 768px) {
                        .nav-btn {
                            display: none !important;
                        }
                        .club-matches-widget {
                            padding: 10px 20px;
                        }
                        .team-filter-card {
                            min-width: 80px;
                            max-width: 95px;
                            padding: 10px 6px;
                        }
                        .team-filter-scroll {
                            gap: 8px;
                        }
                        .scroll-hint {
                            display: block !important;
                        }
                        .match-gallery-grid {
                            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
                            gap: 8px !important;
                        }
                        .match-score-display {
                            padding: 8px 12px !important;
                            gap: 6px !important;
                        }
                        .match-score-number {
                            font-size: 18px !important;
                        }
                        .match-score-separator {
                            font-size: 14px !important;
                        }
                        .modal-score-result {
                            font-size: 32px !important;
                        }
                    }
                    @media (min-width: 769px) {
                        .scroll-hint {
                            display: none !important;
                        }
                    }
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                    @keyframes fadeOut {
                        from { opacity: 1; }
                        to { opacity: 0; }
                    }
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                    #match-modal {
                        overflow-y: auto;
                    }
                    #match-modal > div {
                        max-width: 100%;
                        width: 100%;
                        height: 100vh;
                        max-height: 100vh;
                    }
                    @media (max-width: 768px) {
                        #match-modal > div {
                            max-width: 100%;
                            width: 100%;
                            height: 100vh;
                            margin: 0;
                        }
                        #match-modal-content {
                            padding: 16px !important;
                        }
                    }
                </style>
                <script>
                    (function() {
                        const scrollContainer = document.querySelector('.team-filter-scroll');
                        const progressBar = document.querySelector('.scroll-progress');
                        const fadeLeft = document.querySelector('.fade-left');
                        const fadeRight = document.querySelector('.fade-right');
                        const scrollHint = document.querySelector('.scroll-hint');
                        const navLeft = document.querySelector('.nav-left');
                        const navRight = document.querySelector('.nav-right');
                        
                        if (scrollContainer && progressBar) {
                            function updateScrollIndicators() {
                                const scrollWidth = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                                const scrolled = scrollContainer.scrollLeft;
                                const progress = scrollWidth > 0 ? (scrolled / scrollWidth) * 100 : 100;
                                
                                progressBar.style.width = progress + '%';
                                
                                // Update fade effects
                                if (fadeLeft && fadeRight) {
                                    fadeLeft.style.opacity = scrolled > 20 ? '1' : '0';
                                    fadeRight.style.opacity = scrolled < (scrollWidth - 20) ? '1' : '0';
                                }
                                
                                // Update navigation buttons visibility
                                if (navLeft && navRight && window.innerWidth > 768) {
                                    const hasOverflow = scrollContainer.scrollWidth > scrollContainer.clientWidth;
                                    if (hasOverflow) {
                                        navLeft.style.display = scrolled > 20 ? 'flex' : 'none';
                                        navRight.style.display = scrolled < (scrollWidth - 20) ? 'flex' : 'none';
                                    } else {
                                        navLeft.style.display = 'none';
                                        navRight.style.display = 'none';
                                    }
                                }
                                
                                // Hide scroll hint after first interaction
                                if (scrollHint && scrolled > 10) {
                                    scrollHint.style.opacity = '0';
                                    setTimeout(() => { scrollHint.style.display = 'none'; }, 300);
                                }
                            }
                            
                            scrollContainer.addEventListener('scroll', updateScrollIndicators);
                            
                            // Initial check
                            setTimeout(updateScrollIndicators, 100);
                            
                            // Update on window resize
                            window.addEventListener('resize', updateScrollIndicators);
                        }
                    })();
                </script>
            `;
        }
    }
    
    // Auto-initialize on DOM ready
    function initWidget() {
        const container = document.getElementById('club-matches');
        if (!container) return;
        
        const config = {
            limit: parseInt(container.dataset.limit) || 10,
            teamId: container.dataset.teamId || null,
            upcoming: container.dataset.upcoming === 'true',
            past: container.dataset.past === 'true',
            showTeamFilter: container.dataset.showTeamFilter !== 'false',
            showLogo: container.dataset.showLogo !== 'false',
        };
        
        window.clubMatchesWidget = new ClubMatchesWidget(config);
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWidget);
    } else {
        initWidget();
    }
    
    // Export for manual initialization
    window.ClubMatchesWidget = ClubMatchesWidget;
    
})();
