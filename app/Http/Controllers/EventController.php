<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon;

class EventController extends Controller
{
    // Display a listing of events
    public function index()
    {
    $user = Auth::user(); // Get the currently authenticated user

    // Fetch events and map over them to include userId
    $events = Event::with('expenses')
        ->where('type', 'Event')
        ->get()
        ->map(function($event) use ($user) {
            // Add the userId to each event object
            $event->userId = $user->id;

            // Optionally, you can add more logic here for event categories, etc.
            return $event;
        });
    $totalAmount = $events->flatMap(function ($event) {
        return $event->expenses;
    })->sum('expense_amount');


        
        // Pass the events to the view for display
        return view('Resident.Event', compact('events','totalAmount')); // Assuming your view is 'Resident.Event'
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







    public function updateExpense(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'expenses.*' => 'required|string',
            'expense_amount.*' => 'required|numeric',
            'expense_date.*' => 'required|date',
            'expense_time.*' => 'required|date_format:H:i',
            'event_id' => 'required|integer'
        ]);

        // Process the expenses
        try {
            foreach ($request->expenses as $index => $expenseDescription) {
                Expense::create([
                    'event_id' => $request->event_id,
                    'expense_description' => $expenseDescription,
                    'expense_amount' => $request->expense_amount[$index],
                    'expense_date' => $request->expense_date[$index],
                    'expense_time' => $request->expense_time[$index],
                ]);
            }

            return response()->json(['message' => 'Expenses updated successfully.']);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error updating expenses: ' . $e->getMessage());

            return response()->json(['error' => 'There was an error updating the expenses.'], 500);
        }
    }


















    public function storeEvents(Request $request)
{
    // Log the incoming request data
    Log::info('Storing a new event', ['data' => $request->all()]);

    // Validate the incoming request data
    $validated = $request->validate([
        'eventStatus' => 'required|string',
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
        'type' => 'required|string',
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
        'eventStatus' =>$validated['eventStatus'],
        'type' => $validated['type'],
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
    return redirect()->route('Official.OfficialDashboard.index')->with('success', 'Event created successfully!');
}




}
