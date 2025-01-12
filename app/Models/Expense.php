<?php

// Expense.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'expense_description', 'expense_amount', 'expense_date','expense_time', 'quantity_amount',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
