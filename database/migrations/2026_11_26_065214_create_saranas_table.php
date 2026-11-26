<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarana', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 30)->unique();
            $table->string('nama_barang', 150);
            $table->foreignId('kategori_id')->constrained('kategoris')->restrictOnDelete();
            $table->foreignId('prasarana_id')->nullable()->constrained('prasarana')->nullOnDelete();
            $table->string('merek', 100)->nullable();
            $table->string('nomor_seri', 100)->nullable();
            $table->unsignedInteger('jumlah')->default(1);
            $table->unsignedSmallInteger('tahun_perolehan')->nullable();
            $table->string('sumber_dana', 50)->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('kondisi', 20)->default('baik');
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana');
    }
};