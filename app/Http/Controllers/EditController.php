<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class EditController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
      //  dd($transactions);
        return view('official.Edit',compact('transactions')); // This will load the 'events.index' view
    }
}
