<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-center mb-10 pt-4">
                {{-- Ho impostato un'altezza di 20 (h-20) e larghezza automatica (w-auto) --}}
                {{-- per renderlo elegante e ben visibile. --}}
                <img src="{{ asset('images/logo.png') }}" alt="Edil2 Logo" class="h-20 w-auto">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Totale Veicoli --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Totale Veicoli</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalVehicles }}</p>
                    </div>
                </div>

                {{-- Scadute --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Scadenze Critiche</p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $totalExpired }}</p>
                    </div>
                </div>

                {{-- In Scadenza --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-amber-500">
                    <div class="p-6">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">In Scadenza (30gg)</p>
                        <p class="text-3xl font-bold text-amber-500 dark:text-amber-400">{{ $totalExpiringSoon }}</p>
                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-6">Azioni Rapide</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Gestione Flotta --}}
                        <a href="{{ route('vehicles.index') }}" class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 dark:text-gray-100 uppercase tracking-wider">Gestione Flotta</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Vai all'elenco mezzi</p>
                            </div>
                        </a>

                        {{-- Nuovo Mezzo --}}
                        <a href="{{ route('vehicles.create') }}" class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 bg-emerald-100 dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 dark:text-gray-100 uppercase tracking-wider">Nuovo Mezzo</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Aggiungi un veicolo</p>
                            </div>
                        </a>

                        {{-- Impostazioni --}}
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 dark:text-gray-100 uppercase tracking-wider">Impostazioni</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Configura notifiche</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>