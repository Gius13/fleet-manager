<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeadlineNotification; // Opzionale, se vuoi usarlo per il test

class SettingController extends Controller
{
    /**
     * Mostra la pagina delle impostazioni con tutti i parametri SMTP
     */
    public function index()
    {
        // Recuperiamo il primo record (o lo creiamo se vuoto)
        $settings = Setting::firstOrCreate(
            ['key' => 'notification_email'],
            [
                'value' => env('NOTIFICATION_EMAIL', 'giuseppe@edil2costruzioni.it'),
                'mail_host' => env('MAIL_HOST', 'smtp.gmail.com'),
                'mail_port' => env('MAIL_PORT', '465'),
                'mail_encryption' => env('MAIL_ENCRYPTION', 'ssl'),
            ]
        );

        return view('settings.index', compact('settings'));
    }

    /**
     * Salva l'intera configurazione (Email + SMTP)
     */
    public function update(Request $request)
    {
        // Validazione dei campi necessari
        $request->validate([
            'email' => 'required|email',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|in:ssl,tls,null',
        ]);

        // Aggiorniamo il record unico delle impostazioni
        Setting::updateOrCreate(
            ['key' => 'notification_email'],
            [
                'value' => $request->email,
                'mail_host' => $request->mail_host,
                'mail_port' => $request->mail_port,
                'mail_username' => $request->mail_username,
                'mail_password' => $request->mail_password,
                'mail_encryption' => $request->mail_encryption,
            ]
        );

        return back()->with('success', 'Configurazione di sistema aggiornata con successo!');
    }

    /**
     * FUNZIONE EXTRA: Invia una mail di prova per verificare i dati inseriti
     */
    public function testEmail()
    {
        $settings = Setting::where('key', 'notification_email')->first();

        if (!$settings || !$settings->value) {
            return back()->with('error', 'Configura prima un indirizzo email!');
        }

        try {
            // Inviamo una semplice mail di testo per testare la connessione
            Mail::raw("Test di configurazione Edil2 Fleet Manager riuscito! Il server SMTP sta funzionando correttamente.", function ($message) use ($settings) {
                $message->to($settings->value)
                        ->subject('📧 Test Connessione Mail Edil2');
            });

            return back()->with('success', 'Mail di prova inviata a ' . $settings->value . '. Controlla la tua posta!');
        } catch (\Exception $e) {
            return back()->with('error', 'Errore durante l\'invio: ' . $e->getMessage());
        }
    }
}