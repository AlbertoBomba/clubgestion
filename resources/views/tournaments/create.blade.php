<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Nuevo Torneo') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-full ">
            @livewire('tournaments.create')
        </div>
    </div>
</x-app-layout>
