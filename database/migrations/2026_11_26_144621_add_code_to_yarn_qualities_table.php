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
        Schema::table('yarn_qualities', function (Blueprint $table): void {
            $table->string('code', 50)->nullable()->unique()->after('name');
        });

        DB::table('yarn_qualities')->orderBy('id')->get(['id'])->each(function (object $quality): void {
            DB::table('yarn_qualities')->where('id', $quality->id)->update([
                'code' => 'YRN-'.str_pad((string) $quality->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yarn_qualities', function (Blueprint $table): void {
            $table->dropUnique(['code']);
            $table->dropColumn('code');
        });
    }
};
