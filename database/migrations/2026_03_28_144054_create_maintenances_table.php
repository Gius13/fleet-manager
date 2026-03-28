<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            // Colleghiamo la manutenzione al veicolo tramite il suo UUID
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            
            $table->string('type'); // Es. Tagliando, Gomme, Freni
            $table->date('date');
            $table->text('description')->nullable();
            $table->decimal('cost', 8, 2)->nullable(); // Costo opzionale
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};