<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fabric_stocks', function (Blueprint $table) {
            $table->string('quality_code')->nullable()->unique()->after('quality_name');
        });

        DB::table('fabric_stocks')->orderBy('id')->get(['id'])->each(function (object $fabric): void {
            DB::table('fabric_stocks')->where('id', $fabric->id)->update([
                'quality_code' => 'FAB-'.str_pad((string) $fabric->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fabric_stocks', function (Blueprint $table) {
            $table->dropUnique(['quality_code']);
            $table->dropColumn('quality_code');
        });
    }
};
