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
    $currentYear = now()->year; // Get the current year
    $latestRecord = $modelClass::where('year', $currentYear)
                               ->orderBy('updated_at', 'desc')
                               ->first();

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



public function index(Request $request) {
    $currentYear = Carbon::now()->year;

    // Fetch all available years from the Budget model
    $availableYears = Budget::distinct('year')->pluck('year')->sort()->reverse(); // Sorting from newest to oldest

    // Get the selected year from the request, or default to the current year
    $selectedYear = $request->input('year', $currentYear);

    // Fetch the budget for the selected year
    $totalBudget = Budget::where('year', $selectedYear)->first();

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

    // Fetch the committee budgets for the selected year (not current year)
    foreach ($Models as $index => $committee) {
        $committeeClass = "App\Models\\" . str_replace(' ', '', str_replace('&', 'And', $committee));

        if (class_exists($committeeClass)) {
            $committeeRecord = $committeeClass::where('year', $selectedYear) // Use selected year here
                                                ->orderBy('updated_at', 'desc')
                                                ->first();

            if ($committeeRecord) {
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => $committeeRecord->budget,
                    'remaining_budget' => $committeeRecord->remaining_budget
                ];
            } else {
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => 0,
                    'remaining_budget' => 0
                ];
            }
        }
    }

    // Return the view with available years and other data
    return view('Official.BudgetPlanning', compact('committeesData', 'currentYear', 'totalBudget', 'availableYears', 'selectedYear'));
}





/*
public function index(Request $request) {
    $currentYear = Carbon::now()->year;

    // Fetch all available years from the Budget model
    $availableYears = Budget::distinct('year')->pluck('year')->sort()->reverse(); // Sorting from newest to oldest

    $currentYear = Carbon::now()->year;

    // Get the selected year from the request, or default to the current year
    $selectedYear = $request->input('year', $currentYear);

    // Fetch all available years from the Budget model
    $availableYears = Budget::distinct('year')->pluck('year')->sort()->reverse();

    // Fetch the budget for the selected year
    $totalBudget = Budget::where('year', $selectedYear)->first();


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
    
    foreach ($Models as $index => $committee) {
        $committeeClass = "App\Models\\" . str_replace(' ', '', str_replace('&', 'And', $committee));

        if (class_exists($committeeClass)) {
            $committeeRecord = $committeeClass::where('year', $currentYear)
                                                ->orderBy('updated_at', 'desc')
                                                ->first();

            if ($committeeRecord) {
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => $committeeRecord->budget,
                    'remaining_budget' => $committeeRecord->remaining_budget
                ];
            } else {
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => 0,
                    'remaining_budget' => 0
                ];
            }
        }
    }

    // Return the view with available years and other data
    
    return view('Official.BudgetPlanning', compact('committeesData', 'currentYear', 'totalBudget', 'availableYears', 'selectedYear'));
}


*/


/*

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


*/
    public function edits() {
        return view('Official.BudgetPlanningEdit');
    }
/*
    public function edits1() {
        return view('Official.BudgetPlanningEdit');
    }
*/
public function edits1(Request $request) {
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
    $totalBudget = 0;

    // Fetch the committee budgets for the selected year
    foreach ($Models as $index => $committee) {
        $committeeClass = "App\Models\\" . str_replace(' ', '', str_replace('&', 'And', $committee));

        if (class_exists($committeeClass)) {
            $committeeRecord = $committeeClass::where('year', $currentYear)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($committeeRecord) {
                $remainingBudget = $committeeRecord->remaining_budget;
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => $committeeRecord->budget,
                    'remaining_budget' => $remainingBudget
                ];
                $totalBudget += $remainingBudget;
            } else {
                $committeesData[] = [
                    'committee_name' => $committees[$index],
                    'budget' => 0,
                    'remaining_budget' => 0
                ];
            }
        }
    }


    
    // Return the view with available years and other data
    return view('Official.BudgetPlanningEdits', compact('currentYear', 'totalBudget', 'committeesData'));
}



