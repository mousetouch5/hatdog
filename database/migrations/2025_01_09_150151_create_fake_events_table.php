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
        Schema::create('fake_events', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('eventName'); // Event Name
            $table->text('eventDescription'); // Event Description
            $table->date('eventStartDate');
            $table->date('eventEndDate'); 
            $table->decimal('budget', 10, 2);
            $table->string('organizer')->nullable(); // Event Organizer (nullable if not provided)
            $table->enum('type', ['Event', 'Project']);
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_events');
    }
};
