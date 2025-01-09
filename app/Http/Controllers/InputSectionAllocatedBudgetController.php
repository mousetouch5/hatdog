<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputSectionAllocatedBudgetController extends Controller
{
    public function index() {
      
        return view('Official.InputSectionAllocatedBudget');
    }
}
