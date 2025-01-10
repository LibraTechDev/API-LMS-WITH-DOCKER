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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null')->comment('Kategori Kursus');
            $table->string('name');
            $table->text('url');
            $table->text('description');
            $table->integer('price');
            $table->string('image')->nullable();
            $table->foreignId('teacher_id')->constrained('users')->restrictOnDelete();
            $table->integer('max_students')->nullable()->comment('Jumlah maksimal siswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};