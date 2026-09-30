<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                {{ __('Gestión de Patrocinadores') }}
            </h2>
        </div>
    </x-slot>

    <div class="">
        <div class="w-full">
            @livewire('sponsors.index')
        </div>
    </div>
</x-app-layout>
