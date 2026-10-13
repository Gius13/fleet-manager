<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operating_machine_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('operating_machine_id')->constrained('operating_machines')->cascadeOnDelete();
            $table->string('type', 150);
            $table->date('performed_on');
            $table->decimal('operating_hours', 10, 1)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operating_machine_maintenances');
    }
};
