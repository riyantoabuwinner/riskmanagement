<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('kode')->nullable()->after('id');
        });

        Schema::table('risk_categories', function (Blueprint $table) {
            $table->string('kode')->nullable()->after('id');
        });

        Schema::table('risks', function (Blueprint $table) {
            $table->string('kode_risiko')->nullable()->after('id');
            $table->integer('nomor_urut')->nullable()->after('kode_risiko');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('risk_categories', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn(['kode_risiko', 'nomor_urut']);
        });
    }
};
