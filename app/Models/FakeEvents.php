<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeEvents extends Model
{

    use HasFactory;

    protected $table = 'fake_events';


    protected $fillable = [
        'eventName',
        'eventDescription',
        'eventStartDate',
        'eventEndDate',
        'budget',
        'type',
        'organizer',
    ];

    public function expenses()
    {
        return $this->hasMany(FakeExpense::class, 'event_id'); // Correct relationship
    }



}
