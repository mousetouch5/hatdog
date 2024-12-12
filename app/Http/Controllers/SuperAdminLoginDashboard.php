<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;

class SuperAdminLoginDashboard extends Controller
{
    //
    public function index(){
        $events = Event::all();
        return view('superadmin.dashboard',compact('events'));
    }



    public function update(Request $request, Event $event)
    {
        Log::info('Storing a new event', ['data' => $request->all()]);
        $request->validate([
            'event_name' => 'required|string|max:255',
             //'event_start_date' => 'required|date',
             // Add other validation rules as needed
        ]);

        $event->update($request->all());

        return redirect()->route('superadmin.dashboard')->with('success', 'Event updated successfully.');
    }


public function listPendingApprovals()
{
    $pendingUsers = User::where('is_approved', 0)->get();

    // Transform and fix the image path
    $pendingUsers->transform(function ($user) {
        if ($user->id_picture_path) {
            // Remove leading slash and correct the path to public/resources/id_pictures
            $relativePath = ltrim($user->id_picture_path, '/');
            $user->id_picture_path = asset($relativePath);
        } else {
            $user->id_picture_path = null;
        }
        return $user;
    });

    return response()->json($pendingUsers);
}
/*
public function listofAllUsers()
{
    $pendingUsers = User::where('is_approved', 1)->get();

    // Transform and fix the image path
    $pendingUsers->transform(function ($user) {
        if ($user->id_picture_path) {
            // Remove leading slash and correct the path to public/resources/id_pictures
            $relativePath = ltrim($user->id_picture_path, '/');
            $user->id_picture_path = asset($relativePath);
        } else {
            $user->id_picture_path = null;
        }
        return $user;
    });

    return response()->json($pendingUsers);
}
*/


    public function loadEvents(Request $request)
    {
    $search = $request->query('search'); // Optional search query

    // Fetch events with optional search filter
    $events = Event::when($search, function ($query, $search) {
        return $query->where('eventName', 'LIKE', "%{$search}%");
    })->paginate(10);

    // Transform event data for the response
    $events->getCollection()->transform(function ($event) {
        if ($event->eventImage) {
            // Remove leading slash and correct the path
            $relativePath = ltrim($event->eventImage, '/');
            $event->eventImage = asset("public/{$relativePath}");
        } else {
            $event->eventImage = null; // Set to null if no image exists
        }
        return $event;
    });

    return response()->json($events);
    }



public function listofAllUsers(Request $request)
{
    $search = $request->get('search', '');

    $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->paginate(10); // Paginate results, 10 per page

    return response()->json($users);
}





    public function approveUser($id){
     $user = User::find($id);
        if ($user) {
        // Set the 'is_approved' field to 1 when the user is approved
        $user->is_approved = 1;
        $user->save();
        return response()->json(['success' => true, 'message' => 'User approved successfully!']);
        }
     return response()->json(['success' => false, 'message' => 'User not found!']);
     }

    public function rejectUser($id)
        {
    $user = User::find($id);
    if ($user) {
        // Set the status to 'rejected'
        $user->status = 'rejected';
        
        // Delete the user
        $user->delete();
        
        // Return a success response
        return response()->json(['success' => true, 'message' => 'User rejected and deleted successfully!']);
    }
    
    // Return an error response if the user was not found
    return response()->json(['success' => false, 'message' => 'User not found!']);
    }



        // Method to change user password
public function changePassword(Request $request, $userId)
{
    // Ensure the request contains the newPassword field
    $request->validate([
        'newPassword' => 'required|string|min:6',
    ]);
    
    $user = User::find($userId);

    if ($user) {
        // Hash and save the new password
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
    }

    return response()->json(['success' => false, 'message' => 'User not found.']);
}



        public function deleteUser(Request $request, $userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'User not found.']);
    }


    public function shit(){
    $shit = Event::all();
    return response()->json($shit);

    }


}
