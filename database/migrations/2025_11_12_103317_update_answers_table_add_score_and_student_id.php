<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            // Ganti user_id jadi student_id kalau mau seragam
            if (Schema::hasColumn('answers', 'user_id')) {
                $table->renameColumn('user_id', 'student_id');
            }

            // Tambahkan kolom score (boleh 0 awalnya)
            if (!Schema::hasColumn('answers', 'score')) {
                $table->integer('score')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            if (Schema::hasColumn('answers', 'score')) {
                $table->dropColumn('score');
            }
            if (Schema::hasColumn('answers', 'student_id')) {
                $table->renameColumn('student_id', 'user_id');
            }
        });
    }
};
