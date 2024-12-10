<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
//use \PDF;
use Barryvdh\DomPDF\Facade\PDF; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class ProjectController extends Controller
{
    public function index()
    {
    $user = Auth::user(); // Get the currently authenticated user

    // Fetch events and map over them to include userId
    $events = Event::with('expenses')
        ->get()
        ->map(function($event) use ($user) {
            // Add the userId to each event object
            $event->userId = $user->id;

            // Optionally, you can add more logic here for event categories, etc.
            return $event;
        });
    $totalAmount = $events->flatMap(function ($event) {
        return $event->expenses;
    })->sum('expense_amount');


        return view('Resident.Project',compact('events','totalAmount')); // This will load the 'events.index' view
    }
}
