<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Editar Torneo') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-full">
            @livewire('tournaments.edit', ['tournament' => $tournament])
        </div>
    </div>
</x-app-layout>
