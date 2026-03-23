<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Torneos') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('tournaments.index')
        </div>
    </div>
</x-app-layout>
