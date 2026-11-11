<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('kode_tiket')->unique();
        $table->string('kode_akses')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('category_id')->constrained();
        $table->enum('jenis', ['pengaduan', 'aspirasi']);
        $table->string('judul');
        $table->text('isi');
        $table->boolean('is_anonim')->default(false);
        $table->enum('status', ['diajukan', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('diajukan');
        $table->text('alasan_penolakan')->nullable();
        $table->enum('publish_status', ['tidak_diajukan', 'menunggu', 'tampil', 'ditolak'])->default('tidak_diajukan');
        $table->unsignedTinyInteger('rating')->nullable();
        $table->text('ulasan')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tickets');
}
};
