<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Veicolo - {{ $vehicle->plate_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'media', 
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-200">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden max-w-md w-full transition-colors duration-200">
        
        <div class="flex justify-center pt-8 pb-4 bg-white dark:bg-gray-800">
            <img src="{{ asset('logo.png') }}" alt="Logo Azienda" class="h-16 object-contain" 
                 onerror="this.outerHTML='<span class=\'text-gray-400 font-bold text-lg tracking-widest uppercase\'>IL TUO LOGO QUI</span>'">
        </div>

        <div class="bg-blue-600 dark:bg-blue-700 p-6 text-white text-center">
            <h1 class="text-3xl font-bold uppercase tracking-wider">{{ $vehicle->plate_number }}</h1>
            <p class="opacity-90 font-medium mt-1">{{ $vehicle->model }}</p>
        </div>
        
        <div class="p-6 space-y-6">
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
        
        <div class="bg-gray-50 dark:bg-gray-700 p-4 text-center text-xs text-gray-400 dark:text-gray-500 border-t border-gray-100 dark:border-gray-800">
            Sistema Gestione Flotta v1.0
        </div>
    </div>
</body>
</html>