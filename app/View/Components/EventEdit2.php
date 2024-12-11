<?php

namespace App\View\Components;

use App\Models\Transaction;
use Illuminate\View\Component;

class EventEdit extends Component
{
    public $transactions;

    // Accept transactions through the constructor
    public function __construct($transactions)
    {
        $this->transactions = $transactions; // Set the transactions
    }

    public function render()
    {
        return view('components.event.event-edit2');
    }
}
