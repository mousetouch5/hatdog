<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetPlanningController extends Controller
{
    public function index() {
      
        return view('Official.BudgetPlanning');
    }
}
