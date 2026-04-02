<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center sm:text-left">
                Manutenzioni: {{ $vehicle->plate_number }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('vehicles.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">Torna alla Flotta</a>
                
                <a href="{{ route('vehicles.maintenances.create', $vehicle->id) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 shadow-sm transition ease-in-out duration-150">
                    + Registra Intervento
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mx-4 sm:mx-0">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden transition-colors duration-200">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Storico Manutenzioni</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Intervento & Note</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Km</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Costo</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($maintenances as $maint)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maint->date->format('d/m/Y') }}
                                        </td>
                                        
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="font-medium">{{ $maint->type }}</div>
                                            @if($maint->description)
                                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 whitespace-normal min-w-[200px] max-w-md italic">
                                                    {{ $maint->description }}
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maint->kilometers ? number_format($maint->kilometers, 0, '', '.') . ' km' : '-' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600 dark:text-purple-400">
                                            {{ $maint->cost ? '€ ' . number_format($maint->cost, 2, ',', '.') : '-' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('maintenances.destroy', $maint->id) }}" method="POST" onsubmit="return confirm('Vuoi eliminare questo record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 hover:underline">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">Nessuna manutenzione registrata.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <a href="{{ route('vehicles.maintenances.create', $vehicle->id) }}" title="Nuova Manutenzione"
       class="sm:hidden fixed bottom-6 right-6 w-16 h-16 bg-purple-600 rounded-full text-white shadow-2xl flex items-center justify-center text-3xl hover:bg-purple-700 transition duration-150 ease-in-out z-50 transform hover:scale-110 active:scale-95">
        +
    </a>
</x-app-layout>