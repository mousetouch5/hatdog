<?php

// database/migrations/xxxx_xx_xx_create_survey_responses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponsesTable extends Migration
{
    public function up()
    {
    Schema::create('survey_responses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->unique(); // Assuming the users table exists
    $table->enum('participation', ['never', 'rarely', 'sometimes', 'often', 'always']);
    $table->json('event_types')->nullable();
    $table->json('event_info')->nullable();
    $table->json('impact')->nullable();
    $table->timestamps();
    });

    }

    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}
