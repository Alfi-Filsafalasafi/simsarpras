<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarana_id')->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('lokasi_asal_id')->nullable()->constrained('prasarana')->nullOnDelete();
            $table->foreignId('lokasi_tujuan_id')->constrained('prasarana')->restrictOnDelete();
            $table->date('tanggal');
            $table->text('alasan');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_aset');
    }
};