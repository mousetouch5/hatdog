<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        $events = Event::all();     
        return view('Resident.dashboard',compact('events'));
    }
    
    public function getOfficials()
    {
    $officials = User::whereIn('position', ['Barangay Captain', 'Barangay Secretary', 'Barangay Treasurer'])
        ->where('is_approved', 1)
        ->get()
        ->map(function ($official) {
            $official->profile_photo_path = $official->profile_photo_path 
                ? asset($official->profile_photo_path) 
                : 'https://via.placeholder.com/40';
            return $official;
        });

    return response()->json($officials);
    }


public function getUnconfirmedSchedules()
{
    $user = Auth::user(); // Get the currently authenticated user

    // Fetch unconfirmed transactions where 'recieve_by' matches the authenticated user
    $unconfirmedTransactions = Transaction::where('is_approved', 0)
        ->where('recieve_by', $user->id) // Filter transactions by the 'recieve_by' field
        ->with('recieveBy') // Eager load the user associated with the transaction
        ->get();

    // Get the count of unconfirmed transactions for the authenticated user
    $unconfirmedCount = $unconfirmedTransactions->count();

    // Format created_at data and send notifications to the user
    $formattedCreatedAt = $unconfirmedTransactions->map(function ($transaction) {
        $recieveBy = $transaction->recieveBy; // Get the associated user via recieveBy relation

        // Format the created_at date
        $transaction->created_at = $transaction->created_at->format('Y-m-d H:i:s'); // Ensure it's a Carbon instance

        return [
            'recieveBy' => $recieveBy->name, // Return user information
            'created_at' => $transaction->created_at
        ];
    });

    // Return the count along with formatted created_at times and user info
    return response()->json([
        'unconfirmed_count' => $unconfirmedCount,
        'transactions' => $formattedCreatedAt
    ]);
}







public function unconfirmed()
{
    // Fetch unconfirmed transactions and eager load the 'authorizeOfficial' relationship
    $transactions = Transaction::where('is_approved', 0)
        ->with('authorizeOfficial')  // Eager load the 'authorizeOfficial' relationship
        ->get();
/*
        $transactions->transform(function ($transactions) {
        if ($transactions->reciept) {
            // Remove leading slash and correct the path to public/resources/id_pictures
            $relativePath = ltrim($transactions->reciept, '/');
            $transactions->reciept = asset($relativePath);
        } else {
            $transactions->reciept = null;
        }
        return $transactions;
    });

    */



    return response()->json($transactions);
}


// In your TransactionController.php
public function approve($id)
{
    $transaction = Transaction::findOrFail($id);
    $transaction->is_approved = 1;
    $transaction->save();

    return response()->json(['success' => true, 'message' => 'Transaction approved']);
}

public function reject($id)
{
    // Log the attempt to reject the transaction
    Log::info("Attempting to reject transaction with ID: {$id}");

    $transaction = Transaction::find($id);  // Find the transaction by ID

    if (!$transaction) {
        Log::warning("Transaction with ID {$id} not found.");  // Log a warning if the transaction doesn't exist
        return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
    }

    // Log the transaction found
    Log::info("Transaction with ID {$id} found. Proceeding to delete.");

    $transaction->delete();  // Delete the transaction

    // Log the successful deletion
    Log::info("Transaction with ID {$id} has been rejected and deleted.");

    return response()->json(['success' => true, 'message' => 'Transaction rejected']);
}




}