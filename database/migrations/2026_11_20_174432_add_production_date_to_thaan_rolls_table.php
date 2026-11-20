<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thaan_rolls', function (Blueprint $table) {
            $table->date('production_date')->nullable()->after('checked_on');
        });

        DB::table('thaan_rolls')->whereNull('production_date')->update([
            'production_date' => DB::raw('checked_on'),
        ]);
    }

    public function down(): void
    {
        Schema::table('thaan_rolls', function (Blueprint $table) {
            $table->dropColumn('production_date');
        });
    }
};
