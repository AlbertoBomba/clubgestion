<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif
    <div class="flex *:flex-col md:flex-row gap-6">
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 ">

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

                {{-- Temporada --}}
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Temporada <span class="text-red-500">*</span></label>
                    <select wire:model="season_id"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        <option value="">Seleccionar temporada...</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->season }}</option>
                        @endforeach
                    </select>
                    @error('season_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input wire:model="name" type="text"
                        class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Descripción</label>
                    <textarea wire:model="description" rows="3"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium resize-none"></textarea>
                    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Precio y Periodicidad --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Precio (€) <span class="text-red-500">*</span></label>
                        <input wire:model="price" type="text"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Periodicidad <span class="text-red-500">*</span></label>
                        <select wire:model="periodicity"
                                class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            <option value="">Seleccionar...</option>
                            @foreach($periodicities as $p)
                                <option value="{{ $p->value }}">{{ $p->label() }}</option>
                            @endforeach
                        </select>
                        @error('periodicity') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Activo --}}
                <div class="flex items-center gap-3">
                    <input wire:model="active" type="checkbox" id="active" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="active" class="text-sm font-semibold text-titanium">Activo</label>
                </div>
                <div class="flex items-center gap-3">
                    <input wire:model="bank_account" type="checkbox" id="bank_account" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="bank_account" class="text-sm font-semibold text-titanium">Cuenta Bancaria <span class="text-gray-400 text-xs">(Marque esta opción si este tipo de socio requiere cobro mediante cuenta bancaria con recibo domiciliado)</span></label>
                </div>
                <div class="flex items-center gap-3">
                    <input wire:model="credit_card" type="checkbox" id="credit_card" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="credit_card" class="text-sm font-semibold text-titanium">Tarjeta de Crédito para usar cobro recurrente. <span class="text-gray-400 text-xs">(El club debe tener tpv virtual contratado con su banco, o usar el que ofrece vaed.)</span></label>
                </div>

                <!-- Card template -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Imagen de la tarjeta <span class="text-gray-400 text-sm ml-2">(Opcional)</span>
                    </h3>
                    <div class="space-y-6">
                        <div class="form-group">
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0">
                                    @if ($card_template instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Vista previa:</p>
                                            <img src="{{ $card_template->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    @elseif ($existing_card_template)
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Imagen actual:</p>
                                            <img src="{{ asset('storage/' . $existing_card_template) }}" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    @else
                                        <div class="h-32 w-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-500">Sin imagen</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Subir imagen de la tarjeta</label>
                                    
                                    <input type="file" wire:model.live="card_template" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                    
                                    <div wire:loading wire:target="card_template" class="text-sm text-primary mt-1">
                                        <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Subiendo foto...
                                    </div>
                                    @error('card_template') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Inscripciones activas --}}
                @if($memberType->member_seasons_count ?? 0)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800">
                        <strong>{{ $memberType->member_seasons_count }}</strong> inscripciones activas con este tipo.
                        El precio histórico no se modifica.
                    </div>
                @endif

                {{-- Botones --}}
                <div class="flex items-center justify-between pt-4 border-t border-silver/30">
                    <a href="{{ route('member-types.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
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
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 ">

            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">

                <div class="flex items-center justify-between mb-4">
                    <button type="button" wire:click="downloadRemesaXml" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Descargar XML remesa SEPA
                    </button>
                </div>

                @if (session()->has('error'))
                    <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-400 rounded text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-sm text-blue-700">
                    <strong>Histórico de precios y periodicidades:</strong><br>
                    Aquí se muestran los precios y periodicidades históricas de este tipo de socio para cada socio que lo ha tenido en alguna temporada.    
                <table class="w-full mt-2 text-sm text-left text-blue-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b border-blue-200">número</th>
                            <th class="px-4 py-2 border-b border-blue-200">Socio</th>
                            <th class="px-4 py-2 border-b border-blue-200">Temporada</th>
                            <th class="px-4 py-2 border-b border-blue-200">Precio histórico (€)</th>
                            <th class="px-4 py-2 border-b border-blue-200">Fecha alta</th>
                            <th class="px-4 py-2 border-b border-blue-200">Estado pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($memberType->memberSeasons as $memberSeason)
                                <tr>
                                    <td class="px-4 py-2 border-b border-blue-200">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b border-blue-200">{{ $memberSeason->member->name }} {{ $memberSeason->member->surname }}</td>
                                    <td class="px-4 py-2 border-b border-blue-200">{{ $memberSeason->season->season }}</td>
                                    <td class="px-4 py-2 border-b border-blue-200">€{{ number_format($memberSeason->price, 2) }}</td>
                                    <td class="px-4 py-2 border-b border-blue-200">{{ $memberSeason->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border-b border-blue-200">{{ $memberSeason->payment_status }}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
