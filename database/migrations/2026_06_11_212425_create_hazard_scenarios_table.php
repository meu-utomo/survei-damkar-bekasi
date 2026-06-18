<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hazard_scenarios', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['pemadam', 'rescue', 'umum', 'taktis', 'administrasi', 'tambahan']);

            // Kolom Kunci untuk Menyaring Soal per Kelompok Responden
            $table->enum('target_group', ['pasukan', 'komandan', 'manajemen', 'umum'])
                ->default('umum')
                ->comment('Menentukan kelompok responden mana yang wajib menjawab kuesioner ini');

            $table->string('title');
            $table->text('description');
            $table->boolean('is_approved')->default(true);

            $table->foreignId('created_by_respondent_id')
                ->nullable()
                ->constrained('respondents')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_scenarios');
    }
};
