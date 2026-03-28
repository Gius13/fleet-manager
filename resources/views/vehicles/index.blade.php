<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestione Flotta Veicoli') }}
            </h2>
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                + Aggiungi Veicolo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 transition-colors duration-200">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Totale Veicoli</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $vehicles->count() }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500 transition-colors duration-200">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Scadenze Critiche</div>
                    <div class="mt-1 text-3xl font-semibold text-red-600 dark:text-red-400">{{ $criticalCount ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 transition-colors duration-200">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Stato Sistema</div>
                    <div class="mt-1 text-3xl font-semibold text-green-600 dark:text-green-400">Attivo</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-200 border dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-900 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Veicolo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assicurazione</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revisione</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">QR Code</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($vehicles as $vehicle)
                                    <tr class="dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100 uppercase">
                                                @if($vehicle->fleet_number) <span class="text-blue-600 dark:text-blue-400">[{{ $vehicle->fleet_number }}]</span> @endif
                                                {{ $vehicle->plate_number }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $vehicle->model }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $insStatus = $vehicle->insurance_expiry->isPast() ? 'red' : ($vehicle->is_insurance_expiring_soon ? 'yellow' : 'green');
                                                $insColors = ['red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', 'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'];
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $insColors[$insStatus] }}">
                                                {{ $vehicle->insurance_expiry->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $inspStatus = $vehicle->inspection_expiry->isPast() ? 'red' : ($vehicle->is_inspection_expiring_soon ? 'yellow' : 'green');
                                                $inspColors = ['red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', 'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'];
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $inspColors[$inspStatus] }}">
                                                {{ $vehicle->inspection_expiry->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($vehicle->qr_code_path)
                                                <a href="{{ route('vehicles.label', $vehicle->id) }}" target="_blank" class="inline-block">
                                                    <img src="{{ asset('storage/' . $vehicle->qr_code_path) }}" 
                                                         class="w-16 h-16 mx-auto border dark:border-gray-600 bg-white p-1 rounded shadow-sm hover:opacity-80 transition-opacity">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs italic">No QR</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                                            <div class="flex justify-end items-center gap-3 uppercase tracking-tighter">
                                                @if($vehicle->circulation_card_path)
                                                    <a href="{{ asset('storage/' . $vehicle->circulation_card_path) }}" target="_blank" class="text-teal-600 dark:text-teal-400 hover:underline">Carta di Circolazione</a>
                                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                                @endif

                                                <a href="{{ route('vehicles.show', $vehicle->id) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">Scheda</a>
                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-yellow-600 dark:text-yellow-500 hover:underline">Modifica</a>
                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                <a href="{{ route('vehicles.maintenances.index', $vehicle->id) }}" class="text-purple-600 dark:text-purple-400 hover:underline font-bold">Manutenzioni</a>
                                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Sei sicuro?');" class="inline">
                                                <span class="text-gray-300 dark:text-gray-600">|</span>

                                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Sei sicuro?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:underline font-bold">Elimina</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                            Nessun veicolo presente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>