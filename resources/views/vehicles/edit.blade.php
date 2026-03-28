<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifica Veicolo: {{ $vehicle->plate_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">N. Flotta (es. 01)</label>
                            <input type="text" name="fleet_number" value="{{ old('fleet_number', $vehicle->fleet_number) }}" placeholder="01"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Targa</label>
                            <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modello</label>
                            <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Scadenza Assicurazione</label>
                            <input type="date" name="insurance_expiry" value="{{ old('insurance_expiry', $vehicle->insurance_expiry->format('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Scadenza Revisione</label>
                            <input type="date" name="inspection_expiry" value="{{ old('inspection_expiry', $vehicle->inspection_expiry->format('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border dark:border-gray-700 transition-colors duration-200">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Libretto Attuale</label>
                        @if($vehicle->circulation_card_path)
                            <div class="flex items-center gap-4 mb-4">
                                <span class="text-teal-600 dark:text-teal-400 text-sm font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path></svg>
                                    PDF Caricato
                                </span>
                                <a href="{{ asset('storage/' . $vehicle->circulation_card_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 text-sm underline hover:no-underline">Apri file</a>
                            </div>
                        @endif
                        <input type="file" name="circulation_card" accept="application/pdf" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-300 hover:file:bg-blue-100">
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 shadow-lg transition font-bold uppercase tracking-widest text-xs">
                            Aggiorna Veicolo
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="text-gray-500 dark:text-gray-400 hover:underline">Annulla</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>