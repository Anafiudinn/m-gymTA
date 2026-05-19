<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_logs', function (Blueprint $table) {
          $table->id();
        $table->string('target'); // Nomor tujuan
        $table->string('recipient_name')->nullable(); // Nama penerima (Member/Admin)
        $table->text('message'); // Isi pesan
        $table->boolean('status'); // true = sukses, false = gagal
        $table->string('reason')->nullable(); // Alasan jika gagal (misal: "target input invalid")
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
