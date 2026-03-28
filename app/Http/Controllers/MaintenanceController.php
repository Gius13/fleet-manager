<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    // Mostra la pagina con lo storico di un veicolo
    public function index(Vehicle $vehicle)
    {
        $maintenances = $vehicle->maintenances()->orderBy('date', 'desc')->get();
        return view('maintenances.index', compact('vehicle', 'maintenances'));
    }

    
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'kilometers' => 'nullable|integer|min:0', 
            'cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $vehicle->maintenances()->create($request->all());

        return back()->with('success', 'Manutenzione registrata con successo!');
    }

    public function create(Vehicle $vehicle)
    {
        return view('maintenances.create', compact('vehicle'));
    }

    // Elimina una manutenzione per errore
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return back()->with('success', 'Record eliminato.');
    }
}