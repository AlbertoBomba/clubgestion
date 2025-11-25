<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('sports-schools.index') }}" class="text-purple-600 hover:text-purple-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-bold text-2xl text-transparent bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text leading-tight">
                    Editar Escuela Deportiva
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('sports-schools.edit', ['school' => $school])
        </div>
    </div>
</x-app-layout>
