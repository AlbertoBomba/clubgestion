<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Crear Partido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('matches.create')
        </div>
    </div>
</x-app-layout>
