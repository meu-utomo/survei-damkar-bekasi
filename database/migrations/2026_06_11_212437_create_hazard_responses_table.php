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
        Schema::create('hazard_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('respondents')->onDelete('cascade');
            $table->foreignId('hazard_scenario_id')->constrained('hazard_scenarios')->onDelete('cascade');
            $table->foreignId('exposure_option_id')->constrained('parameter_options');
            $table->foreignId('probability_option_id')->constrained('parameter_options');
            $table->foreignId('consequence_option_id')->constrained('parameter_options');
            $table->decimal('calculated_risk_score', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_responses');
    }
};
