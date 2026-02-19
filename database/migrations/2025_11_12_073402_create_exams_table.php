<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel subjects
            $table->foreignId('subject_id')
                ->constrained()
                ->onDelete('cascade');

            // relasi ke tabel users (guru)
            $table->foreignId('teacher_id')
                ->constrained('users')
                ->onDelete('cascade');

            // data utama ujian
            $table->string('title');
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
