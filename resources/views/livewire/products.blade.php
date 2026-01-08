<div class="p-4 text-gray-800">

    <h2 class="text-xl font-semibold mb-4 text-gray-900">
        Mis Productos Personales
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-3 mb-6">

        <input
            wire:model="name"
            type="text"
            placeholder="Nombre"
            class="border p-2 text-gray-900 placeholder-gray-400"
        >

        <select
            wire:model="category_id"
            class="border p-2 text-gray-900"
        >
            <option value="" class="text-gray-400">
                Selecciona una categoría
            </option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" class="text-gray-900">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <input wire:model="calories" type="number" step="0.01"
            placeholder="Calorías"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="total_fat" type="number" step="0.01"
            placeholder="Grasa total"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="saturated_fat" type="number" step="0.01"
            placeholder="Grasa saturada"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="cholesterol" type="number" step="0.01"
            placeholder="Colesterol"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="polyunsaturated_fat" type="number" step="0.01"
            placeholder="Grasa poliinsaturada"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="monounsaturated_fat" type="number" step="0.01"
            placeholder="Grasa monoinsaturada"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="carbohydrates" type="number" step="0.01"
            placeholder="Carbohidratos"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="fiber" type="number" step="0.01"
            placeholder="Fibra"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <input wire:model="protein" type="number" step="0.01"
            placeholder="Proteína"
            class="border p-2 text-gray-900 placeholder-gray-400">

        <button
            class="col-span-2 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded"
        >
            @if($editingId)
                Actualizar Producto
            @else
                Crear Producto
            @endif
        </button>

    </form>

    <table class="w-full border text-gray-800">
        <thead class="bg-gray-100 text-gray-900">
            <tr>
                <th class="border p-2">Nombre</th>
                <th class="border p-2">Calorías</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 font-medium text-gray-900 flex items-center gap-2">
                        @if($product->is_favorite)
                            <span class="text-yellow-500 text-lg">★</span>
                        @endif
                        {{ $product->name }}
                    </td>

                    <td class="border p-2 text-gray-700">
                        {{ $product->calories }}
                    </td>

                    <td class="border p-2 space-x-2">
                        <button
                            wire:click="toggleFavorite({{ $product->id }})"
                            class="@if($product->is_favorite) text-yellow-500 @else text-gray-400 @endif hover:text-yellow-500 mr-3 text-lg"
                            title="@if($product->is_favorite) Quitar de favoritos @else Añadir a favoritos @endif"
                        >
                            ★
                        </button>

                        <button
                            wire:click="edit({{ $product->id }})"
                            class="text-blue-600 hover:text-blue-800 mr-3"
                        >
                            Editar
                        </button>

                        <button
                            wire:click="delete({{ $product->id }})"
                            class="text-red-600 hover:text-red-800"
                        >
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div class="mt-4 text-gray-700">
        {{ $products->links() }}
    </div>

</div>
