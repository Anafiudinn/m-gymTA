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
        Schema::create('pt_session_logs', function (Blueprint $table) {
            $table->id();
            // Pakai onDelete('set null') supaya kalau member dihapus, riwayatnya tetap ada buat laporan
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pt_membership_id')->nullable()->constrained('pt_memberships')->onDelete('set null');

            // Simpan nama manual (Snapshot) biar kalau user dihapus, di log tetap tertulis namanya
            $table->string('member_name');
            $table->string('coach_name')->nullable();

            $table->integer('previous_session'); // Sesi sebelum dipotong
            $table->integer('current_session');  // Sesi setelah dipotong
            $table->timestamps(); // Ini otomatis mencatat jam & tanggal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_session_logs');
    }
};
