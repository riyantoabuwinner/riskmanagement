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
        Schema::create('mitigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained()->cascadeOnDelete();
            $table->string('strategi')->nullable();
            $table->text('rencana_aksi');
            $table->string('penanggung_jawab')->nullable();
            $table->date('target_waktu')->nullable();
            $table->string('status')->default('Belum Dimulai'); // Belum Dimulai, Sedang Berjalan, Selesai, Ditunda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitigations');
    }
};
