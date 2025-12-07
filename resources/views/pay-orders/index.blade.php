<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cartas de Pago') }}
        </h2>
    </x-slot> --}}

    <div class="py-6 sm:py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:payment-orders.index />
        </div>
    </div>
</x-app-layout>
