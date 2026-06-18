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
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->string('name_initial')->nullable()->comment('Inisial nama responden');
            $table->enum('respondent_group', ['pasukan', 'komandan', 'manajemen']);
            $table->enum('employee_status', ['pns', 'pppk']);
            $table->string('class_rank');
            $table->enum('age_group', ['< 25', '25-35', '36-45', '> 45']);
            $table->enum('years_of_service', ['< 2', '2-5', '6-10', '> 10']);
            $table->string('work_unit');
            $table->enum('role_type', ['pemadam', 'rescue', 'keduanya', 'staf']);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};
