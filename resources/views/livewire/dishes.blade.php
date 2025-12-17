<div class="p-4 space-y-6">

    <h2 class="text-xl font-bold">Mis Platos</h2>

    <div class="bg-white p-4 border rounded">
        <form wire:submit.prevent="save">

            <input wire:model="name"
                class="border p-2 w-full mb-4"
                placeholder="Nombre del plato">

            <h3 class="font-semibold mb-2">Ingredientes</h3>

            <div class="grid grid-cols-3 gap-3">
                @foreach($availableProducts as $product)
                    <div class="flex items-center gap-2">
                        <span class="text-sm w-40">{{ $product->name }}</span>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            wire:model="products.{{ $product->id }}"
                            class="border p-1 w-20"
                            placeholder="g">
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex gap-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    @if($editingDishId) Actualizar @else Crear @endif
                </button>

                @if($editingDishId)
                <button type="button" wire:click="resetForm"
                    class="bg-gray-500 text-white px-4 py-2 rounded">
                    Cancelar
                </button>
                @endif
            </div>

        </form>
    </div>

 
    <div class="bg-white p-4 border rounded">
        <h3 class="font-semibold mb-2">Platos creados</h3>

        @foreach($dishes as $dish)
            <div class="border p-3 mb-3">
                <div class="flex justify-between">
                    <strong>{{ $dish->name }}</strong>
                    <div>
                        <button wire:click="edit({{ $dish->id }})" class="text-blue-600 mr-2">Editar</button>
                        <button wire:click="delete({{ $dish->id }})" class="text-red-600">Eliminar</button>
                    </div>
                </div>

                <ul class="text-sm mt-2 list-disc ml-4">
                    @foreach($dish->products as $product)
                        <li>
                            {{ $product->name }} - {{ $product->pivot->quantity }} g
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

</div>
