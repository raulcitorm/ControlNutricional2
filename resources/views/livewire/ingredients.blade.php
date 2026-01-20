<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ingredientes Disponibles</h3>
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Buscar ingrediente..." 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100"
        >
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">Nombre</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">Categoría</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">Calorías</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">Proteína (g)</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">Grasa (g)</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">Carbos (g)</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">Fibra (g)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ingredients as $ingredient)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $ingredient->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $ingredient->category->name ?? 'N/A' }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">{{ $ingredient->calories }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">{{ $ingredient->protein }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">{{ $ingredient->total_fat }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">{{ $ingredient->carbohydrates }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-900 dark:text-gray-100">{{ $ingredient->fiber }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                            No hay ingredientes disponibles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ingredients->links() }}
    </div>
</div>
