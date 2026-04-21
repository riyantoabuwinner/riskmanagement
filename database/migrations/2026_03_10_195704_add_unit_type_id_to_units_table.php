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
        Schema::table('units', function (Blueprint $table) {
            $table->foreignId('unit_type_id')->nullable()->after('nama_unit')->constrained('unit_types')->onDelete('set null');
            $table->dropColumn('jenis_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['unit_type_id']);
            $table->dropColumn('unit_type_id');
            $table->string('jenis_unit')->nullable()->after('nama_unit');
        });
    }
};
