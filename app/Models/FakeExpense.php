<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FakeExpense extends Model
{
    use HasFactory;
    

    protected $table = 'fake_expense';

    protected $fillable = [
        'event_id', 
        'expense_description', 
        'expense_amount',
        'expense_category',
        'quantity_amount',
    ];


    public function event()
    {
        return $this->belongsTo(FakeEvent::class, 'event_id');
    }
}
