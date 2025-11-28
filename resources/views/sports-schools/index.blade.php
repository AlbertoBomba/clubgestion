<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                Escuelas Deportivas
            </h2>
            <a href="{{ route('sports-schools.create') }}" class="btn-primary inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Escuela
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('sports-schools.index')
        </div>
    </div>
</x-app-layout>
