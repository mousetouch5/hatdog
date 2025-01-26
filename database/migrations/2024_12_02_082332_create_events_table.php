<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('eventName'); // Event Name
            $table->text('eventDescription'); // Event Description
            $table->date('eventStartDate');
            $table->date('eventEndDate'); // Event Date
            $table->time('eventTime');
            $table->string('eventImage')->nullable(); // Event Image (nullable if not provided)
            $table->decimal('budget', 10, 2);
            $table->string('reciept')->nullable();
            $table->enum('eventStatus', ['ongoing', 'done', 'upcoming']);
            $table->decimal('eventSpent', 10, 2)->nullable(); // Event Budget (nullable, with 2 decimal places)
            $table->string('organizer')->nullable(); // Event Organizer (nullable if not provided)
            $table->string('eventLocation')->nullable(); // Event Location (nullable if not provided)
            $table->enum('eventType', ['Workshop', 'Conference', 'Seminar', 'Community Outreach']); // Event Type as ENUM
            $table->enum('type', ['Event', 'Project']);
            
            // Foreign key to the users table
            $table->unsignedBigInteger('user_id'); // Reference to the users table
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Add foreign key with cascading delete
            
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
