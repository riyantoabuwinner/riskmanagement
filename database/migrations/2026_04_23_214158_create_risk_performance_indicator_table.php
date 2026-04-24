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
        Schema::create('risk_performance_indicator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained()->onDelete('cascade');
            $table->foreignId('performance_indicator_id')->constrained('performance_indicators')->onDelete('cascade');
            $table->timestamps();
        });

        // Migrate existing data
        $risks = \Illuminate\Support\Facades\DB::table('risks')->whereNotNull('performance_indicator_id')->get();
        foreach ($risks as $risk) {
            \Illuminate\Support\Facades\DB::table('risk_performance_indicator')->insert([
                'risk_id' => $risk->id,
                'performance_indicator_id' => $risk->performance_indicator_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Remove the old column
        Schema::table('risks', function (Blueprint $table) {
            if (Schema::hasColumn('risks', 'performance_indicator_id')) {
                // Check if foreign key exists before dropping
                try {
                    $table->dropForeign(['performance_indicator_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist or has different name
                }
                $table->dropColumn('performance_indicator_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->foreignId('performance_indicator_id')->nullable()->constrained('performance_indicators');
        });

        // Migrate data back
        $pivots = \Illuminate\Support\Facades\DB::table('risk_performance_indicator')->get();
        foreach ($pivots as $pivot) {
            \Illuminate\Support\Facades\DB::table('risks')
                ->where('id', $pivot->risk_id)
                ->update(['performance_indicator_id' => $pivot->performance_indicator_id]);
        }

        Schema::dropIfExists('risk_performance_indicator');
    }
};
