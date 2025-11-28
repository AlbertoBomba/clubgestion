<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                {{ __('Categorías') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Categoría
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('categories.index')
        </div>
    </div>
</x-app-layout>
