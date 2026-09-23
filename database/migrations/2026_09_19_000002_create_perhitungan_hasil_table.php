<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perhitungan_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('perhitungan_batch')->onDelete('cascade');
            $table->foreignId('kamera_id')->nullable()->constrained('kamera')->onDelete('set null');
            $table->string('kode_kamera');
            $table->string('nama_kamera');
            $table->string('merk')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->double('q1');
            $table->double('q2');
            $table->double('qi');
            $table->unsignedInteger('rank');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perhitungan_hasil');
    }
};
