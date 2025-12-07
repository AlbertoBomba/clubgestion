<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                {{ __('Equipos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('teams.index')
        </div>
    </div>
</x-app-layout>
