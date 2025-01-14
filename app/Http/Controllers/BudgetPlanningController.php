<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Budget;
use Carbon\Carbon; // Make sure to include Carbon for date manipulation
//use App\Models\Budget;



class BudgetPlanningController extends Controller
{   
public function index() {
    $currentYear = Carbon::now()->year;

    // List of committee names
    $committees = [
        'Committee Chair on Barangay Affairs & Environment',
        'Committee Chair on Education',
        'Committee Chair Peace & Order',
        'Committee Chair on Laws & Good Governance',
        'Committee Chair on Elderly, PWD/VAWC',
        'Committee Chair on Health & Sanitation/ Nutrition',
        'Committee Chair on Livelihood',
        'Committee Chair Infrastructure & Finance',
    ];

    // List of models that correspond to the committees
    $Models = [
        'CommitteeBarangayAffairsEnvironment',
        'CommitteeEducation',
        'CommitteePeaceOrder',
        'CommitteeLawsGoodGovernance',
        'CommitteeElderlyPwdVawc',
        'CommitteeHealthSanitationNutrition',
        'CommitteeLivelihood',
        'CommitteeInfrastructureFinance',
    ];

    $committeesData = [];

     $totalBudget = Budget::where('year', $currentYear)->first();
    //tech debt  
    // it works pero daw 
    foreach ($Models as $index => $committee) {
        // Dynamically create the committee model class
        $committeeClass = "App\Models\\" . str_replace(' ', '', str_replace('&', 'And', $committee));  // Normalize committee names for class names

        // Check if the committee class exists
        if (class_exists($committeeClass)) {
            // Get the most recent record for the committee for the current year
            $committeeRecord = $committeeClass::where('year', $currentYear)
                                                ->orderBy('updated_at', 'desc')
                                                ->first();

            // If a record exists, get its budget and remaining_budget
            if ($committeeRecord) {
                $committeesData[] = [
                    'committee_name' => $committees[$index], // Store the original committee name
                    'budget' => $committeeRecord->budget,
                    'remaining_budget' => $committeeRecord->remaining_budget
                ];
            } else {
                // If no record exists, add default values
                $committeesData[] = [
                    'committee_name' => $committees[$index], // Store the original committee name
                    'budget' => 0,
                    'remaining_budget' => 0
                ];
            }
        }
    }

    // Return the view with committee names and data
    return view('Official.BudgetPlanning', compact('committeesData', 'currentYear', 'totalBudget'));
}



    public function edits() {
        return view('Official.BudgetPlanningEdit');
    }


public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
            // Add unique constraint for the year in the budgets table
            Rule::unique('budget_table', 'year'),
        ],
        'yearly_budget' => 'required|numeric|min:0',
    ]);

    // Save data to the database
    $budget = Budget::create([
        'year' => $request->input('year'),
        'amount' => $request->input('yearly_budget'),
    ]);

    $amount = $request->input('yearly_budget');
    
    // Calculate the equal share for each committee (assuming 8 committees)
    $value = $amount / 8;

    // Assuming the user is authenticated, we can get the authenticated user's ID
    $userId = auth()->id();

    // Create records for each committee
    $committees = [
        'CommitteeBarangayAffairsEnvironment',
        'CommitteeEducation',
        'CommitteePeaceOrder',
        'CommitteeLawsGoodGovernance',
        'CommitteeElderlyPwdVawc',
        'CommitteeHealthSanitationNutrition',
        'CommitteeLivelihood',
        'CommitteeInfrastructureFinance',
    ];

    foreach ($committees as $committee) {
        // Dynamically create the committee record
        $committeeClass = "App\Models\\$committee"; // Adjust the namespace according to your application
        $committeeClass::create([
            'year' => $request->input('year'),
            'budget' => $value,
            'remaining_budget' => $value,
            'user_id' => $userId,  // Assuming you want to assign the current authenticated user
        ]);
    }
    // Redirect or return a response
  return redirect()->route('Official.BudgetPlanning.index')->with('success', 'Budget added successfully!');



}
}
