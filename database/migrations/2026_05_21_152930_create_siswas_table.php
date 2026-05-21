<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke tabel kelas
            $table->foreignId('kelas_id')
                ->constrained('kelas')        // referensi ke tabel kelas
                ->onDelete('restrict');        // cegah hapus kelas jika masih ada siswa

            $table->string('nis', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->year('tahun_masuk');
            $table->enum('status', ['aktif', 'pindah', 'lulus', 'dropout'])
                ->default('aktif');
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
