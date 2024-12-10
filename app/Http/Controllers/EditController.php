<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditController extends Controller
{
    public function index()
    {
        return view('official.Edit'); // This will load the 'events.index' view
    }
}
