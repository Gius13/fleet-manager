<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stampa Etichetta - {{ $vehicle->fleet_number ?? $vehicle->plate_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white !important; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-container { 
                width: 80mm; 
                margin: 0 auto; 
                box-shadow: none; 
                border: none;
                -webkit-print-color-adjust: exact !important; /* Forza il colore su Chrome/Safari */
                print-color-adjust: exact !important;
            }
        }
        .text-outline {
            -webkit-text-stroke: 3px black;
            color: white;
            paint-order: stroke fill;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <button onclick="window.print()" class="no-print mb-6 px-10 py-4 bg-blue-600 text-white font-black rounded-xl shadow-xl hover:bg-blue-700 transition transform active:scale-95 flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        STAMPA ORA (80mm)
    </button>

    <div class="print-container bg-white p-6 w-[80mm] flex flex-col items-center shadow-2xl">
        
        <div class="w-52 h-52 rounded-full bg-[#E31E24] border-[14px] border-black flex flex-col items-center justify-center shadow-sm">
            <h2 class="text-white text-3xl font-black uppercase tracking-widest mb-[-8px]">EDIL2</h2>
            <div class="text-[90px] font-black text-outline tracking-tighter leading-none">
                {{ $vehicle->fleet_number ?? substr($vehicle->plate_number, 0, 2) }}
            </div>
        </div>

        <div class="mt-6 flex flex-col items-center w-full">
            <div class="bg-white p-1 border-2 border-black mb-2">
                <img src="{{ asset('storage/' . $vehicle->qr_code_path) }}" class="w-28 h-28">
            </div>
            <p class="font-black text-[11px] uppercase text-center text-black leading-tight px-2">
                SCANSIONA PER STATO LIVE E DOCUMENTI
            </p>
        </div>

        <div class="mt-6 w-full border-t-2 border-gray-100 pt-4">
            <img src="{{ asset('certificazioni.png') }}" 
                 class="w-full h-auto" 
                 onerror="this.outerHTML='<div class=\'text-center text-[8px] text-gray-300 font-bold uppercase\'>Certificazioni RINA</div>'">
        </div>
    </div>

    <p class="no-print mt-6 text-gray-400 text-xs italic text-center">
        Nota: Assicurati di attivare "Grafica di sfondo" nelle impostazioni di stampa <br> per vedere il cerchio rosso.
    </p>

</body>
</html>