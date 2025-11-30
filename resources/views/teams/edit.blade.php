<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Editar Equipo') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('teams.edit', ['team' => $team])
        </div>
    </div>
</x-app-layout>
