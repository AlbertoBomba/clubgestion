<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Nuevo Slide — Portada Web') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('web-home-slides.create')
        </div>
    </div>
</x-app-layout>
