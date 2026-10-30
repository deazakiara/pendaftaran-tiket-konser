<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Membuat tabel "registrations" untuk menyimpan data pendaftar.
// Jalankan dengan: php artisan migrate
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();        // contoh: GSF-7KQ2XM
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('ticket_type');                  // festival / tribune / vip
            $table->unsignedTinyInteger('quantity');
            $table->unsignedInteger('total_price');         // dalam rupiah
            $table->timestamp('email_sent_at')->nullable(); // kosong = email belum terkirim
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
