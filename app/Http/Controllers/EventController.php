<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class EventController extends Controller
{
    // Display a listing of events

    // In your EventController or relevant controller
    public function getUpcomingEvents()
    {
    $events = Event::where('user_id', Auth::id()) // Ensure the event is for the logged-in user
                    ->where('eventEndDate', '>', now()) // Ensure event is still ongoing
                    ->whereRaw('DATEDIFF(eventEndDate, ?) <= 7', [now()]) // Events ending within the next 7 days
                    ->get();

    return response()->json($events);
    }





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
   $total_expense = $event->expenses->sum(function ($expense) {
    return $expense->expense_amount * $expense->quantity_amount;
    });

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



/*


public function updateExpense(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'event_id' => 'required|integer',
        'expenses' => 'required|array',
        'expenses.*' => 'required|string|max:255',
        'expense_amount_raw' => 'required|array',
        'expense_amount_raw.*' => 'required|numeric|min:0',
        'expense_date' => 'required|array',
        'expense_date.*' => 'required|date',
        'expense_time' => 'required|array',
        'expense_time.*' => 'required|date_format:H:i',
        'quantity_amount' => 'required|array',
        'quantity_amount.*' => 'required|integer|min:1',
    ]);

    // Log the request data for debugging
    \Log::info('Incoming request data:', $request->all());

    // Check if validation fails
    if ($validator->fails()) {
        \Log::error('Validation failed:', $validator->errors()->toArray());
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Extract validated data
    $expenses = $request->input('expenses', []);
    $expenseAmounts = $request->input('expense_amount_raw', []);
    $expenseDates = $request->input('expense_date', []);
    $expenseTimes = $request->input('expense_time', []);
    $quantities = $request->input('quantity_amount', []);

    // Log the extracted data
    \Log::info('Validated data extracted:', [
        'expenses' => $expenses,
        'expenseAmounts' => $expenseAmounts,
        'expenseDates' => $expenseDates,
        'expenseTimes' => $expenseTimes,
        'quantities' => $quantities,
    ]);

    try {
        // Iterate through the expenses and save them to the database
        foreach ($expenses as $index => $description) {
            // Log each expense before creating
            \Log::info('Creating expense entry:', [
                'event_id' => $request->event_id,
                'expense_description' => $description,
                'expense_amount' => $expenseAmounts[$index],
                'expense_date' => $expenseDates[$index],
                'expense_time' => $expenseTimes[$index],
                'quantity_amount' => $quantities[$index],
            ]);

            // Create the expense entry in the database
            Expense::create([
                'event_id' => $request->event_id,
                'expense_description' => $description,
                'expense_amount' => $expenseAmounts[$index],
                'expense_date' => $expenseDates[$index],
                'expense_time' => $expenseTimes[$index],
                'quantity_amount' => $quantities[$index],
            ]);
        }

        // Log success message
        \Log::info('Expenses updated successfully.');

        return response()->json(['message' => 'Expenses updated successfully.']);
        
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error updating expenses: ' . $e->getMessage());

        return response()->json(['error' => 'There was an error updating the expenses.'], 500);
    }
}


*/

public function updateExpense(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'event_id' => 'required|integer|exists:events,id', // Ensure event exists
        'reciept' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,txt|max:2048',
        'expenses' => 'nullable|array',
        'expenses.*' => 'nullable|string|max:255', // Each expense description must be a string
        'expense_amount_raw' => 'nullable|array',
        'expense_amount_raw.*' => 'nullable|numeric|min:0', // Each amount must be numeric and >= 0
        'expense_date' => 'nullable|array',
        'expense_date.*' => 'nullable|date', // Each date must be a valid date
        'expense_time' => 'nullable|array',
        'expense_time.*' => 'nullable|date_format:H:i', // Each time must follow HH:mm format
        'quantity_amount' => 'nullable|array',
        'quantity_amount.*' => 'nullable|integer|min:1', // Each quantity must be an integer >= 1
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Extract validated data
    $validated = $validator->validated();
    $eventId = $validated['event_id'];
    $expenses = $validated['expenses'] ?? [];
    $expenseAmounts = $validated['expense_amount_raw'] ?? [];
    $expenseDates = $validated['expense_date'] ?? [];
    $expenseTimes = $validated['expense_time'] ?? [];
    $quantities = $validated['quantity_amount'] ?? [];

    // Check if expenses are null or empty (based on expense_description)
    $isExpensesNull = empty(array_filter($expenses, fn($description) => !is_null($description)));

    // Check if receipt is provided
    $hasReceipt = $request->hasFile('reciept');

    // Handle the four scenarios
    if (!$hasReceipt && $isExpensesNull) {
        return response()->json(['error' => 'Both receipt and expenses are missing.'], 422);
    }

    try {
        \DB::beginTransaction();

        // Process receipt only if provided
        if ($hasReceipt) {
            $file = $request->file('reciept');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/receipts'), $filename);
            $receiptPath = 'receipts/' . $filename;

            // Update the event record with the receipt path
            Event::where('id', $eventId)->update(['reciept' => $receiptPath]);
        }

        // Process expenses only if they are provided and not null
        if (!$isExpensesNull) {
            foreach ($expenses as $index => $description) {
                Expense::create([
                    'event_id' => $eventId,
                    'expense_description' => $description,
                    'expense_amount' => $expenseAmounts[$index] ?? 0,
                    'expense_date' => $expenseDates[$index] ?? now()->toDateString(),
                    'expense_time' => $expenseTimes[$index] ?? now()->format('H:i'),
                    'quantity_amount' => $quantities[$index] ?? 1,
                ]);
            }
        }

        \DB::commit();

        return response()->json(['message' => 'Expenses updated successfully.'], 200);

    } catch (\Exception $e) {
        \DB::rollBack();

        \Log::error('Error updating expenses:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all(),
        ]);

        return response()->json(['error' => 'There was an error updating the expenses.'], 500);
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
        'eventEndDate' => 'required|date|after_or_equal:eventStartDate',
        'eventImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'reciept' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,txt|max:2048',
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

    // Determine the event status based on the event end date
    $eventStatus = now()->startOfDay()->greaterThan(Carbon::parse($validated['eventEndDate'])->startOfDay()) 
    ? 'done' 
        : (now()->startOfDay()->lessThan(Carbon::parse($validated['eventStartDate'])->startOfDay()) 
        ? 'upcoming' 
        : 'ongoing');


    // Handle the image upload if there is one
    $imagePath = null;
    if ($request->hasFile('eventImage')) {
        $file = $request->file('eventImage');
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move(public_path('storage/event_images'), $filename);
        $imagePath = 'event_images/' . $filename;
        Log::info('Event image uploaded', ['image_path' => $imagePath]);
    } else {
        Log::info('No event image uploaded.');
    }

$receiptPath = null;
if ($request->hasFile('reciept')) {
    $file = $request->file('reciept');
    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    $file->move(public_path('storage/reciept'), $filename);
    $receiptPath = 'reciept/' . $filename;
    Log::info('Event receipt uploaded', ['reciept_path' => $receiptPath]);
} else {
    Log::info('No event receipt uploaded.');
}


    // Create the new event in the database
    $event = Event::create([
        'eventName' => $validated['eventName'],
        'eventDescription' => $validated['eventDescription'],
        'eventStartDate' => $validated['eventStartDate'],
        'eventEndDate' => $validated['eventEndDate'],
        'eventImage' => $imagePath,
        'reciept' => $receiptPath,
        'budget' => $validated['budget'],
        'organizer' => $validated['organizer'],
        'eventLocation' => $validated['eventLocation'],
        'eventType' => $validated['eventType'],
        'eventSpent' => $validated['eventSpent'],
        'eventTime' => $validated['eventTime'],
        'eventStatus' => $eventStatus,
        'type' => $validated['type'],
        'user_id' => Auth::id(),
    ]);

    // Process expenses if provided
$expenses = $request->input('expenses', []);
$expenseAmounts = $request->input('expense_amount_raw', []);
$expenseDates = $request->input('expense_date', []);
$expenseTimes = $request->input('expense_time', []);
$quantity = $request->input('quantity_amount', []);

foreach ($expenses as $index => $description) {
    if ($description && isset($expenseAmounts[$index]) && isset($expenseDates[$index]) && isset($expenseTimes[$index])) {
        Expense::create([
            'event_id' => $event->id,
            'expense_description' => $description,
            'expense_amount' => $expenseAmounts[$index],
            'expense_date' => $expenseDates[$index],
            'expense_time' => $expenseTimes[$index],
            'quantity_amount' => $quantity[$index] ?? 1, // Default to 1 if not provided
        ]);
    }
}

    // Log the successful creation of the event
    Log::info('Event created successfully', ['event_id' => $event->id]);

    // Redirect back with a success message
    return redirect()->route('Official.OfficialDashboard.index')->with('success', 'Event created successfully!');
}

















/*

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



*/
}
