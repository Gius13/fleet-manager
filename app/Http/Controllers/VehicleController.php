<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Necessario per i QR

class VehicleController extends Controller
{
    /**
     * DASHBOARD PRIVATA: Lista veicoli per l'amministratore
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        
        // Calcolo scadenze critiche (entro 15 giorni o passate)
        $criticalCount = Vehicle::where('insurance_expiry', '<=', now()->addDays(15))
            ->orWhere('inspection_expiry', '<=', now()->addDays(15))
            ->count();

        return view('vehicles.index', compact('vehicles', 'criticalCount'));
    }

    /**
     * FORM CREAZIONE
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * SALVATAGGIO NUOVO VEICOLO
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'fleet_number' => 'nullable|string|max:10',
            'model' => 'required|string',
            'insurance_expiry' => 'required|date',
            'inspection_expiry' => 'required|date',
            'circulation_card' => 'nullable|mimes:pdf|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('circulation_card')) {
            $path = $request->file('circulation_card')->store('cards', 'public');
        }

        Vehicle::create([
            'plate_number' => strtoupper($request->plate_number),
            'fleet_number' => $request->fleet_number,
            'model' => $request->model,
            'insurance_expiry' => $request->insurance_expiry,
            'inspection_expiry' => $request->inspection_expiry,
            'circulation_card_path' => $path,
            'notes' => $request->notes,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Veicolo aggiunto correttamente!');
    }

    /**
     * VISTA PUBBLICA (QR CODE): Accessibile a tutti senza login
     */
    public function showPublic(Vehicle $vehicle)
    {
        // Carica solo i dati necessari per la scansione rapida
        return view('vehicles.public-show', compact('vehicle'));
    }

    /**
     * SCHEDA TECNICA PRIVATA: Dettagli completi per l'admin
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load('maintenances');
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * FORM MODIFICA
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * AGGIORNAMENTO DATI
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'fleet_number' => 'nullable|string|max:10',
            'model' => 'required|string',
            'insurance_expiry' => 'required|date',
            'inspection_expiry' => 'required|date',
            'circulation_card' => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = $request->only(['fleet_number', 'model', 'insurance_expiry', 'inspection_expiry', 'notes']);
        $data['plate_number'] = strtoupper($request->plate_number);

        if ($request->hasFile('circulation_card')) {
            if ($vehicle->circulation_card_path) {
                Storage::disk('public')->delete($vehicle->circulation_card_path);
            }
            $data['circulation_card_path'] = $request->file('circulation_card')->store('cards', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('success', 'Dati aggiornati!');
    }

    /**
     * ELIMINAZIONE VEICOLO
     */
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->circulation_card_path) {
            Storage::disk('public')->delete($vehicle->circulation_card_path);
        }

        $vehicle->delete();

        return back()->with('success', 'Veicolo rimosso dal sistema.');
    }

    /**
     * GENERAZIONE E DOWNLOAD QR CODE (Punta alla rotta pubblica /v/)
     */
    public function downloadQr(Vehicle $vehicle)
    {
        // Generiamo l'URL che punta alla rotta PUBBLICA breve
        $url = route('vehicles.public.show', $vehicle->id);

        $qrCode = QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($url);

        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', "attachment; filename=\"QR_{$vehicle->plate_number}.png\"");
    }

    /**
     * DOWNLOAD LIBRETTO (PDF)
     */
    public function downloadCard(Vehicle $vehicle)
    {
        if (!$vehicle->circulation_card_path || !Storage::disk('public')->exists($vehicle->circulation_card_path)) {
            return back()->with('error', 'File non trovato.');
        }

        return Storage::disk('public')->download(
            $vehicle->circulation_card_path, 
            "Libretto_{$vehicle->plate_number}.pdf"
        );
    }

    /**
     * STAMPA ETICHETTA
     */
    public function printLabel(Vehicle $vehicle)
    {
        return view('vehicles.label', compact('vehicle'));
    }
}
