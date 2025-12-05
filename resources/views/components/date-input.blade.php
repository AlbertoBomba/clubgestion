@props(['label', 'model', 'error' => null, 'required' => false, 'value' => ''])

<div class="form-group {{ $attributes->get('class') }}">
    @if($label)
        <label class="block text-sm font-semibold text-titanium mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div wire:ignore class="relative">
        <input 
            type="text" 
            readonly
            x-data="{ value: @entangle($model).live }"
            x-init="
                let picker = flatpickr($el, {
                    dateFormat: 'd/m/Y',
                    altFormat: 'd/m/Y',
                    locale: 'es',
                    allowInput: false,
                    clickOpens: true,
                    parseDate: (datestr, format) => {
                        // Si viene en formato Y-m-d (desde base de datos)
                        if (datestr && datestr.match(/^\d{4}-\d{2}-\d{2}$/)) {
                            const parts = datestr.split('-');
                            return new Date(parts[0], parts[1] - 1, parts[2]);
                        }
                        return flatpickr.parseDate(datestr, format);
                    },
                    onChange: function(selectedDates, dateStr) {
                        if (selectedDates.length > 0) {
                            let year = selectedDates[0].getFullYear();
                            let month = String(selectedDates[0].getMonth() + 1).padStart(2, '0');
                            let day = String(selectedDates[0].getDate()).padStart(2, '0');
                            value = year + '-' + month + '-' + day;
                        } else {
                            value = '';
                        }
                    }
                });
                
                // Establecer fecha inicial si existe
                if (value) {
                    picker.setDate(value, false);
                }
                
                // Observar cambios desde Livewire
                $watch('value', val => {
                    if (val && val !== picker.input.value) {
                        picker.setDate(val, false);
                    }
                });
            "
            placeholder="dd/mm/aaaa"
            class="w-full px-3 py-2 pr-10 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm cursor-pointer"
            {{ $attributes->except(['class', 'wire:model', 'wire:model.live']) }}
        >
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>
    
    @if($error)
        @error($error)
            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
        @enderror
    @endif
</div>
