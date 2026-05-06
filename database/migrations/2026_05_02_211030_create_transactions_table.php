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
        // Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('user_id')->constrained(); // Pelanggan
            // Simpan nama tamu di sini (Udin, dll)
            $table->string('guest_name')->nullable();
            $table->string('guest_whatsapp')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users'); // Kasir
            $table->string('category'); // activation, monthly, pt, visit, retail
            $table->integer('amount');
            $table->enum('payment_method', ['cash', 'transfer']);
            $table->enum('status', ['pending', 'success', 'rejected']);
            $table->string('proof_attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
