<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración - Branyey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Bienvenido, {{ Auth::user()->nombre_completo }}</h3>
                    <p>Desde aquí podrás gestionar el inventario de camisas, ver las ventas y controlar los usuarios mayoristas.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="p-4 bg-blue-100 rounded-lg shadow-inner">
                            <h4 class="font-bold text-blue-800">Productos</h4>
                            <p class="text-2xl">0</p>
                        </div>
                        <div class="p-4 bg-green-100 rounded-lg shadow-inner">
                            <h4 class="font-bold text-green-800">Ventas Hoy</h4>
                            <p class="text-2xl">$ 0</p>
                        </div>
                        <div class="p-4 bg-purple-100 rounded-lg shadow-inner">
                            <h4 class="font-bold text-purple-800">Nuevos Clientes</h4>
                            <p class="text-2xl">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>