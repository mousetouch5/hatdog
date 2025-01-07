<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarActivitiesController extends Controller
{
    public function index() {
      
        return view('Official.CalendarActivities');
    }
}
