namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExpiringDocumentNotification extends Notification
{
    public function __construct(public $vehicles) {}

    public function via($notifiable) { return ['mail']; }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Avviso Scadenze Flotta - Fleet Manager')
            ->line('Sono stati rilevati veicoli con documenti in scadenza nei prossimi 30 giorni.');

        $insurances = $this->vehicles->filter(fn($v) => $v->is_insurance_expiring_soon);
        if ($insurances->count()) {
            $mail->line('**Assicurazioni in scadenza:**');
            foreach ($insurances as $v) {
                $mail->line("- {$v->plate_number} ({$v->model}): {$v->insurance_expiry->format('d/m/Y')}");
            }
        }

        $inspections = $this->vehicles->filter(fn($v) => $v->is_inspection_expiring_soon);
        if ($inspections->count()) {
            $mail->line('**Revisioni in scadenza:**');
            foreach ($inspections as $v) {
                $mail->line("- {$v->plate_number} ({$v->model}): {$v->inspection_expiry->format('d/m/Y')}");
            }
        }

        return $mail->action('Gestisci Flotta', url('/vehicles'));
    }
}