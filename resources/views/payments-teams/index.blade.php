<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cuotas de pagos') }}
        </h2>
    </x-slot>

    <livewire:payments-teams.index />
</x-app-layout>
