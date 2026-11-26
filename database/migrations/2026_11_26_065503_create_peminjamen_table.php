<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('sarana_id')->nullable()->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('prasarana_id')->nullable()->constrained('prasarana')->cascadeOnDelete();
            $table->string('peminjam', 100);
            $table->string('keperluan');
            $table->unsignedInteger('jumlah')->default(1);
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_rencana_kembali');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->string('status', 20)->default('dipinjam');
            $table->string('kondisi_kembali', 20)->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};