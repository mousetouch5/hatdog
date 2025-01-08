<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event; // Import the Event model
use Carbon\Carbon;
class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Check events and update their status based on start and end dates';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        // Get all events
        $events = Event::all();

        // Loop through events and update the status
        foreach ($events as $event) {
            $currentDate = Carbon::now()->startOfDay();
            $startDate = Carbon::parse($event->eventStartDate)->startOfDay();
            $endDate = Carbon::parse($event->eventEndDate)->startOfDay();

            // Check the status of the event
            if ($currentDate->greaterThan($endDate)) {
                // Event has passed
                $event->eventStatus = 'done';
            } elseif ($currentDate->greaterThanOrEqualTo($startDate) && $currentDate->lessThanOrEqualTo($endDate)) {
                // Event is ongoing
                $event->eventStatus = 'ongoing';
            } elseif ($currentDate->lessThan($startDate)) {
                // Event is upcoming
                $event->eventStatus = 'upcoming';
            }

            // Save the event with the updated status
            $event->save();

            $this->info("Event '{$event->eventName}' status updated to '{$event->eventStatus}'.");
        }
    }
}
