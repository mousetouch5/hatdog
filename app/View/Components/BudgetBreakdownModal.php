<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BudgetBreakdownModal extends Component
{
//public $events;

public function __construct()
{
    //$this->events = $events; // Use $events consistently
}

public function render(): View|Closure|string
{
    return view('components.budget-breakdown-modal');
}

}
