<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Veicolo - {{ $vehicle->plate_number }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'media', 
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-200">
    
    <div x-data="{ schedaAttiva: 'dettagli' }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden max-w-md w-full transition-colors duration-200">
        
        <div class="flex justify-center pt-8 pb-4 bg-white dark:bg-gray-800">
            <img src="{{ asset('logo.png') }}" alt="Logo Azienda" class="h-16 object-contain" 
                 onerror="this.outerHTML='<span class=\'text-gray-400 font-bold text-lg tracking-widest uppercase\'>IL TUO LOGO QUI</span>'">
        </div>

        <div class="bg-blue-600 dark:bg-blue-700 p-6 text-white text-center">
            <h1 class="text-3xl font-bold uppercase tracking-wider">{{ $vehicle->plate_number }}</h1>
            <p class="opacity-90 font-medium mt-1">{{ $vehicle->model }}</p>
        </div>
        
        <div class="flex border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            <button @click="schedaAttiva = 'dettagli'" 
                    :class="schedaAttiva === 'dettagli' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400 bg-white dark:bg-gray-800' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="flex-1 py-3 text-sm font-bold text-center transition-all uppercase tracking-wider flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Dettagli
            </button>
            <button @click="schedaAttiva = 'manutenzioni'" 
                    :class="schedaAttiva === 'manutenzioni' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400 bg-white dark:bg-gray-800' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="flex-1 py-3 text-sm font-bold text-center transition-all uppercase tracking-wider flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Storico
            </button>
        </div>

        <div class="p-6">
            
            <div x-show="schedaAttiva === 'dettagli'" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                
                <div class="flex justify-between items-center border-b dark:border-gray-700 pb-4">
                    <span class="text-gray-600 dark:text-gray-300 font-medium">Assicurazione</span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold shadow-sm {{ $vehicle->insurance_expiry->isPast() ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : ($vehicle->is_insurance_expiring_soon ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200') }}">
                        {{ $vehicle->insurance_expiry->format('d/m/Y') }}
                    </span>
                </div>

                <div class="flex justify-between items-center border-b dark:border-gray-700 pb-4">
                    <span class="text-gray-600 dark:text-gray-300 font-medium">Revisione</span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold shadow-sm {{ $vehicle->inspection_expiry->isPast() ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : ($vehicle->is_inspection_expiring_soon ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200') }}">
                        {{ $vehicle->inspection_expiry->format('d/m/Y') }}
                    </span>
                </div>

                <div class="pt-4">
                    @if($vehicle->circulation_card_path)
                        <a href="{{ asset('storage/' . $vehicle->circulation_card_path) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-gray-800 dark:bg-gray-700 text-white py-4 px-4 rounded-xl font-bold shadow-md hover:bg-gray-700 dark:hover:bg-gray-600 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Visualizza Carta Di Circolazione
                        </a>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 text-center border border-dashed border-gray-300 dark:border-gray-600">
                            <span class="text-sm text-gray-500 dark:text-gray-400 italic flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Nessuna Carta Di Circolazione Caricata
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div x-show="schedaAttiva === 'manutenzioni'" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 style="display: none;" 
                 class="space-y-4">
                 
                 @if(!isset($vehicle->maintenances) || $vehicle->maintenances->isEmpty())
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 text-center border border-dashed border-gray-300 dark:border-gray-600">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Nessuna manutenzione registrata.</span>
                    </div>
                 @else
                    <ul class="space-y-4">
                        @foreach($vehicle->maintenances as $maintenance)
                            <li class="bg-white dark:bg-gray-700 p-4 rounded-xl border-l-4 border-l-purple-500 border border-gray-100 dark:border-gray-600 shadow-sm">
                                
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">
                                            {{ $maintenance->type }}
                                        </h4>
                                        
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $maintenance->date ? \Carbon\Carbon::parse($maintenance->date)->format('d/m/Y') : 'Data non inserita' }}
                                            </span>
                                            
                                            @if($maintenance->kilometers)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ number_format($maintenance->kilometers, 0, ',', '.') }} km
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($maintenance->description)
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-dashed border-gray-200 dark:border-gray-600">
                                        {{ $maintenance->description }}
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                 @endif
            </div>

        </div>
        
        <div class="bg-gray-50 dark:bg-gray-700 p-4 text-center text-xs text-gray-400 dark:text-gray-500 border-t border-gray-100 dark:border-gray-800">
            Sistema Gestione Flotta v1.0
        </div>
    </div>
</body>
</html>