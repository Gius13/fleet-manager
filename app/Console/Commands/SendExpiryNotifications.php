<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Notifications\ExpiringDocumentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SendExpiryNotifications extends Command
{
    /**
     * Il nome e la firma del comando da terminale.
     * Si esegue con: php artisan app:send-expiry-notifications
     */
    protected $signature = 'app:send-expiry-notifications';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Controlla i veicoli con assicurazione o revisione in scadenza entro 30 giorni e invia un report via email';

    /**
     * Esecuzione della logica del comando.
     */
    public function handle()
    {
        $this->info('Inizio scansione scadenze veicoli...');

        // Definiamo la soglia dei 30 giorni da oggi
        $thresholdDate = now()->addDays(30);

        // Recuperiamo i veicoli che hanno ALMENO una scadenza entro i prossimi 30 giorni
        // Includiamo anche quelli già scaduti (data < oggi) che non sono ancora stati gestiti
        $expiringVehicles = Vehicle::where('insurance_expiry', '<=', $thresholdDate)
            ->orWhere('inspection_expiry', '<=', $thresholdDate)
            ->get();

        if ($expiringVehicles->isEmpty()) {
            $this->info('Nessun veicolo in scadenza trovato.');
            return Command::SUCCESS;
        }

        $emailRecipient = config('mail.notification_recipient') ?? env('NOTIFICATION_EMAIL');

        if (!$emailRecipient) {
            $this->error('ERRORE: NOTIFICATION_EMAIL non configurato nel file .env');
            return Command::FAILURE;
        }

        try {
            // Invio della notifica all'indirizzo configurato
            Notification::route('mail', $emailRecipient)
                ->notify(new ExpiringDocumentNotification($expiringVehicles));

            $count = $expiringVehicles->count();
            $this->info("Notifica inviata a {$emailRecipient} per {$count} veicoli.");
            Log::info("Cron Scadenze: Inviata email di notifica per {$count} veicoli.");

        } catch (\Exception $e) {
            $this->error('Errore durante l\'invio della notifica: ' . $e->getMessage());
            Log::error('Errore invio email scadenze: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}