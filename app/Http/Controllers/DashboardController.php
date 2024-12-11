<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        $events = Event::all();     
        return view('Resident.dashboard',compact('events'));
    }
    public function getOfficials()
    {
    // Fetching the barangay officials who are approved and have a specific position
    $officials = \App\Models\User::whereIn('position', ['Barangay Captain', 'Barangay Secretary', 'Barangay Treasurer'])
                                  ->where('is_approved', 1)  // Filter to only approved officials
                                  ->get();

    // Returning as a JSON response
    return response()->json($officials);
    }


}