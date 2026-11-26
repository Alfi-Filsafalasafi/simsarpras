<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarana_id')->nullable()->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('prasarana_id')->nullable()->constrained('prasarana')->cascadeOnDelete();
            $table->string('kegiatan', 150);
            $table->unsignedSmallInteger('interval_bulan')->default(6);
            $table->date('tanggal_terakhir')->nullable();
            $table->date('tanggal_berikutnya');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemeliharaan');
    }
};