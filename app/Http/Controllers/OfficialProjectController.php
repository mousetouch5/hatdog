<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
//use \PDF;
use Barryvdh\DomPDF\Facade\PDF; 
use Carbon\Carbon;
class OfficialProjectController extends Controller
{
public function index()
{
    // Get all events with their related expenses
    $events = Event::with('expenses')->get();

    // Calculate the total amount of all expenses
    $totalAmount = $events->flatMap(function ($event) {
        return $event->expenses;
    })->sum('expense_amount');

    // Pass the events and total amount to the view
    return view('official.OfficialProject', compact('events', 'totalAmount'));
}

}
