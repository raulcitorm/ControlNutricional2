<div class="p-4 space-y-6 text-gray-800">

    <h2 class="text-xl font-bold text-gray-900">Mi Menú del Día</h2>

    <div class="bg-white p-4 border rounded space-y-4">
        

        <div class="flex items-center gap-4">
            <label class="font-semibold text-gray-800">Fecha:</label>
            <input
                type="date"
                wire:model.live="selectedDate"
                wire:change="changeDate"
                class="border p-2 rounded text-gray-900"
            >
        </div>


        <div class="border-t pt-4 space-y-3">
            <h3 class="font-semibold text-gray-800">Añadir Plato</h3>
            
            <div class="grid grid-cols-3 gap-3">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de comida</label>
                    <select
                        wire:model="selectedMealType"
                        class="border p-2 w-full rounded text-gray-900"
                    >
                        @foreach($mealTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

        
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Plato</label>
                    <select
                        wire:model="selectedDish"
                        class="border p-2 w-full rounded text-gray-900"
                    >
                        <option value="">Selecciona un plato</option>
                        @forelse($availableDishes as $dish)
                            <option value="{{ $dish['id'] }}">{{ $dish['name'] }}</option>
                        @empty
                            <option value="" disabled>No tienes platos creados</option>
                        @endforelse
                    </select>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Porciones</label>
                    <input
                        type="number"
                        step="0.5"
                        min="0.5"
                        wire:model="servings"
                        class="border p-2 w-full rounded text-gray-900"
                    >
                </div>
            </div>

            <button
                wire:click="addDishToMenu"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium"
            >
                Agregar al menú
            </button>

            @error('selectedDish')
                <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </div>


    <div class="bg-white p-4 border rounded space-y-4">
        <h3 class="font-semibold text-gray-900 text-lg">Menú de {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</h3>

        @if($menus->isEmpty())
            <p class="text-gray-500 italic">Sin platos añadidos para este día</p>
        @else

            @foreach($mealTypes as $mealValue => $mealLabel)
                @php
                    $mealMenus = $menus->filter(fn($m) => $m->meal_type === $mealValue);
                @endphp
                
                @if($mealMenus->count() > 0)
                    <details class="border rounded-lg overflow-hidden">
                        <summary class="bg-gradient-to-r from-blue-50 to-blue-100 p-3 cursor-pointer font-semibold text-gray-800 hover:bg-blue-100 transition">
                            {{ $mealLabel }}
                        </summary>
                        </summary>
                        
                        <div class="p-4 space-y-2 bg-gray-50">
                            @foreach($mealMenus as $menu)
                                <div class="flex items-center justify-between bg-white p-3 rounded border-l-4 border-blue-500">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">{{ $menu->dish->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $menu->servings }} porción(es)</p>
                                    </div>
                                    @role('admin')
                                    <button
                                        wire:click="removeDish({{ $menu->id }})"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium"
                                    >
                                        Eliminar
                                    </button>
                                    @endrole
                               
                                </div>
                            @endforeach
                        </div>
                    </details>
                @endif
            @endforeach
        @endif
    </div>


    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 border-2 border-blue-200 rounded-lg">
        <h3 class="font-bold text-gray-900 text-lg mb-4">Resumen de Nutrientes - {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</h3>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                <p class="text-xs text-gray-600 font-semibold uppercase">Calorías</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($dailyMacros['calories'] ?? 0, 0) }}</p>
                <p class="text-xs text-gray-500">kcal</p>
            </div>


            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                <p class="text-xs text-gray-600 font-semibold uppercase">Proteína</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($dailyMacros['protein'] ?? 0, 1) }}</p>
                <p class="text-xs text-gray-500">g</p>
            </div>


            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500">
                <p class="text-xs text-gray-600 font-semibold uppercase">Carbos</p>
                <p class="text-2xl font-bold text-yellow-600">{{ number_format($dailyMacros['carbohydrates'] ?? 0, 1) }}</p>
                <p class="text-xs text-gray-500">g</p>
            </div>


            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-orange-500">
                <p class="text-xs text-gray-600 font-semibold uppercase">Grasas</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($dailyMacros['total_fat'] ?? 0, 1) }}</p>
                <p class="text-xs text-gray-500">g</p>
            </div>


            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-purple-500">
                <p class="text-xs text-gray-600 font-semibold uppercase">Fibra</p>
                <p class="text-2xl font-bold text-purple-600">{{ number_format($dailyMacros['fiber'] ?? 0, 1) }}</p>
                <p class="text-xs text-gray-500">g</p>
            </div>
        </div>


        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <div class="bg-white p-3 rounded">
                <p class="text-gray-600 font-semibold">Grasa Saturada</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($dailyMacros['saturated_fat'] ?? 0, 1) }}g</p>
            </div>
            <div class="bg-white p-3 rounded">
                <p class="text-gray-600 font-semibold">Azúcares</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($dailyMacros['sugars'] ?? 0, 1) }}g</p>
            </div>
            <div class="bg-white p-3 rounded">
                <p class="text-gray-600 font-semibold">Grasa Poliins.</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($dailyMacros['polyunsaturated_fat'] ?? 0, 1) }}g</p>
            </div>
            <div class="bg-white p-3 rounded">
                <p class="text-gray-600 font-semibold">Grasa Monoins.</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($dailyMacros['monounsaturated_fat'] ?? 0, 1) }}g</p>
            </div>
        </div>
    </div>

</div>
