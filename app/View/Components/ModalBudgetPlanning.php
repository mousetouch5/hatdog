<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
class ModalBudgetPlanning extends Component
{
    /**
     * Create a new component instance.
     */
    public $user;

    public function __construct($user = null)
    {
        // Automatically fetch the authenticated user if not provided
        $this->user = $user ?? Auth::user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-budget-planning');
    }
}
