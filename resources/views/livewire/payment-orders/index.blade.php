<div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <!-- Mensajes de feedback -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if (session()->has('warning'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-yellow-700 font-medium">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-2xl font-bold text-black-deep">Cartas de Pago</h2>
                @if($activeSeason)
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-semibold text-primary">{{ $players->total() }}</span> 
                        {{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}
                    </p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="openTransferModal" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-purple-600 hover:bg-purple-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Marcar Transferencias
                </button>
                <button wire:click="exportExcel" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-green-600 hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Descargar Excel
                </button>
                @if($activeSeason && $hasPlayersWithoutPayments)
                    <div class="relative group">
                        <button wire:click="prepareGeneratePaymentOrders" 
                            wire:loading.attr="disabled"
                            wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                            <svg wire:loading.remove wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <svg wire:loading wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders">Generar Cartas de Pago</span>
                            <span wire:loading wire:target="confirmGeneratePaymentOrders">Generando...</span>
                            <span wire:loading wire:target="prepareGeneratePaymentOrders">Calculando...</span>
                        </button>
                        
                        <!-- Badge de alerta parpadeante -->
                        <div class="absolute -top-2 -right-2 animate-pulse">
                            <div class="relative flex items-center justify-center">
                                <span class="flex h-6 w-6 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-6 w-6 bg-red-500 items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Tooltip con mensaje -->
                        <div class="absolute top-full right-0 mt-2 hidden group-hover:block z-50 w-64">
                            <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 shadow-lg">
                                <div class="absolute bottom-full right-4 -mb-1">
                                    <div class="border-8 border-transparent border-b-gray-900"></div>
                                </div>
                                <p class="font-semibold">⚠️ Hay cartas de pago sin generar</p>
                                <p class="mt-1 text-gray-300">Haz clic para generar las cartas de pago pendientes</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->season }} en curso
                    </span>
                @endif --}}
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="jugador, tutor, DNI o código de pago" 
                    class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
            </div>
            
            <div>
                <select wire:model.live="seasonFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las temporadas</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}">
                            {{ $season->season }}
                            @if($activeSeason && $season->id === $activeSeason->id)
                                🟢 (Temporada en curso)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <select wire:model.live="teamFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todos los equipos</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->team }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select wire:model.live="cuotaFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las cuotas</option>
                    @for($i = 1; $i <= $maxCuotas; $i++)
                        <option value="{{ $i }}">
                            @if($i == 1) Primera cuota
                            @elseif($i == 2) Segunda cuota
                            @elseif($i == 3) Tercera cuota
                            @elseif($i == 4) Cuarta cuota
                            @elseif($i == 5) Quinta cuota
                            @elseif($i == 6) Sexta cuota
                            @elseif($i == 7) Séptima cuota
                            @elseif($i == 8) Octava cuota
                            @elseif($i == 9) Novena cuota
                            @elseif($i == 10) Décima cuota
                            @elseif($i == 11) Undécima cuota
                            @elseif($i == 12) Duodécima cuota
                            @else Cuota {{ $i }}
                            @endif
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="pendingPaymentsOnly" 
                        class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                    <span class="ml-3 text-sm font-semibold text-black-deep">Solo pagos pendientes</span>
                </label>
            </div>
        </div>

        <!-- Botón de acciones en lote -->
        @if(count($selectedPlayers) > 0)
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">
                        {{ count($selectedPlayers) }} {{ count($selectedPlayers) === 1 ? 'jugador seleccionado' : 'jugadores seleccionados' }}
                    </span>
                </div>
                <button wire:click="openStateChangeModal" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Cambiar Estado
                </button>
            </div>
        @endif

        <!-- Tabla de jugadores -->
        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" wire:model.live="selectAll" 
                                class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Jugador</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Códigos de Pago</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cuotas de Pago</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($players as $player)
                        <tr class="hover:bg-primary/5">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model.live="selectedPlayers" value="{{ $player->id }}" 
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($player->profile_photo_path)
                                        <img src="{{ asset('storage/' . $player->profile_photo_path) }}" 
                                            class="w-10 h-10 rounded-full object-cover border border-silver mr-3">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center border border-silver mr-3">
                                            <span class="text-primary text-sm font-semibold">{{ substr($player->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-black-deep">{!! $this->highlightText(trim(($player->name ?? '') . ' ' . ($player->surname ?? ''))) !!}</div>
                                        @if($player->dbirth)
                                            <div class="text-xs text-gray-500">{{ $player->dbirth->age }} años</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $tutorName = trim(($player->nametutor ?? '') . ' ' . ($player->surnametutor ?? ''));
                                @endphp
                                <div class="text-sm text-gray-900">
                                    {!! !empty($tutorName) ? $this->highlightText($tutorName) : '-' !!}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $phone = $player->phone1 ?? $player->phone2 ?? '';
                                @endphp
                                <div class="text-sm text-gray-900">{!! !empty($phone) ? $this->highlightText($phone) : '-' !!}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $player->teams->first()->team ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($player->paymentPlayers->count() > 0)
                                    <div class="flex flex-col gap-1">
                                        @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                            <span class="text-xs font-mono text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-200">
                                                <span class="text-gray-400 mr-1">#{{ $payment->id }}</span> C{{ $payment->cuota }}: {!! $this->highlightText($payment->code) !!}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->paymentPlayers->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                            @php
                                                $now = now();
                                                $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                                                $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;
                                                
                                                // Determinar el estado
                                                if ($payment->state == 1) {
                                                    $status = 'paid'; // Pagada
                                                    $statusText = 'Pagada';
                                                    $bgColor = 'bg-green-100';
                                                    $textColor = 'text-green-800';
                                                    $borderColor = 'border-green-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                                                } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                                                    $status = 'unpaid'; // Impagada
                                                    $statusText = 'Impagada';
                                                    $bgColor = 'bg-red-100';
                                                    $textColor = 'text-red-800';
                                                    $borderColor = 'border-red-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                                                } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                                                    $status = 'in-term'; // En plazo
                                                    $statusText = 'En plazo';
                                                    $bgColor = 'bg-blue-100';
                                                    $textColor = 'text-blue-800';
                                                    $borderColor = 'border-blue-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>';
                                                } elseif ($dateStart && $now->isBefore($dateStart)) {
                                                    $status = 'not-executed'; // No ejecutada
                                                    $statusText = 'No ejecutada';
                                                    $bgColor = 'bg-gray-100';
                                                    $textColor = 'text-gray-800';
                                                    $borderColor = 'border-gray-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>';
                                                } else {
                                                    $status = 'pending'; // Pendiente (por defecto)
                                                    $statusText = 'Pendiente';
                                                    $bgColor = 'bg-amber-100';
                                                    $textColor = 'text-amber-800';
                                                    $borderColor = 'border-amber-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>';
                                                }
                                            @endphp
                                            <div class="inline-flex items-start">
                                                <span class="inline-flex flex-col px-3 py-2 rounded-lg text-xs font-semibold {{ $bgColor }} {{ $textColor }} border {{ $borderColor }}">
                                                    <span class="flex items-center mb-1">
                                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            {!! $icon !!}
                                                        </svg>
                                                        <span class="opacity-60 mr-1">#{{ $payment->id }}</span> {{ $payment->cuota }} - {{ $statusText }}
                                                    </span>
                                                    @if($dateStart && $dateEnd)
                                                        <span class="text-xs {{ str_replace('800', '700', $textColor) }} font-normal">
                                                            {{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-300">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Sin pagos generados
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($player->paymentPlayers->count() > 0)
                                        <a href="{{ route('pay-orders.show', $player->id) }}" 
                                            wire:navigate
                                            class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver Cartas
                                        </a>
                                        <button wire:click="confirmDeletePlayerPayments({{ $player->id }})" 
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    @else
                                        <button wire:click="generateSinglePlayerPayments({{ $player->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="generateSinglePlayerPayments({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-xs font-semibold disabled:opacity-50">
                                            <svg wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <svg wire:loading wire:target="generateSinglePlayerPayments({{ $player->id }})" class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})">Generar Pagos</span>
                                            <span wire:loading wire:target="generateSinglePlayerPayments({{ $player->id }})">Generando...</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No se encontraron jugadores</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($players->hasPages())
            <div class="mt-6 border-t border-silver/30 pt-4">
                {{ $players->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de confirmación de eliminación -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showDeleteModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirmar eliminación
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas eliminar todas las cartas de pago de <strong>{{ $playerToDelete?->name }} {{ $playerToDelete?->surname }}</strong>?
                                    </p>
                                    <p class="text-sm text-red-600 mt-2 font-semibold">
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deletePlayerPayments" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button wire:click="$set('showDeleteModal', false)" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de cambio de estado en lote -->
    @if($showStateChangeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeStateChangeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Cambiar estado de pagos
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Vas a cambiar el estado para <strong>{{ count($selectedPlayers) }} {{ count($selectedPlayers) === 1 ? 'jugador' : 'jugadores' }}</strong>.
                                    </p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona la cuota</label>
                                            <select wire:model="stateChangeCuota" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">-- Selecciona una cuota --</option>
                                                @for($i = 1; $i <= $maxCuotas; $i++)
                                                    <option value="{{ $i }}">
                                                        @if($i == 1) Primera cuota
                                                        @elseif($i == 2) Segunda cuota
                                                        @elseif($i == 3) Tercera cuota
                                                        @elseif($i == 4) Cuarta cuota
                                                        @elseif($i == 5) Quinta cuota
                                                        @elseif($i == 6) Sexta cuota
                                                        @elseif($i == 7) Séptima cuota
                                                        @elseif($i == 8) Octava cuota
                                                        @elseif($i == 9) Novena cuota
                                                        @elseif($i == 10) Décima cuota
                                                        @elseif($i == 11) Undécima cuota
                                                        @elseif($i == 12) Duodécima cuota
                                                        @else Cuota {{ $i }}
                                                        @endif
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo estado</label>
                                            <select wire:model="stateChangeNewState" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">-- Selecciona un estado --</option>
                                                @foreach(config('constants.states_payment_orders') as $label => $value)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded">
                                            <p class="text-xs text-amber-700">
                                                <strong>Nota:</strong> Esta acción actualizará el estado de la cuota seleccionada para todos los jugadores marcados.
                                            </p>
                                        </div>
                                        
                                        @if($pendingPaymentsOnly)
                                            <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                                                <p class="text-xs text-blue-700">
                                                    <strong>Filtro activo:</strong> Tienes activado "Solo pagos pendientes". Los jugadores sin pagos pendientes podrían no mostrarse después de actualizar.
                                                </p>
                                            </div>
                                        @endif
                                        
                                        @if($cuotaFilter)
                                            <div class="p-3 bg-purple-50 border-l-4 border-purple-500 rounded">
                                                <p class="text-xs text-purple-700">
                                                    <strong>Filtro activo:</strong> Estás filtrando por cuota específica. La lista se actualizará según tus filtros activos.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="bulkUpdateState" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Actualizar Estados
                        </button>
                        <button wire:click="closeStateChangeModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de transferencias -->
    @if($showTransferModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeTransferModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-[95vw] sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start w-full">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Marcar pagos por transferencia
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Busca pagos pendientes por código de pago, nombre del jugador, apellido del jugador o nombre del tutor.
                                    </p>
                                    
                                    @php
                                        // Detectar si hay resultados de búsqueda rápida o Excel
                                        $hasQuickSearchResults = collect($transferResults)->where('from_quick_search', true)->count() > 0;
                                        $hasExcelResults = collect($transferResults)->filter(function($result) {
                                            return !isset($result['from_quick_search']) || $result['from_quick_search'] !== true;
                                        })->count() > 0;
                                    @endphp
                                    
                                    {{-- Botón para cambiar de modo si hay resultados --}}
                                    @if($hasQuickSearchResults || $hasExcelResults)
                                        <div class="mb-4 flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <p class="text-sm text-blue-800">
                                                @if($hasQuickSearchResults)
                                                    📋 Mostrando resultados de <strong>Búsqueda Rápida</strong>
                                                @else
                                                    📁 Mostrando resultados de <strong>Importación Excel</strong>
                                                @endif
                                            </p>
                                            <button wire:click="clearTransferResults" 
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition-colors duration-200 font-semibold">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Limpiar y cambiar modo
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <!-- Búsqueda rápida (solo mostrar si NO hay resultados de Excel) -->
                                    @if(!$hasExcelResults)
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Búsqueda rápida</label>
                                            <div class="flex gap-2">
                                                <input wire:model="transferSearch" 
                                                    type="text" 
                                                    placeholder="Código, nombre del jugador o tutor..."
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                    wire:keydown.enter="searchTransfers">
                                                <button wire:click="searchTransfers" 
                                                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 text-sm font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                    </svg>
                                                    Buscar
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">
                                                ℹ️ En la búsqueda rápida solo puedes seleccionar un pago para marcar como pagado.
                                            </p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Resultados de búsqueda (visible para ambos modos) -->
                                    @if(count($transferResults) > 0)
                                            @php
                                                $withMatch = collect($transferResults)->where('no_match', false)->count();
                                                $withoutMatch = collect($transferResults)->where('no_match', true)->count();
                                                $duplicates = collect($transferResults)->where('duplicate_cell', true)->count();
                                            @endphp
                                            
                                            @if($withoutMatch > 0 || $duplicates > 0)
                                                <div class="mb-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                                                    <div class="flex items-start">
                                                        <svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <div>
                                                            <h4 class="text-sm font-semibold text-orange-800">Resumen de importación</h4>
                                                            <p class="mt-1 text-sm text-orange-700">
                                                                <span class="font-bold text-green-700">{{ $withMatch - $duplicates }}</span> {{ ($withMatch - $duplicates) === 1 ? 'pendiente' : 'pendientes' }}
                                                                @if($duplicates > 0)
                                                                     • <span class="font-bold text-orange-700">{{ $duplicates }}</span> {{ $duplicates === 1 ? 'duplicado' : 'duplicados' }}
                                                                @endif
                                                                @if($withoutMatch > 0)
                                                                     • <span class="font-bold text-red-700">{{ $withoutMatch }}</span> {{ $withoutMatch === 1 ? 'sin coincidencia' : 'sin coincidencias' }}
                                                                @endif
                                                            </p>
                                                            <p class="mt-1 text-xs text-orange-600">
                                                                @if($duplicates > 0)
                                                                    Los pagos duplicados (misma celda Excel) están en <span class="bg-orange-100 px-1 rounded">naranja</span> - selecciona manualmente solo uno de cada grupo.
                                                                @endif
                                                                @if($duplicates > 0 && $withoutMatch > 0)
                                                                    <br>
                                                                @endif
                                                                
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                <div class="max-h-96 overflow-y-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50 sticky top-0">
                                                            <tr>
                                                                @php
                                                                    $selectableCount = collect($transferResults)->filter(fn($r) => empty($r['no_match']) && isset($r['id']) && $r['id'] !== null && empty($r['from_quick_search']))->count();
                                                                    $allSelected = $selectableCount > 0 && count($selectedTransferPayments) === $selectableCount;
                                                                @endphp
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                                    @if($selectableCount > 0)
                                                                        <div class="flex flex-col items-center gap-0.5">
                                                                            <input type="checkbox"
                                                                                wire:click="toggleSelectAllTransferPayments"
                                                                                @checked($allSelected)
                                                                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                                                                title="Seleccionar/Deseleccionar todos">
                                                                            <span class="text-[10px] leading-none">todos</span>
                                                                        </div>
                                                                    @else
                                                                        Sel.
                                                                    @endif
                                                                </th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jugador</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Equipo</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuota</th>
                                                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Importe</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celda Excel</th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contenido Celda</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            @foreach($transferResults as $result)
                                                                @php
                                                                    $isDuplicate = isset($result['duplicate_cell']) && $result['duplicate_cell'];
                                                                    $isNoMatch = isset($result['no_match']) && $result['no_match'];
                                                                    $isFromQuickSearch = isset($result['from_quick_search']) && $result['from_quick_search'];
                                                                    
                                                                    $rowClass = $isNoMatch 
                                                                        ? 'bg-red-50 hover:bg-red-100' 
                                                                        : ($isDuplicate ? 'bg-orange-50 hover:bg-orange-100 border-l-4 border-orange-400' : 'hover:bg-gray-50');
                                                                @endphp
                                                                <tr class="{{ $rowClass }}">
                                                                    <td class="px-4 py-3">
                                                                        @if($isNoMatch)
                                                                            <span class="text-red-500 font-bold">✕</span>
                                                                        @elseif($isFromQuickSearch)
                                                                            {{-- Radio button para búsqueda rápida (solo uno seleccionable) --}}
                                                                            <input type="radio" 
                                                                                wire:model="selectedQuickSearchPayment" 
                                                                                value="{{ $result['id'] }}"
                                                                                class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                                                                        @else
                                                                            {{-- Checkbox para importación Excel (múltiples seleccionables) --}}
                                                                            <div class="flex items-center gap-1">
                                                                                <input type="checkbox" 
                                                                                    wire:model="selectedTransferPayments" 
                                                                                    value="{{ $result['id'] }}"
                                                                                    class="w-4 h-4 {{ $isDuplicate ? 'text-orange-600' : 'text-purple-600' }} border-gray-300 rounded focus:ring-{{ $isDuplicate ? 'orange' : 'purple' }}-500">
                                                                                @if($isDuplicate)
                                                                                    <span class="text-orange-500 text-sm" title="Celda duplicada - selecciona solo uno">⚠</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm font-mono {{ $isNoMatch ? 'text-gray-500' : 'text-gray-900' }}">
                                                                        {!! $this->highlightTransferText($result['code'], $result['search_term']) !!}
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm">
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="{{ $isNoMatch ? 'font-semibold text-red-600' : ($isDuplicate ? 'text-orange-900' : 'text-gray-900') }}">
                                                                                {!! $this->highlightTransferText($result['player_name'], $result['search_term']) !!}
                                                                            </span>
                                                                            @if($isDuplicate)
                                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300">
                                                                                    ⚠ DUPLICADO ({{ $result['duplicate_count'] }} coincidencias en {{ $result['excel_cell'] }})
                                                                                </span>
                                                                            @elseif(isset($result['matched_by']) && $result['matched_by'] === 'name')
                                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300">
                                                                                    Por nombre
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm {{ $isNoMatch ? 'text-gray-500' : 'text-gray-600' }}">
                                                                        {!! $this->highlightTransferText($result['tutor_name'], $result['search_term']) !!}
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm {{ $isNoMatch ? 'text-gray-500' : 'text-gray-700' }}">
                                                                        {{ $result['team'] ?? '-' }}
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm {{ $isNoMatch ? 'text-gray-500' : 'text-gray-900' }}">
                                                                        {{ $result['cuota'] !== '-' ? 'Cuota ' . $result['cuota'] : '-' }}
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm text-right font-semibold {{ $isNoMatch ? 'text-gray-500' : 'text-gray-900' }}">
                                                                        {{ $result['amount'] !== '-' ? number_format($result['amount'], 2, ',', '.') . ' €' : '-' }}
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        @if(isset($result['excel_cell']))
                                                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-mono font-semibold bg-indigo-100 text-indigo-800 border border-indigo-300">
                                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                                                                </svg>
                                                                                {{ $result['excel_cell'] }}
                                                                            </span>
                                                                        @else
                                                                            <span class="text-xs text-gray-400">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm text-gray-700">
                                                                        @if(isset($result['excel_cell_content']))
                                                                            <div class="break-words min-w-[200px] max-w-md">
                                                                                {!! $this->highlightTransferText($result['excel_cell_content'], $result['search_term']) !!}
                                                                            </div>
                                                                        @else
                                                                            <span class="text-xs text-gray-400">-</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if(count($selectedTransferPayments) > 0)
                                                    <div class="bg-purple-50 px-4 py-3 border-t border-purple-200">
                                                        <p class="text-sm text-purple-700 font-semibold">
                                                            {{ count($selectedTransferPayments) }} {{ count($selectedTransferPayments) === 1 ? 'pago seleccionado' : 'pagos seleccionados' }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif(!empty($transferSearch) && count($transferResults) === 0)
                                            <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-500">No se encontraron pagos pendientes con ese criterio</p>
                                            </div>
                                        @endif

                                        <!-- Importación Excel (solo mostrar si NO hay resultados de búsqueda rápida) -->
                                        @if(!$hasQuickSearchResults)
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                                <div class="flex items-start">
                                                    <svg class="w-8 h-8 text-purple-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <p class="text-sm font-semibold text-purple-900">Importación masiva desde Excel</p>
                                                            <button wire:click="downloadTransferTemplate"
                                                                class="inline-flex items-center px-3 py-1.5 bg-white border border-purple-400 text-purple-700 rounded-lg hover:bg-purple-50 transition-colors duration-200 text-xs font-semibold">
                                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                                </svg>
                                                                Descargar plantilla
                                                            </button>
                                                        </div>
                                                        <p class="text-xs text-purple-700 mb-3">
                                                            Sube un archivo Excel con códigos de pago (7-10 dígitos) o nombres de jugadores. El sistema busca primero por código y, si no lo encuentra, por nombre y apellido del jugador.
                                                        </p>
                                                        <div class="bg-blue-100 border border-blue-300 rounded px-3 py-2 mb-3">
                                                            <p class="text-xs text-blue-800">
                                                                <strong>ℹ️ Importante:</strong> Se busca por código de pago (prioridad) y también por nombre + apellido del jugador. Descarga la plantilla para ver el formato recomendado.
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="block text-xs font-semibold text-purple-800 mb-1">Filtrar por cuota (opcional)</label>
                                                            <select wire:model="transferCuotaFilter"
                                                                class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm text-gray-700">
                                                                <option value="">Todas las cuotas</option>
                                                                @for($i = 1; $i <= $maxCuotas; $i++)
                                                                    <option value="{{ $i }}">
                                                                        @if($i == 1) Primera cuota
                                                                        @elseif($i == 2) Segunda cuota
                                                                        @elseif($i == 3) Tercera cuota
                                                                        @elseif($i == 4) Cuarta cuota
                                                                        @elseif($i == 5) Quinta cuota
                                                                        @elseif($i == 6) Sexta cuota
                                                                        @elseif($i == 7) Séptima cuota
                                                                        @elseif($i == 8) Octava cuota
                                                                        @elseif($i == 9) Novena cuota
                                                                        @elseif($i == 10) Décima cuota
                                                                        @elseif($i == 11) Undécima cuota
                                                                        @elseif($i == 12) Duodécima cuota
                                                                        @else Cuota {{ $i }}
                                                                        @endif
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <input type="file" 
                                                                wire:model="excelFile" 
                                                                accept=".xlsx,.xls,.csv"
                                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 file:cursor-pointer">
                                                            <button wire:click="importExcelTransfers" 
                                                                wire:loading.attr="disabled"
                                                                wire:target="excelFile,importExcelTransfers"
                                                                :disabled="!$wire.excelFile"
                                                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 text-sm font-semibold disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                                                                <svg wire:loading.remove wire:target="importExcelTransfers" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                                </svg>
                                                                <svg wire:loading wire:target="importExcelTransfers" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                                <span wire:loading.remove wire:target="importExcelTransfers">Procesar</span>
                                                                <span wire:loading wire:target="importExcelTransfers">Procesando...</span>
                                                            </button>
                                                        </div>
                                                        <div wire:loading wire:target="excelFile" class="mt-2 text-xs text-purple-600">
                                                            Subiendo archivo...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="markTransfersAsPaid" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Marcar como Pagado
                        </button>
                        <button wire:click="closeTransferModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de confirmación de transferencias -->
    @if($showTransferConfirmModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirmar Pagos por Transferencia
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Estás a punto de marcar <span class="font-bold text-purple-600">{{ count($paymentsToMarkPreview) }} {{ count($paymentsToMarkPreview) === 1 ? 'pago' : 'pagos' }}</span> como pagado(s) por transferencia. 
                                        Revisa la lista antes de confirmar:
                                    </p>
                                    
                                    <div class="mt-4 border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="overflow-x-auto max-h-96 overflow-y-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50 sticky top-0">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jugador</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutor</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota</th>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Descuento</th>
                                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($paymentsToMarkPreview as $payment)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $payment['code'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payment['player_name'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $payment['tutor_name'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $payment['team'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900">Cuota {{ $payment['cuota'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-center">
                                                                @if($payment['descEnt'] > 0 || $payment['descPerc'] > 0)
                                                                    <div class="flex flex-col items-center">
                                                                        @if($payment['descEnt'] > 0)
                                                                            <span class="text-orange-600 font-medium">{{ number_format($payment['descEnt'], 2, ',', '.') }} €</span>
                                                                        @endif
                                                                        @if($payment['descPerc'] > 0)
                                                                            <span class="text-orange-600 font-medium">{{ number_format($payment['descPerc'], 2, ',', '.') }}%</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <span class="text-gray-400">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-right font-semibold text-gray-900">{{ number_format($payment['amount'], 2, ',', '.') }} €</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                                                    <tr>
                                                        <td colspan="6" class="px-4 py-3 text-sm font-bold text-gray-900 text-right">TOTAL:</td>
                                                        <td class="px-4 py-3 text-sm font-bold text-right text-purple-600">
                                                            {{ number_format(collect($paymentsToMarkPreview)->sum('amount'), 2, ',', '.') }} €
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    <strong>Atención:</strong> Esta acción marcará estos pagos como pagados por transferencia y no se puede deshacer fácilmente.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmMarkTransfersAsPaid" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Confirmar y Marcar como Pagado
                        </button>
                        <button wire:click="closeTransferConfirmModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de confirmación de generación de cartas de pago -->
    @if($showGenerateConfirmModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeGenerateConfirmModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirmar generación de cartas de pago
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Se van a generar las siguientes cartas de pago:
                                    </p>
                                    
                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-xs text-gray-600 font-medium">Total de cartas</p>
                                                        <p class="text-2xl font-bold text-green-700">{{ $previewGenerateCount }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="border-t border-green-200 pt-3 space-y-2">
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="flex items-center text-gray-700">
                                                        <svg class="h-5 w-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        <span class="font-medium">Jugadores:</span>
                                                    </span>
                                                    <span class="font-semibold text-green-700">{{ $previewPlayersCount }}</span>
                                                </div>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="flex items-center text-gray-700">
                                                        <svg class="h-5 w-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                        </svg>
                                                        <span class="font-medium">Equipos:</span>
                                                    </span>
                                                    <span class="font-semibold text-green-700">{{ $previewTeamsCount }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                                        <p class="text-xs text-blue-700">
                                            <strong>Nota:</strong> Esta acción creará las cartas de pago para todos los jugadores que no tengan generadas sus cuotas en la temporada activa.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmGeneratePaymentOrders" 
                            type="button" 
                            wire:loading.attr="disabled"
                            wire:target="confirmGeneratePaymentOrders"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                            <svg wire:loading.remove wire:target="confirmGeneratePaymentOrders" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg wire:loading wire:target="confirmGeneratePaymentOrders" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="confirmGeneratePaymentOrders">Confirmar y Generar</span>
                            <span wire:loading wire:target="confirmGeneratePaymentOrders">Generando...</span>
                        </button>
                        <button wire:click="closeGenerateConfirmModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
                document.documentElement.style.overflow = '';
                document.documentElement.classList.remove('overflow-hidden');
                setTimeout(() => {
                    document.body.removeAttribute('style');
                    document.body.classList.remove('overflow-hidden', 'overflow-y-hidden');
                    window.scrollTo(window.scrollX, window.scrollY);
                }, 150);
            });
        });
    </script>
</div>
