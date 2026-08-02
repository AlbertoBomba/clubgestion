<div x-data="{ tab: @entangle('activeTab') }">

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Header del socio --}}
    <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 mb-6 p-6">
        <div class="flex items-center gap-5">
            @if($currentPhoto)
                <img src="{{ asset('storage/' . $currentPhoto) }}" alt="" class="w-16 h-16 rounded-full object-cover shadow">
            @else
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xl font-bold shadow">
                    {{ strtoupper(substr($member->name, 0, 1) . substr($member->surname, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold text-titanium">{{ $member->surname }}, {{ $member->name }}</h2>
                <p class="text-sm text-gray-400">Nº {{ $member->member_number ?? '-' }}</p>
                @if(!$member->active)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-600 mt-1">Inactivo</span>
                @endif
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-2 mt-6 border-b border-silver/30">
            <button @click="tab = 'data'" wire:click="$set('activeTab', 'data')"
                    :class="tab === 'data' ? 'border-b-2 border-primary text-primary font-semibold' : 'text-titanium'"
                    class="px-4 py-2 text-sm transition-colors">
                Datos personales
            </button>
            <button @click="tab = 'seasons'" wire:click="$set('activeTab', 'seasons')"
                    :class="tab === 'seasons' ? 'border-b-2 border-primary text-primary font-semibold' : 'text-titanium'"
                    class="px-4 py-2 text-sm transition-colors">
                Inscripciones ({{ count($memberSeasons) }})
            </button>
        </div>
    </div>

    {{-- Tab: Datos personales --}}
    <div x-show="tab === 'data'">
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 max-w-2xl">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                    <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit="save" class="space-y-5">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text"
                               class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Apellidos <span class="text-red-500">*</span></label>
                        <input wire:model="surname" type="text"
                               class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('surname') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">DNI / NIF</label>
                    <input wire:model="dni" type="text"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('dni') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Email</label>
                        <input wire:model="email" type="email"
                               class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Teléfono</label>
                        <input wire:model="phone" type="text"
                               class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Fecha de nacimiento</label>
                    <input wire:model="birth_date" type="date"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('birth_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Dirección</label>
                    <input wire:model="address" type="text"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Foto</label>
                    @if($currentPhoto)
                        <img src="{{ asset('storage/' . $currentPhoto) }}" alt="" class="w-16 h-16 rounded-xl object-cover mb-2">
                    @endif
                    <input wire:model="photo" type="file" accept="image/*"
                           class="block w-full text-sm text-titanium file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    @error('photo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input wire:model="active" type="checkbox" id="active" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="active" class="text-sm font-semibold text-titanium">Socio activo</label>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-silver/30">
                    <a href="{{ route('members.index') }}"
                       class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Volver
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors shadow-sm"
                            wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                        <span wire:loading.remove>Guardar Cambios</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tab: Inscripciones --}}
    <div x-show="tab === 'seasons'">
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-titanium">Historial de inscripciones</h3>
                <button wire:click="openSeasonModal()"
                        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva inscripción
                </button>
            </div>

            @forelse($memberSeasons as $ms)
                <div class="border border-silver/40 rounded-xl mb-4 overflow-hidden">
                    {{-- Cabecera temporada --}}
                    <div class="flex items-center justify-between px-5 py-3 bg-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-titanium">{{ $ms->season->season ?? '-' }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-primary/10 text-primary font-semibold">{{ $ms->memberType->name ?? '-' }}</span>
                            <span class="text-sm font-semibold text-gray-700">{{ number_format($ms->price, 2, ',', '.') }} €</span>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- Estado pago --}}
                            @php
                                $psColor = match($ms->payment_status->value ?? $ms->payment_status) {
                                    'paid'     => 'bg-green-100 text-green-700',
                                    'pending'  => 'bg-yellow-100 text-yellow-700',
                                    'overdue'  => 'bg-red-100 text-red-700',
                                    default    => 'bg-gray-100 text-gray-500',
                                };
                                $psLabel = $ms->payment_status instanceof \App\Enums\MemberPaymentStatus
                                    ? $ms->payment_status->label()
                                    : ucfirst($ms->payment_status);
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $psColor }}">{{ $psLabel }}</span>
                            {{-- Estado inscripción --}}
                            @php
                                $stColor = match($ms->status->value ?? $ms->status) {
                                    'active'    => 'bg-green-100 text-green-700',
                                    'left'      => 'bg-red-100 text-red-700',
                                    'suspended' => 'bg-orange-100 text-orange-700',
                                    default     => 'bg-gray-100 text-gray-500',
                                };
                                $stLabel = $ms->status instanceof \App\Enums\MemberSeasonStatus
                                    ? $ms->status->label()
                                    : ucfirst($ms->status);
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $stColor }}">{{ $stLabel }}</span>

                            <button wire:click="openSeasonModal({{ $ms->id }})"
                                    class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Editar inscripción">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button wire:click="confirmDeleteSeason({{ $ms->id }})"
                                    class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar inscripción">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Pagos --}}
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pagos</span>
                            <button wire:click="openPaymentModal({{ $ms->id }})"
                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Añadir pago
                            </button>
                        </div>

                        @if($ms->payments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-xs text-gray-400 uppercase">
                                            <th class="pb-2 text-left font-semibold">Concepto</th>
                                            <th class="pb-2 text-left font-semibold">Importe</th>
                                            <th class="pb-2 text-left font-semibold">Vencimiento</th>
                                            <th class="pb-2 text-left font-semibold">Pagado el</th>
                                            <th class="pb-2 text-center font-semibold">Estado</th>
                                            <th class="pb-2 text-right font-semibold"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($ms->payments as $pay)
                                            <tr>
                                                <td class="py-2 text-titanium">{{ $pay->concept }}</td>
                                                <td class="py-2 font-semibold text-titanium">{{ number_format($pay->amount, 2, ',', '.') }} €</td>
                                                <td class="py-2 text-gray-500">{{ $pay->due_date->format('d/m/Y') }}</td>
                                                <td class="py-2 text-gray-500">{{ $pay->payment_date?->format('d/m/Y') ?? '-' }}</td>
                                                <td class="py-2 text-center">
                                                    @php
                                                        $payStatus = $pay->status instanceof \App\Enums\MemberPaymentStatus
                                                            ? $pay->status->value : $pay->status;
                                                        $payColor = match($payStatus) {
                                                            'paid'    => 'bg-green-100 text-green-700',
                                                            'overdue' => 'bg-red-100 text-red-700',
                                                            default   => 'bg-yellow-100 text-yellow-700',
                                                        };
                                                        $payLabel = $pay->status instanceof \App\Enums\MemberPaymentStatus
                                                            ? $pay->status->label() : ucfirst($pay->status);
                                                    @endphp
                                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $payColor }}">{{ $payLabel }}</span>
                                                </td>
                                                <td class="py-2 text-right">
                                                    <div class="flex items-center justify-end gap-1">
                                                        @if($payStatus !== 'paid')
                                                            <button wire:click="markPaymentPaid({{ $pay->id }})"
                                                                    class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Marcar como pagado">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                        <button wire:click="confirmDeletePayment({{ $pay->id }})"
                                                                class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar pago">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Sin pagos registrados.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm">Sin inscripciones. Añade una nueva temporada.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal: Inscripción (nueva / editar) --}}
    @if($showSeasonModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg">
                <h3 class="text-lg font-bold text-titanium mb-5">
                    {{ $editingSeasonId ? 'Editar inscripción' : 'Nueva inscripción' }}
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Temporada <span class="text-red-500">*</span></label>
                            <select wire:model="ms_season_id"
                                    class="block w-full border border-silver rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                                <option value="">Seleccionar...</option>
                                @foreach($availableSeasons as $s)
                                    <option value="{{ $s->id }}">{{ $s->season }}</option>
                                @endforeach
                            </select>
                            @error('ms_season_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Tipo de socio <span class="text-red-500">*</span></label>
                            <select wire:model="ms_member_type_id"
                                    class="block w-full border border-silver rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                                <option value="">Seleccionar...</option>
                                @foreach($memberTypes as $mt)
                                    <option value="{{ $mt->id }}">{{ $mt->name }} ({{ number_format($mt->price, 2, ',', '.') }}€)</option>
                                @endforeach
                            </select>
                            @error('ms_member_type_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Fecha alta <span class="text-red-500">*</span></label>
                            <input wire:model="ms_join_date" type="date"
                                   class="block w-full border border-silver rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            @error('ms_join_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Precio (€) <span class="text-red-500">*</span></label>
                            <input wire:model="ms_price" type="text" placeholder="0,00"
                                   class="block w-full border border-silver rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            @error('ms_price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Observaciones</label>
                        <textarea wire:model="ms_observations" rows="2"
                                  class="block w-full border border-silver rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('showSeasonModal', false)"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveSeason"
                            class="px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Nuevo pago --}}
    @if($showPaymentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
                <h3 class="text-lg font-bold text-titanium mb-5">Nuevo pago</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Concepto <span class="text-red-500">*</span></label>
                        <input wire:model="pay_concept" type="text" placeholder="Ej: Cuota anual 2026"
                               class="block w-full border border-silver rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('pay_concept') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Importe (€) <span class="text-red-500">*</span></label>
                            <input wire:model="pay_amount" type="text" placeholder="0,00"
                                   class="block w-full border border-silver rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            @error('pay_amount') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-1">Vencimiento <span class="text-red-500">*</span></label>
                            <input wire:model="pay_due_date" type="date"
                                   class="block w-full border border-silver rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            @error('pay_due_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('showPaymentModal', false)"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="savePayment"
                            class="px-4 py-2 bg-green-600 text-white rounded-xl font-semibold text-sm hover:bg-green-700 transition-colors">
                        Registrar pago
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Confirmar eliminar inscripción --}}
    @if($confirmingSeasonDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Eliminar inscripción</h3>
                <p class="text-sm text-gray-500 mb-6">Se eliminarán también todos los pagos asociados.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('confirmingSeasonDeletion', false)"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm">Cancelar</button>
                    <button wire:click="deleteSeason"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl font-semibold text-sm hover:bg-red-700">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Confirmar eliminar pago --}}
    @if($confirmingPaymentDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Eliminar pago</h3>
                <p class="text-sm text-gray-500 mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('confirmingPaymentDeletion', false)"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm">Cancelar</button>
                    <button wire:click="deletePayment"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl font-semibold text-sm hover:bg-red-700">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

</div>
