<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Vehicle extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'plate_number',
        'fleet_number', // <--- AGGIUNTO
        'model',
        'insurance_expiry',
        'inspection_expiry',
        'circulation_card_path',
        'qr_code_path',
        'notes'
    ];

    protected $casts = [
        'insurance_expiry' => 'date',
        'inspection_expiry' => 'date',
    ];

    protected static function booted()
{
    static::created(function ($vehicle) {
        $path = "qrcodes/{$vehicle->id}.png"; // Passiamo a PNG per gestire il logo
        $url = config('app.url') . "/vehicles/public/{$vehicle->id}"; 
        
        $image = QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H') // Alta correzione errore (necessaria se metti un logo)
            ->merge(public_path('logo.png'), .3, true) // Il tuo logo al centro (30% della dimensione)
            ->style('dot') // Rende i moduli interni dei "punti" invece di quadrati
            ->eye('circle') // Rende gli angoli circolari
            ->generate($url);

        Storage::disk('public')->put($path, $image);
        $vehicle->updateQuietly(['qr_code_path' => $path]);
    });
}

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
