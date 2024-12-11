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
    $officials = User::whereIn('position', ['Barangay Captain', 'Barangay Secretary', 'Barangay Treasurer'])
        ->where('is_approved', 1)
        ->get()
        ->map(function ($official) {
            $official->profile_photo_path = $official->profile_photo_path 
                ? asset($official->profile_photo_path) 
                : 'https://via.placeholder.com/40';
            return $official;
        });

    return response()->json($officials);
    }


}