<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Budget;
use Carbon\Carbon; // Make sure to include Carbon for date manipulation
//use App\Models\Budget;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class BudgetPlanningController extends Controller
{   


public function Total()
{
    // Define the models representing the committees
    $models = [
        'CommitteeBarangayAffairsEnvironment',
        'CommitteeEducation',
        'CommitteePeaceOrder',
        'CommitteeLawsGoodGovernance',
        'CommitteeElderlyPwdVawc',
        'CommitteeHealthSanitationNutrition',
        'CommitteeLivelihood',
        'CommitteeInfrastructureFinance',
    ];

 
    $totalBudgetLeft = 0;

    foreach ($models as $model) {
        $modelClass = "App\\Models\\$model";

        if (class_exists($modelClass)) {
            $latestRecord = $modelClass::orderBy('updated_at', 'desc')->first();
            if ($latestRecord) {
                $totalBudgetLeft += $latestRecord->remaining_budget;
            }
        }
    }

    // Return the results as JSON
    return response()->json(['totalBudgetLeft' => $totalBudgetLeft]);
}
public function editBudget(Request $request)
{
    try {
        Log::info('Starting budget edit process.');

        // Validate the request
        $validated = $request->validate([
            'committee_id' => 'required|string',
            'new_budget' => 'required|numeric|min:0'
        ]);

        Log::info('Request validated.', ['validated_data' => $validated]);

        // Get the committee name and new budget
        $selectedCommittee = $validated['committee_id'];
        $newBudget = $validated['new_budget'];

        // Define committees and their corresponding models
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

        $models = [
            'CommitteeBarangayAffairsEnvironment',
            'CommitteeEducation',
            'CommitteePeaceOrder',
            'CommitteeLawsGoodGovernance',
            'CommitteeElderlyPwdVawc',
            'CommitteeHealthSanitationNutrition',
            'CommitteeLivelihood',
            'CommitteeInfrastructureFinance',
        ];

        // Find the index of the selected committee
        $selectedIndex = array_search($selectedCommittee, $committees);
        if ($selectedIndex === false) {
            Log::warning('Invalid committee selected.', ['committee' => $selectedCommittee]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid committee selected'
            ], 400);
        }

        // Get the corresponding model name for the selected committee
        $modelName = "App\\Models\\" . $models[$selectedIndex];

        // Calculate total remaining budget
        $totalRemainingBudget = $this->getTotalRemainingBudget();
        Log::info('Total remaining budget fetched.', ['totalRemainingBudget' => $totalRemainingBudget]);

        // Ensure sufficient funds are available
        if ($totalRemainingBudget - $newBudget < 0) {
            Log::warning('Insufficient remaining budget.', [
                'totalRemainingBudget' => $totalRemainingBudget,
                'newBudget' => $newBudget
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Insufficient remaining budget'
            ], 400);
        }

        // Calculate redistribution for other committees
        $redistributionAmount = ($totalRemainingBudget - $newBudget) / (count($committees) - 1);

        Log::info('Redistribution amount calculated.', ['redistributionAmount' => $redistributionAmount]);

        DB::beginTransaction();

        try {
            foreach ($models as $index => $model) {
                // Get the model class for each committee
                $modelClass = "App\\Models\\" . $model;

                if ($index === $selectedIndex) {
                    // Insert a new record for the selected committee with the new budget
                    Log::info('Inserting new budget for selected committee.', ['committee' => $selectedCommittee, 'newBudget' => $newBudget]);
                    $modelClass::create([
                        'budget' => $newBudget,
                        'year' => now()->year,
                        'remaining_budget' => $newBudget,
                        'expenses' => 0, // Assuming no expenses initially
                        'user_id' => auth()->id() // Assuming current authenticated user
                    ]);
                } else {
                    // Insert a new record for other committees with redistributed budgets
                    Log::info('Inserting redistributed budget for other committees.', [
                        'committee' => $committees[$index],
                        'redistributionAmount' => $redistributionAmount
                    ]);
                    $modelClass::create([
                        'budget' => $redistributionAmount, // No additional budget allocated directly
                        'year' => now()->year,
                        'remaining_budget' => $redistributionAmount,
                        'expenses' => 0, // Assuming no expenses initially
                        'user_id' => auth()->id() // Assuming current authenticated user
                    ]);
                }
            }

            DB::commit();
            Log::info('Budgets inserted successfully.');

            return response()->json([
                'success' => true,
                'message' => 'Budgets inserted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error inserting budgets in database.', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => "Error inserting budgets: {$e->getMessage()}"
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error processing the budget edit request.', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => "Error processing request: {$e->getMessage()}"
        ], 500);
    }
}

// Helper method to get total remaining budget
private function getTotalRemainingBudget()
{
    try {
        // Array of committee models
        $models = [
            'CommitteeBarangayAffairsEnvironment',
            'CommitteeEducation',
            'CommitteePeaceOrder',
            'CommitteeLawsGoodGovernance',
            'CommitteeElderlyPwdVawc',
            'CommitteeHealthSanitationNutrition',
            'CommitteeLivelihood',
            'CommitteeInfrastructureFinance'
        ];

        // Sum the most recent remaining_budget for each committee
        $totalRemaining = collect($models)->sum(function ($model) {
            // Get the latest remaining_budget value for each model
            $latestRecord = "App\\Models\\{$model}"::latest()->first();
            return $latestRecord ? $latestRecord->remaining_budget : 0;
        });

        Log::info('Total remaining budget calculated.', ['totalRemainingBudget' => $totalRemaining]);
        return $totalRemaining;
    } catch (\Exception $e) {
        Log::error('Error fetching total remaining budget.', ['error' => $e->getMessage()]);
        throw new \Exception("Error fetching total remaining budget: {$e->getMessage()}");
    }
}








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
