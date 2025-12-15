<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                Gestión de Entrenamientos
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full">
            @livewire('trainings.index')
        </div>
    </div>
</x-app-layout>
