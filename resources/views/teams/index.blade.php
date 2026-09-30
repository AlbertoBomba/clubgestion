<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                {{ __('Equipos') }}
            </h2>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-full">
            @livewire('teams.index')
        </div>
    </div>
</x-app-layout>
