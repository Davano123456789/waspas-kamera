<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perhitungan_batch', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('kode_batch')->constrained('user')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('perhitungan_batch', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
