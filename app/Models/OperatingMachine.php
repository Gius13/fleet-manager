<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class OperatingMachine extends Model
{
    use HasUuids;

    protected $fillable = [
        'code', 'machine_type', 'brand', 'model_name', 'serial_number',
        'construction_year', 'license_plate', 'operating_hours',
        'next_service_hours', 'inspection_due_on', 'worksite',
        'status', 'manual_path', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'construction_year' => 'integer',
            'operating_hours' => 'decimal:1',
            'next_service_hours' => 'decimal:1',
            'inspection_due_on' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $machine): void {
            // Non utilizzare l'ID progressivo come credenziale del QR.
            $machine->public_token ??= Str::random(48);
        });
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(OperatingMachineMaintenance::class);
    }

    public function serviceIsDue(): bool
    {
        return $this->next_service_hours !== null
            && (float) $this->operating_hours >= (float) $this->next_service_hours;
    }
}
