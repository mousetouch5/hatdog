<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 15, 2); // Budget amount
            $table->decimal('money_spent', 15, 2); // Money spent
            $table->string('recieve_by'); // Person who received
            $table->foreignId('authorize_official') // Foreign key
                  ->constrained('users') // Refers to 'id' in 'users' table
                  ->onDelete('cascade');
            $table->string('reciept');
            $table->date('date'); // Transaction date
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
