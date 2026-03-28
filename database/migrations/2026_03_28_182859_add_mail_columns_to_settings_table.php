<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->string('mail_host')->nullable();
        $table->string('mail_port')->nullable();
        $table->string('mail_username')->nullable();
        $table->string('mail_password')->nullable();
        $table->string('mail_encryption')->nullable();
    });
}
};
