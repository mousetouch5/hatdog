<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteeTables extends Migration
{
    public function up()
    {
        // Committee Chair Infrastructure & Finance
        Schema::create('committee_infrastructure_finance', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2); // Adjust precision as needed
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users'); // Assuming you have a 'users' table
            $table->timestamps();
        });

        // Committee Chair on Barangay Affairs & Environment
        Schema::create('committee_barangay_affairs_environment', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair on Education
        Schema::create('committee_education', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair Peace & Order
        Schema::create('committee_peace_order', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair on Laws & Good Governance
        Schema::create('committee_laws_good_governance', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair on Elderly, PWD/VAWC
        Schema::create('committee_elderly_pwd_vawc', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair on Health & Sanitation/ Nutrition
        Schema::create('committee_health_sanitation_nutrition', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Committee Chair on Livelihood
        Schema::create('committee_livelihood', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->year('year');
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('expenses', 10, 2)->nullable(); ;
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('committee_infrastructure_finance');
        Schema::dropIfExists('committee_barangay_affairs_environment');
        Schema::dropIfExists('committee_education');
        Schema::dropIfExists('committee_peace_order');
        Schema::dropIfExists('committee_laws_good_governance');
        Schema::dropIfExists('committee_elderly_pwd_vawc');
        Schema::dropIfExists('committee_health_sanitation_nutrition');
        Schema::dropIfExists('committee_livelihood');
    }
}
