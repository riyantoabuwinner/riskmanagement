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
        Schema::table('mitigations', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('penanggung_jawab');
            $table->decimal('anggaran', 15, 2)->default(0)->after('target_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitigations', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'anggaran']);
        });
    }
};
