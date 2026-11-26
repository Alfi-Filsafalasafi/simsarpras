<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghapusan_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarana_id')->constrained('sarana')->restrictOnDelete();
            $table->string('alasan', 30);
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->string('bukti')->nullable();
            $table->string('status', 20)->default('diajukan');
            $table->string('nomor_berita_acara', 50)->nullable();
            $table->foreignId('diajukan_oleh')->constrained('users')->restrictOnDelete();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghapusan_aset');
    }
};