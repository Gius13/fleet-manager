<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  

    public function up(): void
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // Esempio: 'notification_email'
        $table->text('value')->nullable();
        $table->timestamps();
    });

    // Inseriamo un valore predefinito subito
    DB::table('settings')->insert([
        'key' => 'notification_email',
        'value' => 'giuseppe@edil2costruzioni.it',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
};
