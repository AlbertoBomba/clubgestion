@if ($showScheduleModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
         wire:keydown.window.escape="$set('showScheduleModal', false)">
        <form wire:submit="assignMatchSchedule" role="dialog" aria-modal="true" aria-labelledby="schedule-modal-title"
              class="bg-white-pure w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl p-6 space-y-5">
            <h3 id="schedule-modal-title" class="font-black text-lg text-titanium">Asignar hora automática</h3>
            <p class="text-sm text-titanium">
                Se asignarán horarios a todos los partidos del listado, en el orden mostrado, incluyendo todas sus fases y jornadas.
                Se sustituirán las fechas y horas existentes. Si se supera la medianoche, se continuará al día siguiente.
            </p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="schedule-date" class="block text-sm font-semibold text-titanium mb-1">Fecha inicial</label>
                    <input id="schedule-date" wire:model="schedule_date" type="date" required
                           aria-describedby="schedule-date-help"
                           class="w-full border border-silver rounded-xl px-3 py-2 text-sm"/>
                    <p id="schedule-date-help" class="text-xs text-titanium mt-1">Día en que comienza el primer partido del listado.</p>
                    @error('schedule_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="schedule-time" class="block text-sm font-semibold text-titanium mb-1">Hora del primer partido</label>
                    <input id="schedule-time" wire:model="schedule_time" type="time" required
                           aria-describedby="schedule-time-help"
                           class="w-full border border-silver rounded-xl px-3 py-2 text-sm"/>
                    <p id="schedule-time-help" class="text-xs text-titanium mt-1">Hora de inicio del primer partido. Los siguientes se calculan automáticamente.</p>
                    @error('schedule_time') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="schedule-parts" class="block text-sm font-semibold text-titanium mb-1">Número de partes</label>
                    <select id="schedule-parts" wire:model="schedule_parts" required
                            aria-describedby="schedule-parts-help"
                            class="w-full border border-silver rounded-xl px-3 py-2 text-sm">
                        <option value="1">Una parte</option>
                        <option value="2">Dos partes</option>
                    </select>
                    <p id="schedule-parts-help" class="text-xs text-titanium mt-1">Indica si cada encuentro se juega en una sola parte o en dos partes de igual duración.</p>
                    @error('schedule_parts') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="schedule-duration" class="block text-sm font-semibold text-titanium mb-1">Duración de cada parte (minutos)</label>
                    <input id="schedule-duration" wire:model="schedule_duration" type="number" min="1" max="1440" step="1" required
                           aria-describedby="schedule-duration-help"
                           class="w-full border border-silver rounded-xl px-3 py-2 text-sm"/>
                    <p id="schedule-duration-help" class="text-xs text-titanium mt-1">Minutos de juego por parte, sin descansos. Dos partes de 20 minutos suman 40 minutos de juego.</p>
                    @error('schedule_duration') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="schedule-break" class="block text-sm font-semibold text-titanium mb-1">Descanso entre partes y partidos (minutos)</label>
                    <input id="schedule-break" wire:model="schedule_break" type="number" min="0" max="1440" step="1" required
                           aria-describedby="schedule-break-help"
                           class="w-full border border-silver rounded-xl px-3 py-2 text-sm"/>
                    <p id="schedule-break-help" class="text-xs text-titanium mt-1">Minutos de pausa antes del siguiente partido. Con dos partes, esta misma pausa se añade también entre ambas partes. Usa 0 si no hay descanso.</p>
                    @error('schedule_break') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <p class="text-sm text-titanium">
                Con dos partes se aplica el mismo descanso entre las partes y antes del siguiente partido.
                Por ejemplo: dos partes de 20 minutos y descansos de 5 minutos separan los inicios 50 minutos (09:00, 09:50, 10:40).
            </p>
            <div class="flex gap-3">
                <button type="button" wire:click="$set('showScheduleModal', false)" class="flex-1 py-3 rounded-xl border border-silver text-sm font-semibold text-titanium">Cancelar</button>
                <button type="submit" wire:loading.attr="disabled" wire:target="assignMatchSchedule"
                        class="flex-1 py-3 rounded-xl bg-primary text-white text-sm font-semibold disabled:opacity-50">
                    <span wire:loading.remove wire:target="assignMatchSchedule">Asignar horarios</span>
                    <span wire:loading wire:target="assignMatchSchedule">Asignando...</span>
                </button>
            </div>
        </form>
    </div>
@endif
