<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
            {{ __('Editar Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @livewire('categories.edit', ['category' => $category])
        </div>
    </div>
</x-app-layout>
