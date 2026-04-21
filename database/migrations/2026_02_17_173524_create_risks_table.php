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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('risk_categories')->cascadeOnDelete();
            $table->string('nama_risiko');
            $table->text('deskripsi')->nullable();
            $table->text('penyebab')->nullable();
            $table->text('dampak')->nullable();
            $table->integer('probabilitas')->default(1);
            $table->integer('level_dampak')->default(1);
            $table->integer('skor_risiko')->default(1);
            $table->string('level_risiko')->nullable();
            $table->string('pemilik_risiko')->nullable();
            $table->string('status')->default('Draft');
            $table->date('tanggal_identifikasi')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
