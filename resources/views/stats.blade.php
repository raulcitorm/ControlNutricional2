<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estadísticas del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('Total de Productos') }}
                                </p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ $total_products }}
                                </p>
                            </div>
                            <div class="text-4xl text-blue-500 opacity-10">
                                
                            </div>
                        </div>
                    </div>
                </div>

            
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('Total de Platos') }}
                                </p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ $total_dishes }}
                                </p>
                            </div>
                            <div class="text-4xl text-green-500 opacity-10">
                                
                            </div>
                        </div>
                    </div>
                </div>

       
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('Total de Menús') }}
                                </p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ $total_menus }}
                                </p>
                            </div>
                            <div class="text-4xl text-orange-500 opacity-10">
                                
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('Productos Globales') }}
                                </p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ $global_products }}
                                </p>
                            </div>
                            <div class="text-4xl text-purple-500 opacity-10">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Volver al Dashboard') }}
            </a>
        </div>
    </div>
</x-app-layout>
