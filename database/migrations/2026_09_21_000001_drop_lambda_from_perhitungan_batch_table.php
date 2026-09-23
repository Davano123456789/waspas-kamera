<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perhitungan_batch', function (Blueprint $table) {
            $table->dropColumn('lambda');
        });
    }

    public function down(): void
    {
        Schema::table('perhitungan_batch', function (Blueprint $table) {
            $table->decimal('lambda', 3, 2)->default(0.5);
        });
    }
};
