<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FakeController extends Controller
{
    



public function storeEvents(Request $request)
{
    // Log the incoming request data
    Log::info('Storing a new event', ['data' => $request->all()]);

    // Validate the incoming request data
    $validated = $request->validate([
        'eventName' => 'required|string|max:255',
        'eventDescription' => 'required|string',
        'eventStartDate' => 'required|date',
        'eventEndDate' => 'required|date|after_or_equal:eventStartDate',
        'budget' => 'required|numeric',
        'organizer' => 'nullable|string|max:255',   
        'type' => 'required|string',
    ]);

    // Log the validated data
    Log::info('Validated event data', ['validated_data' => $validated]);

    // Create the new event in the database
    $event = Event::create([
        'eventName' => $validated['eventName'],
        'eventDescription' => $validated['eventDescription'],
        'eventStartDate' => $validated['eventStartDate'],
        'eventEndDate' => $validated['eventEndDate'],
        'budget' => $validated['budget'],
        'organizer' => $validated['organizer'],
        'type' => $validated['type'],
    ]);

    // Process expenses if provided
$expenses = $request->input('expenses', []);
$expenseAmounts = $request->input('expense_amount_raw', []);
$quantity = $request->input('quantity_amount', []);
$category = $request->input('category', []);


foreach ($expenses as $index => $description) {
    if ($description && isset($expenseAmounts[$index])  ) {
        FakeExpense::create([
            'event_id' => $event->id,
            'expense_description' => $description,
            'expense_amount' => $expenseAmounts[$index],
            'expense_category' => $category[$index],
            'quantity_amount' => $quantity[$index] ?? 1, // Default to 1 if not provided
        ]);
    }
}

    // Log the successful creation of the event
    Log::info('Event created successfully', ['event_id' => $event->id]);

    // Redirect back with a success message
    return back()->with('success', 'Event created successfully!');

}





}
