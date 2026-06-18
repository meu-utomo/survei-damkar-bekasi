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
        Schema::create('parameter_options', function (Blueprint $table) {
            $table->id();
            $table->enum('parameter_type', ['E', 'P', 'C'])->comment('E = Exposure, P = Probability, C = Consequence');
            $table->decimal('score', 5, 2);
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_options');
    }
};
