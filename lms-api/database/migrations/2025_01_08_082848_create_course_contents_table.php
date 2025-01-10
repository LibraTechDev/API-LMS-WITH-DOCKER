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
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->comment('Judul Konten');
            $table->text('description')->comment('Deskripsi');
            $table->string('video_url', 200)->nullable()->comment('URL Video');
            $table->string('file_attachment')->nullable()->comment('File');
            $table->foreignId('course_id')->comment('Matkul')
                  ->constrained('courses')
                  ->restrictOnDelete();
            $table->foreignId('parent_id')->nullable()->comment('Induk')
                  ->constrained('course_contents')
                  ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};