/*
    
public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
            Rule::unique('budget_table', 'year'), // Ensure the year is unique in the budget table
        ],
        'yearly_budget' => 'required|numeric|min:0', // Validate that the yearly budget is numeric and non-negative
    ]);

    // Capture the committee-specific budgets
    $committeeBudgets = $request->except(['_token', 'year', 'yearly_budget']);

    try {
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();

        // Save the main budget entry
        $budget = Budget::create([
            'year' => $validatedData['year'],
            'amount' => $validatedData['yearly_budget'],
        ]);

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Define committee model names with corresponding input keys
        $committees = [
            'committee_barangay_affairs_environment' => 'CommitteeBarangayAffairsEnvironment',
            'committee_education' => 'CommitteeEducation',
            'committee_peace_order' => 'CommitteePeaceOrder',
            'committee_laws_good_governance' => 'CommitteeLawsGoodGovernance',
            'committee_elderly_pwd_vawc' => 'CommitteeElderlyPwdVawc',
            'committee_health_sanitation_nutrition' => 'CommitteeHealthSanitationNutrition',
            'committee_livelihood' => 'CommitteeLivelihood',
            'committee_infrastructure_finance' => 'CommitteeInfrastructureFinance',
        ];

        // Loop through each committee and create budget records
        foreach ($committees as $inputKey => $committeeModel) {
            $fullModelClass = "App\\Models\\$committeeModel"; // Ensure the namespace is correct
            if (class_exists($fullModelClass)) {
                $allocatedBudget = isset($committeeBudgets[$inputKey]) 
                    ? (float) str_replace(['₱', ','], '', $committeeBudgets[$inputKey]) 
                    : 0;

                $fullModelClass::create([
                    'year' => $validatedData['year'],
                    'budget' => $allocatedBudget,
                    'remaining_budget' => $allocatedBudget,
                    'user_id' => $userId, // Associate with the authenticated user
                ]);
            } else {
                throw new Exception("Model class $fullModelClass does not exist.");
            }
        }

        // Commit the transaction
        DB::commit();

        // Redirect or return success response
        return redirect()->route('Official.BudgetPlanning.index')->with('success', 'Budget added successfully!');
    } catch (\Exception $e) {
        // Rollback the transaction in case of an error
        DB::rollBack();

        // Log the error for debugging
        Log::error('Failed to store budget: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString(),
        ]);

        // Redirect back with an error message
        return redirect()->back()->withErrors('An error occurred while adding the budget. Please try again.');
    }
}
*/



public function store2(Request $request)
{
    // Log request data for debugging
    Log::info('Budget store request received', ['request' => $request->all()]);


        $validatedData = $request->validate([
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
        //    Rule::unique('budget_table', 'year'), // Ensure the year is unique in the budget table
        ],
        'yearly_budget' => 'required|numeric|min:0', // Validate that the yearly budget is numeric and non-negative
    ]);

    try {
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();
        Log::info('Database transaction started');

        // Remove formatting from yearly budget
        $validatedData['yearly_budget'] = floatval($request->input('yearly_budget'));

        // Save the main budget entry
        $budget = Budget::create([
            'year' => $validatedData['year'],
            'amount' => $validatedData['yearly_budget'],
        ]);
        Log::info('Main budget entry created', ['budget' => $budget]);

        // Get the authenticated user's ID
        $userId = auth()->id();
        Log::info('Authenticated user ID retrieved', ['user_id' => $userId]);

        // Define committee model names and map them to form input names
$committees = [
    'CommitteeBarangayAffairsEnvironment' => 'committee__chair_on__barangay__affairs____environment',
    'CommitteeEducation' =>'committee__chair_on__education',
    'CommitteePeaceOrder' => 'committee__chair__peace____order',
    'CommitteeLawsGoodGovernance' => 'committee__chair_on__laws____good__governance',
    'CommitteeElderlyPwdVawc' => 'committee__chair_on__elderly___p_w_d__v_a_w_c',
    'CommitteeHealthSanitationNutrition' => 'committee__chair_on__health____sanitation___nutrition',
    'CommitteeLivelihood' => 'committee__chair_on__livelihood',
    'CommitteeInfrastructureFinance' => 'committee__chair__infrastructure____finance',
];


        // Loop through each committee and create budget records
foreach ($committees as $modelName => $inputName) {
    $fullModelClass = "App\\Models\\$modelName";

    if (class_exists($fullModelClass)) {
        // Retrieve and sanitize the budget allocation from the request
        $allocatedBudget = floatval($request->input($inputName, 0)); // Default to 0 if input is missing
        Log::info("Processing committee: $modelName", [
            'raw_value' => $request->input($inputName),
            'allocated_budget' => $allocatedBudget,
        ]);

        // Save the data into the respective committee table
        $fullModelClass::create([
            'year' => $validatedData['year'],
            'budget' => $allocatedBudget,
            'remaining_budget' => $allocatedBudget,
            'user_id' => $userId,
        ]);
        Log::info("Budget entry created for $modelName");
    } else {
        Log::error("Model class $fullModelClass does not exist.");
        throw new Exception("Model class $fullModelClass does not exist.");
    }
}


        // Commit the transaction
        DB::commit();
        Log::info('Database transaction committed successfully');

        return redirect()->route('Official.BudgetPlanning.index')->with('success', 'Budget added successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to store budget: ', ['error' => $e->getMessage()]);
        
        return redirect()->back()->withErrors('An error occurred while adding the budget.');
    }
}










