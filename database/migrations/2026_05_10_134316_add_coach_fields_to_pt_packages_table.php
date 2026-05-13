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
        Schema::table('pt_packages', function (Blueprint $table) {
            //

                $table->string('coach_name')
                ->nullable()
                ->after('nama_paket');

            $table->string('coach_whatsapp')
                ->nullable()
                ->after('coach_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pt_packages', function (Blueprint $table) {
            //
                $table->dropColumn([
                    'coach_name',
                    'coach_whatsapp'
                ]);
        });
    }
};
