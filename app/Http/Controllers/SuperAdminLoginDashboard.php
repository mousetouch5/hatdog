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



public function updates(Request $request, $id)
{
    try {
        Log::info('Received request to update event', ['event_id' => $id]);

        // Validation rules
        $request->validate([
            'eventName' => 'nullable|string|max:255',
            'eventImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'organizer'  => 'nullable|string|max:255',
            'eventStatus'=> 'required|string|in:ongoing,done',
        ]);

        Log::info('Validation passed for event update', ['data' => $request->all()]);

        // Find the event or fail
        $event = Event::findOrFail($id);

        // Handle the image upload if provided
        if ($request->hasFile('eventImage')) {
            // Delete old image if exists
            if ($event->eventImage) {
                $oldImagePath = public_path('storage/' . $event->eventImage);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('eventImage');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/event_images'), $filename);
            $event->eventImage = 'event_images/' . $filename;

            Log::info('Event image uploaded', ['image_path' => $event->eventImage]);
        } else {
            Log::info('No new event image uploaded. Retaining existing image.');
        }

        // Update other fields
        $event->eventName    = $request->input('eventName', $event->eventName);
        $event->organizer    = $request->input('organizer', $event->organizer);
        $event->eventStatus  = $request->input('eventStatus');

        // Save the updated event
        $event->save();

        Log::info('Event updated successfully', ['event_id' => $id]);

        return response()->json([
            'success' => 'Event updated successfully!',
            'event'   => $event,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error updating event', [
            'error' => $e->getMessage(),
            'event_id' => $id,
        ]);

        return response()->json(['error' => 'Error updating event'], 500);
    }
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
            $event->eventImage = asset("storage/{$relativePath}");
        } else {
            $event->eventImage = null; // Set to null if no image exists
        }
        return $event;
    });

    return response()->json($events);
    }





public function CreateBullShit(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'position' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Handle file upload for profile picture
    $profilePicturePath = $this->storeFileIfExists($request->all(), 'profile_picture', 'storage/profile_pictures');

    // Create a new user with additional fields
    User::create([
        'name' => $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name, // Concatenate the name
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash the password for security
        'profile_photo_path' => $profilePicturePath,
        'first_name' =>$request['first_name'],
        'middle_name' =>$request['middle_name'],
        'last_name' => $request['last_name'],
        'position' => $request['position'],
        'user_type' => 'official', // Setting user type to 'official'
        'is_approved' => true, // Automatically approve the user
    ]);

    // Return a JSON response with success message
    return response()->json(['message' => 'User created successfully!'], 201)
                 ->withHeaders(['Location' => route('superadmin.dashboard')]); // Optional: Add the location of the redirected page

}

private function storeFileIfExists(array $input, string $key, string $directory): ?string
{
    if (isset($input[$key])) {
        $file = $input[$key];
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($directory);

        // Ensure the directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Move the file to the specified directory
        $file->move($destinationPath, $fileName);

        // Return the path of the uploaded file
        return "$directory/$fileName";
    }
    return null;
}







public function listofAllUsers(Request $request)
{
    $search = $request->get('search', '');

    $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->paginate(10); // Paginate results, 10 per page

    // Transform the users collection to add the correct image path
    $users->transform(function ($user) {
        if ($user->id_picture_path) {
            // Remove leading slash and correct the path to public/resources/id_pictures
            $relativePath = ltrim($user->id_picture_path, '/');
            $user->id_picture_path = asset($relativePath);
        } else {
            $user->id_picture_path = null;
        }
        return $user;
    });

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
