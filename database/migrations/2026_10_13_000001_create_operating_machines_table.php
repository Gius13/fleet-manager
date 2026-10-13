<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operating_machines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 40)->unique();
            $table->string('machine_type', 100);
            $table->string('brand', 100);
            $table->string('model_name', 150);
            $table->string('serial_number', 150)->nullable()->unique();
            $table->unsignedSmallInteger('construction_year')->nullable();
            $table->string('license_plate', 30)->nullable();
            $table->decimal('operating_hours', 10, 1)->default(0);
            $table->decimal('next_service_hours', 10, 1)->nullable();
            $table->date('inspection_due_on')->nullable();
            $table->string('worksite', 150)->nullable();
            $table->string('status', 30)->default('operativa');
            $table->string('manual_path')->nullable();
            $table->text('notes')->nullable();
            $table->string('public_token', 64)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operating_machines');
    }
};
