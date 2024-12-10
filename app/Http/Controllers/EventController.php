<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon;
class EventController extends Controller
{
    // Display a listing of events
    public function index()
    {
        // Log the retrieval of events
        Log::info('Retrieving all events.');

        // Retrieve all events from the database
        $events = Event::all();
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
        $totalAmount = $events->flatMap(function ($event) {
            return $event->expenses;
        })->sum('expense_amount');


        
        // Pass the events to the view for display
        return view('Resident.Event', compact('events', 'expenses','totalAmount')); // Assuming your view is 'Resident.Event'
    }


public function print(Event $event) {
    // Initialize variables for summary calculations
    $total_event_budget = $event->budget;
    $total_expense = $event->expenses->sum('expense_amount');
    $total_refunded = max(0, $total_expense - $total_event_budget);
    $total_to_be_reimbursed = max(0, $total_event_budget - $total_expense);

    // Get the current date to include in the report
    $date_today = \Carbon\Carbon::now()->format('F d, Y');

    // Pass all necessary data to the view
    return view('events.print', compact('event', 'total_event_budget', 'total_expense', 'total_refunded', 'total_to_be_reimbursed', 'date_today'));
}





public function updateStatus(Request $request, $id)
{
    try {
        $event = Event::findOrFail($id); // Find event by ID
        $event->eventStatus = $request->input('status'); // Update status to 'done'
        $event->save();

        return response()->json(['success' => true, 'message' => 'Event status updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to update event status.']);
    }
}







    public function storeEvents(Request $request)
{
    // Log the incoming request data
    Log::info('Storing a new event', ['data' => $request->all()]);

    // Validate the incoming request data
    $validated = $request->validate([
        'eventName' => 'required|string|max:255',
        'eventDescription' => 'required|string',
        'eventStartDate' => 'required|date',
        'eventEndDate' =>'required|date|after_or_equal:eventStartDate',
        'eventImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'budget' => 'required|numeric',
        'organizer' => 'nullable|string|max:255',
        'eventLocation' => 'nullable|string|max:255',
        'eventTime' => 'required|date_format:H:i',
        'eventSpent' => 'required|numeric',
        'eventType' => 'required|in:Workshop,Conference,Seminar,Community Outreach',
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
