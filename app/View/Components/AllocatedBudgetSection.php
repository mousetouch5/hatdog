<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AllocatedBudgetSection extends Component
{
    /**
     * Create a new component instance.
     */
    // Declare the property
public $committeesData;
public $totalBudget;
public $currentYear;
public $availableYears;
public $selectedYear;


// Constructor to accept data
public function __construct($committeesData, $currentYear, $totalBudget, $availableYears, $selectedYear)
{
    $this->committeesData = $committeesData;
    $this->currentYear = $currentYear;
    $this->totalBudget = $totalBudget;
    $this->availableYears = $availableYears;
    $this->selectedYear = $selectedYear;
}


    // Render the component view
    public function render()
    {
        return view('components.allocated-budget-section');
    }
}
