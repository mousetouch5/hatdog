<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class OfficialEventController extends Controller
{
public function index()
{
    // Eager load expenses with their associated events
    $events = Event::where('type', 'Event')->get();
    $expenses = Expense::all()
        ->groupBy('event_id')
        ->map(function ($group) {
            return [
                'id' => $group->first()->event_id, // Get the event_id
                'items' => $group->map(function ($expense) {
                    return [
                        'name' => $expense->expense_description,
                        'date' => Carbon::parse($expense->expense_date)->format('d M h:ia'), // Convert date to Carbon and format
                        'amount' => $expense->expense_amount,
                    ];
                }),
                'total' => $group->sum('expense_amount'), // Calculate the total for the group
            ];
        });

    //dd($expenses); // This will dump the expenses along with their related event details
    
    return view('official.OfficialEvent', compact('events','expenses'));
}

    public function getEvents(Request $request)
    {

        $events = Event::all();
        // Return the events as JSON
        return response()->json($events);
    }

    public function getExpenses(Request $request)
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }







    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Storing a new event', ['data' => $request->all()]);
    
        // Validate the incoming request data
        $validated = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDescription' => 'required|string',
            'eventStartDate' => 'required|date',
            'eventEndDate' => 'required|date|after_or_equal:eventStartDate',
            'eventImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'budget' => 'required|numeric',
            'organizer' => 'nullable|string|max:255',
            'eventLocation' => 'nullable|string|max:255',
            'eventTime' => 'required|date_format:H:i',
            'eventSpent' => 'required|numeric',
            'eventType' => 'required|in:Workshop,Conference,Seminar,Community Outreach',
            'eventStatus' => 'required|string|max:255',
        ]);
    
        // Log the validated data
        Log::info('Validated event data', ['validated_data' => $validated]);
    
        // Initialize image path variable
        $imagePath = null;
    
        // Handle the image upload if there is one
        if ($request->hasFile('eventImage')) {
            // Get the uploaded file
            $file = $request->file('eventImage');
    
            // Define a custom filename (optional)
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    
            // Move the file to the public storage path
            $file->move(public_path('storage/event_images'), $filename);
    
            // Set the image path for database storage
            $imagePath = 'event_images/' . $filename;
    
            // Log the uploaded image path
            Log::info('Event image uploaded', ['image_path' => $imagePath]);
        } else {
            Log::info('No event image uploaded.');
        }
    
        // Create the new event in the database
        $event = Event::create([
            'eventName' => $validated['eventName'],
            'eventDescription' => $validated['eventDescription'],
            'eventStartDate' => $validated['eventStartDate'],
            'eventEndDate' => $validated['eventEndDate'],
            'eventImage' => $imagePath,
            'budget' => $validated['budget'],
            'organizer' => $validated['organizer'],
            'eventLocation' => $validated['eventLocation'],
            'eventType' => $validated['eventType'],
            'eventSpent' => $validated['eventSpent'],
            'eventTime' => $validated['eventTime'],
            'eventStatus' =>$validated['eventStatus'],
        ]);
    
    
            $expenses = $request->input('expenses', []);
            $expenseAmounts = $request->input('expense_amount', []);
            $expenseDates = $request->input('expense_date', []);
            $expenseTimes = $request->input('expense_time', []);
    
          foreach ($expenses as $index => $description) {
            if ($description && isset($expenseAmounts[$index]) && isset($expenseDates[$index]) && isset($expenseTimes[$index])) {
                // Create expense records
                Expense::create([
                    'event_id' => $event->id,
                    'expense_description' => $description,
                    'expense_amount' => $expenseAmounts[$index],
                    'expense_date' => $expenseDates[$index],
                    'expense_time' => $expenseTimes[$index],
                ]);
            }
        }
    
    
    
        // Log the successful creation of the event
        Log::info('Event created successfully', ['event_id' => $event->id]);
    
        // Redirect back with a success message
        return redirect()->route('Official.OfficialEvent.index')->with('success', 'Event created successfully!');
    }
    
    
    




        

}
