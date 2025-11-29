<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('seasons.index') }}" class="mr-4 text-titanium hover:text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-bold text-2xl text-titanium leading-tight">
                    {{ __('Editar Temporada') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('seasons.edit', ['season' => $season])
        </div>
    </div>
</x-app-layout>
