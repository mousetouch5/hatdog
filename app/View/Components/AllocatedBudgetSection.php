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

// Constructor to accept data
public function __construct($committeesData, $currentYear, $totalBudget)
{
    $this->committeesData = $committeesData;
    $this->currentYear = $currentYear;
    $this->totalBudget = $totalBudget;
}


    // Render the component view
    public function render()
    {
        return view('components.allocated-budget-section');
    }
}
