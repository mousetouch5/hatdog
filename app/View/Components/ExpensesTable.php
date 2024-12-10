<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExpensesTable extends Component
{
    /**
     * Create a new component instance.
     */

    public $events;
    public $totalAmount;
    
    public function __construct($events, $totalAmount)
    {
        $this->events = $events;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.expenses-table');
    }
}
