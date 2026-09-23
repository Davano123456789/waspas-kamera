<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->decimal('nilai_min', 12, 2)->nullable()->after('nilai');
            $table->decimal('nilai_maks', 12, 2)->nullable()->after('nilai_min');
        });
    }

    public function down(): void
    {
        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->dropColumn(['nilai_min', 'nilai_maks']);
        });
    }
};
