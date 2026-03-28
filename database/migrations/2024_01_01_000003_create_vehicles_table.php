<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esegue la migrazione per creare la tabella vehicles.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            // Usiamo UUID per una maggiore sicurezza nei QR Code pubblici
            $table->uuid('id')->primary();
            $table->string('plate_number')->unique();
            $table->string('model');
            $table->date('insurance_expiry');
            $table->date('inspection_expiry');
            $table->string('circulation_card_path')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Annulla la migrazione.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};