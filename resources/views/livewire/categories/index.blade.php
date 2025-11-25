<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <div class="card-modern bg-white rounded-2xl shadow-xl border border-purple-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-blue-50">
            <input wire:model.live="search" type="text" placeholder="Buscar categorías..." 
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Categoría</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Descripción</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Edad</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Modalidad</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-purple-50">
                            <td class="px-6 py-4"><div class="text-sm font-semibold">{{ $category->category }}</div></td>
                            <td class="px-6 py-4"><div class="text-sm text-gray-600">{{ $category->description ?? '-' }}</div></td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    @if($category->from_age || $category->to_age)
                                        {{ $category->from_age ?? '?' }} - {{ $category->to_age ?? '?' }} años
                                    @else - @endif
                                </div>
                            </td>
                            <td class="px-6 py-4"><div class="text-sm">{{ $category->modality ?? '-' }}</div></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn-primary px-3 py-2 rounded-lg text-white text-sm inline-flex items-center">
                                    Editar
                                </a>
                                <button wire:click="confirmDelete({{ $category->id }})" class="bg-red-600 px-3 py-2 rounded-lg text-white text-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No se encontraron categorías</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t">{{ $categories->links() }}</div>
        @endif
    </div>

    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Categoría</x-slot>
        <x-slot name="content">¿Estás seguro de que deseas eliminar esta categoría?</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteCategory">Eliminar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
