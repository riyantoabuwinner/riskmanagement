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
        Schema::table('risk_monitoring', function (Blueprint $table) {
            $table->integer('residual_probabilitas')->nullable()->after('catatan');
            $table->integer('residual_impact')->nullable()->after('residual_probabilitas');
            $table->integer('residual_score')->nullable()->after('residual_impact');
            $table->string('residual_level')->nullable()->after('residual_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_monitoring', function (Blueprint $table) {
            $table->dropColumn(['residual_probabilitas', 'residual_impact', 'residual_score', 'residual_level']);
        });
    }
};