public function store(Request $request)
{
    // Log request data for debugging
    Log::info('Budget store request received', ['request' => $request->all()]);

    // Validate the incoming request
    $validatedData = $request->validate([
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
            Rule::unique('budget_table', 'year'), // Ensure the year is unique in the budget table
        ],
        'yearly_budget' => 'required|numeric|min:0', // Validate that the yearly budget is numeric and non-negative
    ]);

    try {
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();
        Log::info('Database transaction started');

        // Remove formatting from yearly budget
        $validatedData['yearly_budget'] = floatval($request->input('yearly_budget'));

        // Save the main budget entry
        $budget = Budget::create([
            'year' => $validatedData['year'],
            'amount' => $validatedData['yearly_budget'],
        ]);
        Log::info('Main budget entry created', ['budget' => $budget]);

        // Get the authenticated user's ID
        $userId = auth()->id();
        Log::info('Authenticated user ID retrieved', ['user_id' => $userId]);

        // Define committee model names and map them to form input names
$committees = [
    'CommitteeBarangayAffairsEnvironment' => 'committee__chair_on__barangay__affairs__environment',
    'CommitteeEducation' =>'committee__chair_on__education',
    'CommitteePeaceOrder' => 'committee__chair__peace__order',
    'CommitteeLawsGoodGovernance' => 'committee__chair_on__laws__good__governance',
    'CommitteeElderlyPwdVawc' => 'committee__chair_on__elderly__p_w_d__v_a_w_c',
    'CommitteeHealthSanitationNutrition' => 'committee__chair_on__health__sanitation__nutrition',
    'CommitteeLivelihood' => 'committee__chair_on__livelihood',
    'CommitteeInfrastructureFinance' => 'committee__chair__infrastructure__finance',
];


        // Loop through each committee and create budget records
foreach ($committees as $modelName => $inputName) {
    $fullModelClass = "App\\Models\\$modelName";

    if (class_exists($fullModelClass)) {
        // Retrieve and sanitize the budget allocation from the request
        $allocatedBudget = floatval($request->input($inputName, 0)); // Default to 0 if input is missing
        Log::info("Processing committee: $modelName", [
            'raw_value' => $request->input($inputName),
            'allocated_budget' => $allocatedBudget,
        ]);

        // Save the data into the respective committee table
        $fullModelClass::create([
            'year' => $validatedData['year'],
            'budget' => $allocatedBudget,
            'remaining_budget' => $allocatedBudget,
            'user_id' => $userId,
        ]);
        Log::info("Budget entry created for $modelName");
    } else {
        Log::error("Model class $fullModelClass does not exist.");
        throw new Exception("Model class $fullModelClass does not exist.");
    }
}


        // Commit the transaction
        DB::commit();
        Log::info('Database transaction committed successfully');

        return redirect()->route('Official.BudgetPlanning.index')->with('success', 'Budget added successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to store budget: ', ['error' => $e->getMessage()]);
        
        return redirect()->back()->withErrors('An error occurred while adding the budget.');
    }
}






    
/*
public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
            Rule::unique('budget_table', 'year'), // Ensure the year is unique in the budget table
        ],
        'yearly_budget' => 'required|numeric|min:0', // Validate that the yearly budget is numeric and non-negative
    ]);

    try {
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();

        // Save the main budget entry
        $budget = Budget::create([
            'year' => $validatedData['year'],
            'amount' => $validatedData['yearly_budget'],
        ]);

        $amount = $validatedData['yearly_budget'];
        $committeeCount = 8; // Total number of committees
        $sharePerCommittee = $amount / $committeeCount; // Equal share for each committee

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Define committee model names
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

        // Loop through each committee and create budget records
        foreach ($committees as $committeeModel) {
            $fullModelClass = "App\\Models\\$committeeModel"; // Ensure the namespace is correct
            if (class_exists($fullModelClass)) {
                $fullModelClass::create([
                    'year' => $validatedData['year'],
                    'budget' => $sharePerCommittee,
                    'remaining_budget' => $sharePerCommittee,
                    'user_id' => $userId, // Associate with the authenticated user
                ]);
            } else {
                throw new Exception("Model class $fullModelClass does not exist.");
            }
        }

        // Commit the transaction
        DB::commit();

        // Redirect or return success response
        return redirect()->route('Official.BudgetPlanning.index')->with('success', 'Budget added successfully!');
    } catch (\Exception $e) {
        // Rollback the transaction in case of an error
        DB::rollBack();

        // Log the error for debugging
        Log::error('Failed to store budget: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString(),
        ]);

        // Redirect back with an error message
        return redirect()->back()->withErrors('An error occurred while adding the budget. Please try again.');
    }
}
*/
}
