<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Mail\DeadlineNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Carbon\Carbon;

#[Signature('app:check-deadlines')]
#[Description('Invia notifiche esattamente 7 giorni e 1 giorno prima della scadenza')]
class CheckDeadlines extends Command
{
    public function handle()
    {

        $setting = \App\Models\Setting::where('key', 'notification_email')->first();
        $destinatario = $setting ? $setting->value : env('NOTIFICATION_EMAIL');
        
        // 1. Definiamo le due date esatte che ci interessano
        $fraSetteGiorni = Carbon::today()->addDays(7)->format('Y-m-d');
        $domani = Carbon::today()->addDay()->format('Y-m-d');

        // 2. Cerchiamo i veicoli che scadono esattamente in una di queste due date
        $vehicles = Vehicle::whereIn('insurance_expiry', [$fraSetteGiorni, $domani])
            ->orWhereIn('inspection_expiry', [$fraSetteGiorni, $domani])
            ->get();

        // 3. Invio della mail se troviamo corrispondenze
        if ($vehicles->count() > 0) {
            
            $destinatario = env('NOTIFICATION_EMAIL', 'giuseppe@edil2costruzioni.it');

            try {
                Mail::to($destinatario)->send(new DeadlineNotification($vehicles));
                $this->info("✅ Notifica inviata per i veicoli in scadenza il {$fraSetteGiorni} o il {$domani}.");
            } catch (\Exception $e) {
                $this->error("❌ Errore invio: " . $e->getMessage());
            }

        } else {
            $this->info("ℹ️ Nessun veicolo scade esattamente tra 7 giorni o domani.");
        }
    }
}