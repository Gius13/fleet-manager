<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
	URL::forceRootUrl('https://fleetmanager.edil2costruzioni.it');
	URL::forceScheme('https');
        // Controlliamo che la tabella settings esista per evitare errori al primo avvio
        if (Schema::hasTable('settings')){            
            // Recuperiamo l'unico record delle impostazioni
            $mailSettings = Setting::where('key', 'notification_email')->first();

            if ($mailSettings) {
                // Sovrascriviamo la configurazione SMTP con i dati salvati nel DB
                Config::set('mail.mailers.smtp.host', $mailSettings->mail_host ?? env('MAIL_HOST'));
                Config::set('mail.mailers.smtp.port', $mailSettings->mail_port ?? env('MAIL_PORT'));
                Config::set('mail.mailers.smtp.username', $mailSettings->mail_username ?? env('MAIL_USERNAME'));
                Config::set('mail.mailers.smtp.password', $mailSettings->mail_password ?? env('MAIL_PASSWORD'));
                Config::set('mail.mailers.smtp.encryption', $mailSettings->mail_encryption ?? env('MAIL_ENCRYPTION'));
                
                // Impostiamo anche l'indirizzo mittente (From)
                Config::set('mail.from.address', $mailSettings->mail_username ?? env('MAIL_FROM_ADDRESS'));
                Config::set('mail.from.name', config('app.name'));
            }
        }
    }
}
