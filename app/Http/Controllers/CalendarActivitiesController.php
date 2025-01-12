<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\FakeEvents;

class CalendarActivitiesController extends Controller
{
public function index() {
    $events = FakeEvents::all();

    // Format events for FullCalendar
$formattedEvents = $events->map(function ($event) {
    // Generate a random color in hex format
    $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

    return [
        'title' => $event->eventName,
        'start' => $event->eventStartDate,
        'end' => $event->eventEndDate,
        'color' => $randomColor, // Assign the random color
    ];
});


    return view('Official.CalendarActivities', [
        'events' => $formattedEvents->toArray(),
    ]);
}
}
