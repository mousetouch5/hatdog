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
        Schema::create('fake_expense', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('event_id')->constrained('fake_events')->onDelete('cascade'); // Foreign key reference to the events table
            $table->string('expense_description');  // Description of the expense
            $table->string('expense_category'); 
            $table->decimal('expense_amount', 10, 2);  // Amount of the expense
            $table->decimal('quantity_amount',10, 2);
            $table->timestamps();  // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_expense');
    }
};
