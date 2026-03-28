<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nuova Manutenzione') }}
            </h2>
            <a href="{{ route('vehicles.maintenances.index', $vehicle->id) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">Torna allo storico</a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-t-4 border-purple-500 mx-4 sm:mx-0 transition-colors duration-200">
                
                <h3 class="text-lg font-bold text-purple-800 dark:text-purple-400 mb-6 uppercase tracking-wider">
                    {{ $vehicle->plate_number }} ({{ $vehicle->model }})
                </h3>

                <form action="{{ route('vehicles.maintenances.store', $vehicle->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo Intervento <span class="text-red-500">*</span></label>
                        <input type="text" name="type" placeholder="Es. Tagliando, Cambio Gomme, Riparazione..." required 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Intervento <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chilometraggio (Km) - Opzionale</label>
                        <input type="number" name="kilometers" placeholder="Es. 125000" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo (€) - Opzionale</label>
                        <input type="number" step="0.01" name="cost" placeholder="0.00" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dettagli / Note</label>
                        <textarea name="description" rows="4" placeholder="Inserisci qui eventuali dettagli aggiuntivi..." 
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200"></textarea>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-purple-600 text-white font-bold rounded-md hover:bg-purple-700 shadow flex items-center justify-center gap-2 text-center uppercase tracking-widest text-sm transition-colors duration-200">
                            Salva Manutenzione
                        </button>
                        <a href="{{ route('vehicles.maintenances.index', $vehicle->id) }}" 
                           class="w-full sm:w-auto px-6 py-3 text-center text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                           Annulla
                        </a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>