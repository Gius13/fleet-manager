<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edil2 Fleet - {{ $vehicle->plate_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white font-sans antialiased selection:bg-blue-500">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="w-full max-w-md bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-800">
            
            <div class="bg-blue-600 p-8 text-center shadow-lg">
                <div class="text-xs uppercase font-black tracking-[0.3em] text-blue-200 mb-1">Status Ufficiale</div>
                <h1 class="text-3xl font-black uppercase tracking-tighter">Edil2 Costruzioni</h1>
            </div>

            <div class="p-8 space-y-8">
                <div class="text-center">
                    <div class="inline-block px-4 py-1 rounded-full bg-slate-800 border border-slate-700 text-blue-400 text-xs font-bold uppercase tracking-widest mb-3">
                        Dati Mezzo
                    </div>
                    <div class="text-5xl font-black tracking-tighter mb-1">{{ $vehicle->plate_number }}</div>
                    <div class="text-xl text-slate-400 font-medium italic">{{ $vehicle->model }}</div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-5 rounded-3xl bg-slate-800/50 border {{ $vehicle->insurance_expiry->isPast() ? 'border-red-500/50' : 'border-emerald-500/50' }}">
                        <div>
                            <div class="text-[10px] uppercase font-black text-slate-500 tracking-widest">Assicurazione</div>
                            <div class="text-lg font-bold">{{ $vehicle->insurance_expiry->format('d/m/Y') }}</div>
                        </div>
                        <div class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $vehicle->insurance_expiry->isPast() ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                            {{ $vehicle->insurance_expiry->isPast() ? 'Scaduta' : 'Valida' }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-5 rounded-3xl bg-slate-800/50 border {{ $vehicle->inspection_expiry->isPast() ? 'border-red-500/50' : 'border-emerald-500/50' }}">
                        <div>
                            <div class="text-[10px] uppercase font-black text-slate-500 tracking-widest">Revisione</div>
                            <div class="text-lg font-bold">{{ $vehicle->inspection_expiry->format('d/m/Y') }}</div>
                        </div>
                        <div class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $vehicle->inspection_expiry->isPast() ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                            {{ $vehicle->inspection_expiry->isPast() ? 'Scaduta' : 'Valida' }}
                        </div>
                    </div>
                </div>

                <div class="pt-4 text-center">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest leading-relaxed">
                        Questo veicolo fa parte della flotta <br> 
                        <strong>Edil2 Costruzioni S.r.l.</strong>
                    </p>
                </div>
            </div>
        </div>

        @auth
            <a href="{{ route('vehicles.index') }}" class="mt-8 px-6 py-2 rounded-full bg-slate-800 text-slate-400 text-xs font-bold hover:bg-slate-700 transition">
                ← Torna al Gestionale
            </a>
        @endauth
    </div>
</body>
</html>