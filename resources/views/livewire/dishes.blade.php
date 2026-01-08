<div class="p-4 space-y-6 text-gray-800">

    <h2 class="text-xl font-bold text-gray-900">Mis Platos</h2>

    <div class="bg-white p-4 border rounded">

        <form wire:submit.prevent="save">

            <input
                wire:model="name"
                class="border p-2 w-full mb-4 text-gray-900 placeholder-gray-400"
                placeholder="Nombre del plato"
            >

            <h3 class="font-semibold mb-4 text-gray-800">Ingredientes</h3>

            <div class="space-y-2">
                @foreach($availableProducts->groupBy('category.name') as $categoryName => $products)
                    <details class="border border-gray-300 rounded-lg overflow-hidden hover:border-blue-400 transition">
                        <summary class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 cursor-pointer font-semibold text-gray-800 hover:bg-blue-100 flex items-center justify-between select-none">
                            <span>{{ $categoryName ?? 'Sin categoría' }}</span>
                            <span class="text-sm text-gray-500">({{ $products->count() }} productos)</span>
                        </summary>
                        
                        <div class="p-4 bg-white border-t border-gray-200 grid grid-cols-2 gap-4">
                            @foreach($products as $product)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-blue-50 transition">
                                    <label class="text-sm font-medium text-gray-700 flex-1">
                                        {{ $product->name }}
                                    </label>

                                    <div class="flex items-center gap-2">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            wire:model="products.{{ $product->id }}"
                                            class="border border-gray-300 p-2 w-24 text-gray-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0 g"
                                        >
                                        <span class="text-xs text-gray-500">g</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </details>
                @endforeach
            </div>

            <div class="mt-4 flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    @if($editingDishId)
                        Actualizar
                    @else
                        Crear
                    @endif
                </button>

                @if($editingDishId)
                    <button
                        type="button"
                        wire:click="resetForm"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                    >
                        Cancelar
                    </button>
                @endif
            </div>

        </form>

        <br>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="bg-white p-4 border rounded">
        <h3 class="font-semibold mb-2 text-gray-900">Platos creados</h3>

        @foreach($dishes as $dish)
            <div class="border p-3 mb-3 rounded hover:bg-gray-50">

                <div class="flex justify-between items-center">
                    <strong class="text-gray-900 text-base">
                        {{ $dish->name }}
                    </strong>

                    <div>
                        <button
                            wire:click="edit({{ $dish->id }})"
                            class="text-blue-600 hover:text-blue-800 mr-2"
                        >
                            Editar
                        </button>

                        <button
                            wire:click="delete({{ $dish->id }})"
                            class="text-red-600 hover:text-red-800"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>

                <ul class="text-sm mt-2 list-disc ml-4 text-gray-700">
                    @foreach($dish->products as $product)
                        <li>
                            <span class="font-medium text-gray-800">
                                {{ $product->name }}
                            </span>
                            - {{ $product->pivot->quantity }} g
                        </li>
                    @endforeach
                </ul>

            </div>
        @endforeach
    </div>

</div>
