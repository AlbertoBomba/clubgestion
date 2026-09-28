<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Torneos') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-full">
            @livewire('tournaments.index')
        </div>
    </div>
</x-app-layout>
