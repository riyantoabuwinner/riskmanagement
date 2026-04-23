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
        Schema::table('risks', function (Blueprint $table) {
            $table->foreignId('performance_indicator_id')->nullable()->after('kategori_id')->constrained('performance_indicators')->nullOnDelete();
        });

        // Sync existing data
        $risks = \Illuminate\Support\Facades\DB::table('risks')->get();
        $indicators = \Illuminate\Support\Facades\DB::table('performance_indicators')->get();

        foreach ($risks as $risk) {
            if ($risk->sasaran_strategis) {
                // Try to find indicator code in sasaran_strategis (e.g., "[PROTAS-1]")
                foreach ($indicators as $indicator) {
                    if (str_contains($risk->sasaran_strategis, $indicator->code)) {
                        \Illuminate\Support\Facades\DB::table('risks')
                            ->where('id', $risk->id)
                            ->update(['performance_indicator_id' => $indicator->id]);
                        break;
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropForeign(['performance_indicator_id']);
            $table->dropColumn('performance_indicator_id');
        });
    }
};
