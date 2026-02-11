<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-titanium leading-tight">
            {{ __('Editar Partido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @livewire('matches.edit', ['match' => $match])
        </div>
    </div>
</x-app-layout>
