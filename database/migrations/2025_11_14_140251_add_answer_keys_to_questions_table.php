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
    Schema::table('questions', function (Blueprint $table) {
        $table->string('answer_key_pg')->nullable();
        $table->text('answer_key_essay')->nullable();
    });
}

public function down(): void
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropColumn('answer_key_pg');
        $table->dropColumn('answer_key_essay');
    });
}

};
