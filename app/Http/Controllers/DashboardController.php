<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;
use App\Models\Budget;
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
    try {
        // Find the transaction by ID
        $transaction = Transaction::findOrFail($id);
        Log::info('Transaction found: ' . $transaction);

        // Mark the transaction as approved
        $transaction->is_approved = 1;
        $transaction->save();
        Log::info('Transaction approved: ' . $transaction->id);

        // Define the committees and corresponding model classes
        $committees = [
            'Committee Chair Infrastructure & Finance',
            'Committee Chair on Barangay Affairs & Environment',
            'Committee Chair on Education',
            'Committee Chair Peace & Order',
            'Committee Chair on Laws & Good Governance',
            'Committee Chair on Elderly, PWD/VAWC',
            'Committee Chair on Health & Sanitation/ Nutrition',
            'Committee Chair on Livelihood'
        ];

        $models = [
            'CommitteeInfrastructureFinance',
            'CommitteeBarangayAffairsEnvironment',
            'CommitteeEducation',
            'CommitteePeaceOrder',
            'CommitteeLawsGoodGovernance',
            'CommitteeElderlyPwdVawc',
            'CommitteeHealthSanitationNutrition',
            'CommitteeLivelihood',
        ];

        // Get the 'received_by' user from the transaction
        $userId = $transaction->recieve_by; // Assuming 'received_by' is the user ID
        Log::info('Received by user ID: ' . $userId);

        // Fetch the committee assigned to the user
        $userCommittee = User::where('id', $userId)->value('comittee');
        Log::info('User committee: ' . $userCommittee);

        // Find the committee's index
        $committeeIndex = array_search($userCommittee, $committees);

        if ($committeeIndex === false) {
            Log::error('Committee not found for user: ' . $userId);
            return response()->json(['success' => false, 'message' => 'Committee not found'], 404);
        }

        // Dynamically get the model class corresponding to the user's committee
        $modelClass = "App\\Models\\" . $models[$committeeIndex];
        Log::info('Model class: ' . $modelClass);

        // Get the budget from the model for the committee
        $budgetRecord = (new $modelClass)->latest('updated_at')->first();
        Log::info('Budget record found: ' . ($budgetRecord ? 'Yes' : 'No'));

        if (!$budgetRecord) {
            Log::error('Budget record not found for user ID: ' . $userId);
            return response()->json(['success' => false, 'message' => 'Budget record not found'], 404);
        }

        // Get the current budget and remaining budget
        $constBudget = $budgetRecord->budget;
        $budget = $budgetRecord->remaining_budget;
        $remainingBudget = $budgetRecord->remaining_budget;

        // Get the amount from the transaction
        $amount = $transaction->budget;
        Log::info('Transaction amount: ' . $amount);

        // Calculate the new remaining budget
        $newRemainingBudget = $remainingBudget - $amount;
        Log::info('New remaining budget: ' . $newRemainingBudget);

        // Check if the new remaining budget is less than zero
        if ($newRemainingBudget < 0) {
    // Prevent further action or return an error message
        Log::warning('Budget cannot go below zero. Action denied.');
    // You can also return a response or throw an exception if needed
        return response()->json(['error' => 'Insufficient funds'], 400);
        } else {
        Log::info('New remaining budget: ' . $newRemainingBudget);
         }

        // Update the committee's budget record
        $newBudgetRecord = $modelClass::create([
            'budget' => $constBudget,
            'remaining_budget' => $newRemainingBudget,
            'expenses' => $amount,
            'user_id' => $userId,
            'year' => date('Y'), // Get the current year
        ]);
        Log::info('Budget record updated for user ID: ' . $userId);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Transaction approved and budget updated']);
    } catch (\Exception $e) {
        Log::error('Error in approving transaction: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
    }
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