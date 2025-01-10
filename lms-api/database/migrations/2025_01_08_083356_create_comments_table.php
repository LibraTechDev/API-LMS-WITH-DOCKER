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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->comment('Course')
                  ->constrained('courses')
                  ->cascadeOnDelete();
            $table->foreignId('content_id')->comment('Konten')
                  ->constrained('course_contents')
                  ->cascadeOnDelete();
            $table->foreignId('member_id')->comment('Pengguna')
                  ->constrained('course_members')
                  ->cascadeOnDelete();
            $table->text('comment')->comment('Komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};