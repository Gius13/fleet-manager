<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $nextMonth = Carbon::today()->addDays(30);

        // 1. Totale veicoli
        $totalVehicles = Vehicle::count();

        // 2. Alert CRITICI: Scadute oggi o nel passato
        $expiredInsurance = Vehicle::where('insurance_expiry', '<', $today)->count();
        $expiredInspection = Vehicle::where('inspection_expiry', '<', $today)->count();
        $totalExpired = $expiredInsurance + $expiredInspection;

        // 3. Alert PREVENTIVI: In scadenza nei prossimi 30 giorni (ma non ancora scadute)
        $expiringSoonInsurance = Vehicle::whereBetween('insurance_expiry', [$today, $nextMonth])->count();
        $expiringSoonInspection = Vehicle::whereBetween('inspection_expiry', [$today, $nextMonth])->count();
        $totalExpiringSoon = $expiringSoonInsurance + $expiringSoonInspection;

        return view('dashboard', compact(
            'totalVehicles',
            'totalExpired',
            'totalExpiringSoon',
            'expiredInsurance',
            'expiredInspection',
            'expiringSoonInsurance',
            'expiringSoonInspection'
        ));
    }
}