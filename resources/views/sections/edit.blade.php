<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Editar Sección') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 lg:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:sections.edit :section="$section" />
        </div>
    </div>
</x-app-layout>
