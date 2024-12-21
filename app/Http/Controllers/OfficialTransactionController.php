<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Log; 
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\PDF; 
class OfficialTransactionController extends Controller

{
public function index()
{
    // Retrieve all events
    $events = Event::all(); 

   $transactions = Transaction::with('authorizeOfficial')->get();

   // $officials = User::select('name', 'position','id')->get();
    $officials = User::whereIn('position', ['Barangay Captain', 'Barangay Secretary', 'Barangay Treasurer'])
        ->where('is_approved', 1)
        ->get();
    // Calculate the sum of te 'eventbudget' column
    $totalBudget = Event::sum('budget');

    $bb = Expense::sum('expense_amount');

    $horse_shit =  $totalBudget - $bb;
    //dd($transactions);
    // Pass both the events and totalBudget to the view
    return view('official.OfficialTransaction', compact('transactions','horse_shit','events','bb', 'totalBudget','officials'));
}



public function getTransactions()
{
    $transactions = Transaction::where('archive', false)  // or 'archive', 0
        ->with(['authorizeOfficial', 'recieveBy'])
        ->get();

    return response()->json($transactions);
}



// Method to get transactions with search functionality
public function search(Request $request)
{
    $query = $request->input('search', '');  // Get the search query from the request, defaults to empty string

    // Check if the query is empty, return an empty array or handle the case accordingly
    if (empty($query)) {
        return response()->json([]);
    }

    $transactions = Transaction::where('authorize_official', 'LIKE', "%$query%")
        ->orWhere('description', 'LIKE', "%$query%")
        ->orWhere('recieve_by', 'LIKE', "%$query%")
        ->get();

    return response()->json($transactions);
}








public function store(Request $request)
{


    $eventNames = Event::pluck('eventName')->toArray();

    // Fetch transactions that do not match event names
    $transactions = Transaction::whereNotIn('description', $eventNames)->get();


    // Log the incoming request data for debugging
    Log::info('Transaction creation requested', $request->all());

    // Validate the incoming request data
    $request->validate([
        'budget' => 'required|numeric',
        'money_spent' => 'required|numeric',
        'recieve_by' => 'required|exists:users,id',
        'date' => 'required|date',
        'description' => [
            'nullable',
            'string',
            'unique:events,eventName', // Ensure 'description' is unique in the 'events' table
        ],
        'reciept' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    Log::info('Validation passed successfully.');

    $imagePath = null;

    // Handle file upload
    if ($request->hasFile('reciept')) {
        $file = $request->file('reciept');

        // Define a custom filename to avoid conflicts
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // Move the file to the public storage path
        $file->move(public_path('storage/reciepts'), $filename);

        // Set the image path for database storage
        $imagePath = 'reciepts/' . $filename;

        Log::info('Event image uploaded', ['image_path' => $imagePath]);
    }

    // Create a new transaction
    $transaction = Transaction::create([
        'budget' => $request->input('budget'),
        'money_spent' => $request->input('money_spent'),
        'recieve_by' => $request->input('recieve_by'),
        'authorize_official' => auth()->user()->id, // Authenticated user ID
        'date' => $request->input('date'),
        'description' => $request->input('description'),
        'reciept' => $imagePath,
    ]);

    Log::info('Transaction created successfully', [
        'transaction_id' => $transaction->id,
        'budget' => $transaction->budget,
        'money_spent' => $transaction->money_spent,
        'reciept' => $transaction->reciept,
    ]);

    // Redirect to a specific route or return a success response
    return redirect()->route('Official.OfficialTransaction.index')->with('success', 'Transaction created successfully.');
}


    public function archive($id)
    {
        // Find the transaction
        $transaction = Transaction::findOrFail($id);

        // Update the archived status (assuming you have an 'is_archived' column in your database)
        $transaction->archive = true;
        $transaction->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Transaction archived successfully!');
    }



/*
public function store(Request $request)
{

    $eventNames = Event::pluck('eventName')->toArray();

    // Fetch transactions that do not match event names
    $transactions = Transaction::whereNotIn('description', $eventNames)->get();



    // Log the incoming request data for debugging purposes
    Log::info('Transaction creation requested', [
        'budget' => $request->input('budget'),
        'money_spent' => $request->input('money_spent'),
        'recieve_by' => $request->input('recieve_by'),
        'authorize_official' => $request->input('authorize_official'),
        'date' => $request->input('date'),
        'description' => $request->input('description'),
        'reciept' => $request->input('reciept'),
    ]);

    // Validate the incoming request data
    $request->validate([
        'budget' => 'required|numeric',
        'money_spent' => 'required|numeric',
        'recieve_by' => 'required|string|max:255',
        'authorize_official' => 'required|exists:users,id',
        'date' => 'required|date',
        'description' => [
            'nullable',
            'string',
            'unique:events,eventName',  // Ensure the description is unique in the Event names
         ],
        'reciept' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Log that validation passed
    Log::info('Validation passed successfully.');

    $imagePath = null;


        if ($request->hasFile('reciept')) {
        // Get the uploaded file
        $file = $request->file('reciept');

        // Define a custom filename (optional)
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // Move the file to the public storage path
        $file->move(public_path('storage/reciepts'), $filename);

        // Set the image path for database storage
        $imagePath = 'reciepts/' . $filename;

        // Log the uploaded image path
        Log::info('Event image uploaded', ['image_path' => $imagePath]);
    } else {
        Log::info('No event image uploaded.');
    }

    // Create a new transaction
    $transaction = Transaction::create([
        'budget' => $request->input('budget'),
        'money_spent' => $request->input('money_spent'),
        'recieve_by' => $request->input('recieve_by'),
        'authorize_official' => $request->input('authorize_official'),
        'date' => $request->input('date'),
        'description' => $request->input('description'),
        'reciept' => $imagePath,

    ]);

    // Log the successful creation of a transaction
    Log::info('Transaction created successfully', [
        'transaction_id' => $transaction->id,
        'budget' => $transaction->budget,
        'money_spent' => $transaction->money_spent,
        'reciept' => $transaction->reciept,
    ]);

    // Redirect to a specific route or return a success response
    return redirect()->route('Official.OfficialTransaction.index'); // Update 'transactions.index' with your actual route
}


*/

public function print($transactionId)
{
    // Retrieve the specific transaction with its related authorize official
    $transaction = Transaction::with('authorizeOfficial')->findOrFail($transactionId);
    //dd($transaction);
    // Return a view with the transaction data for printing
    return view('events.print2', compact('transaction'));
}


public function downloadPDF($transactionId)
{
        $transaction = Transaction::with('authorizeOfficial')->findOrFail($transactionId);
        $pdf = PDF::loadView('events.print3', compact('transaction'));

        return $pdf->download('transaction_' . $transactionId . '.pdf');
}


    public function printAll()
    {
        // Retrieve all transactions
        $transactions = Transaction::with('authorizeOfficial')->get();

        // Option 1: Print All Transactions as HTML
        return view('events.print4', compact('transactions'));

        // Option 2: Print All Transactions as PDF (if you're using dompdf package)
        // $pdf = PDF::loadView('transactions.print_all_pdf', compact('transactions'));
        // return $pdf->download('all_transactions.pdf');
    }



}