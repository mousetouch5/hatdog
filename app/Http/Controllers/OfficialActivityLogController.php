<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
class OfficialActivityLogController extends Controller
{
    public function index()
    {
    $events = Event::with('expenses')->get(); // Get all events
    //$user = Auth::user();
    $totalAmount = $events->flatMap(function ($event) {
    return $event->expenses;
    })->sum('expense_amount');

        return view('official.OfficialActivityLog',compact('events','totalAmount')); // This will load the 'events.index' view
    }
}
