<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Event;
class EditController extends Controller
{
    public function index()
    {
    $eventNames = Event::pluck('eventName')->toArray();

    // Fetch transactions that do not match event names
    $transactions = Transaction::whereNotIn('description', $eventNames)->get();

    return view('official.Edit',compact('transactions')); // This will load the 'events.index' view
    }

    public function putangina()
    {
       $eventNames = Event::pluck('eventName')->toArray();

    // Fetch transactions that do not match event names
       $transactions = Transaction::whereNotIn('description', $eventNames)->get();
      //  dd($transactions);
        return view('official.Edit2',compact('transactions')); // This will load the 'events.index' view
    }
}
