<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Expense;
//use \PDF;
use Barryvdh\DomPDF\Facade\PDF; 
use Carbon\Carbon;
class OfficialDashboardController extends Controller
{
public function index()
{
    $events = Event::with('expenses')->get(); // Get all events
    $user = Auth::user();

    // Check if user is authenticated
    if ($user && $user->user_type === 'resident') {
        return redirect()->route('resident.Event.index');
    }

    // Pass $events to the view
    return view('official.OfficialDashboard', compact('events'));
}

}

