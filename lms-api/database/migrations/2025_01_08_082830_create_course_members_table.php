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
        Schema::create('course_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->comment('Course')
                  ->constrained('courses')
                  ->restrictOnDelete();
            $table->foreignId('user_id')->comment('Siswa')
                  ->constrained('users')
                  ->restrictOnDelete();
            $table->enum('roles', ['std', 'ast'])->default('std')->comment('Peran');
            $table->timestamps();

            // Mencegah duplikasi user dalam course yang sama
            $table->unique(['course_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_members');
    }
};