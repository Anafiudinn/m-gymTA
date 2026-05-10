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
        Schema::table('transactions', function (Blueprint $table) {

            $table->enum('source', ['onsite', 'online'])
                ->default('onsite')
                ->after('status');

            $table->string('sender_bank')
                ->nullable()
                ->after('source');

            $table->string('sender_name')
                ->nullable()
                ->after('sender_bank');

            $table->string('sender_account')
                ->nullable()
                ->after('sender_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->dropColumn([
                'source',
                'sender_bank',
                'sender_name',
                'sender_account'
            ]);
        });
    }
};
