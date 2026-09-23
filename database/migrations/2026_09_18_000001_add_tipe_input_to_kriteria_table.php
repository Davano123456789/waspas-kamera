<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->enum('tipe_input', ['pilihan', 'rentang'])->default('pilihan')->after('atribut');
        });
    }

    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropColumn('tipe_input');
        });
    }
};
