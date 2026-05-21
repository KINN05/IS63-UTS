<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke tabel siswas
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->onDelete('cascade'); // jika siswa dihapus, nilai ikut terhapus

            $table->string('kode_mapel', 10);
            $table->string('nama_mapel', 100);
            $table->decimal('nilai_angka', 5, 2);
            $table->string('nilai_huruf', 2);
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
