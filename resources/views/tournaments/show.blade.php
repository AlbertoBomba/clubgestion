<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ $tournament->name }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('tournaments.show', ['tournament' => $tournament])
        </div>
    </div>
</x-app-layout>
