<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('sarana_id')->nullable()->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('prasarana_id')->nullable()->constrained('prasarana')->cascadeOnDelete();
            $table->text('deskripsi');
            $table->string('urgensi', 20)->default('sedang');
            $table->string('foto')->nullable();
            $table->string('status', 20)->default('dilaporkan');
            $table->string('teknisi', 100)->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};