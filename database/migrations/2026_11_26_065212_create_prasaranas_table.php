<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prasarana', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruang', 20)->unique();
            $table->string('nama_ruang', 150);
            $table->string('jenis', 50);
            $table->decimal('luas', 8, 2)->nullable();
            $table->unsignedInteger('kapasitas')->nullable();
            $table->unsignedSmallInteger('tahun_bangun')->nullable();
            $table->string('kondisi', 20)->default('baik');
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prasarana');
    }
};