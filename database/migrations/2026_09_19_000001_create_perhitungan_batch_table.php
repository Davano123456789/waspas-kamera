<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perhitungan_batch', function (Blueprint $table) {
            $table->id();
            $table->string('kode_batch')->unique();
            $table->decimal('lambda', 3, 2)->default(0.5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perhitungan_batch');
    }
};
