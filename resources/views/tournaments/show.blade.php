<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ $tournament->name }}
        </h2>
    </x-slot>

    <div class="">
          <div class="w-full">
            @livewire('tournaments.show', ['tournament' => $tournament])
        </div>
    </div>
</x-app-layout>
