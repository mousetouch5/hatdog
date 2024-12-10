<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'eventName',
        'eventDescription',
        'eventStartDate',
        'eventEndDate',
        'eventImage',
        'eventSpent',
        'eventTime',
        'budget',
        'organizer',
        'eventLocation',
        'eventType',
        'eventStatus',
    ];

    protected $casts = [
        'eventStartDate' => 'date',
        'eventEndDate' =>'date', // Ensure eventDate is cast to a date format
        'budget' => 'decimal:2', // Ensure budget is cast to a decimal with 2 places
    ];

    // Example of an accessor for formatted budget
    public function getFormattedBudgetAttribute()
    {
        return '$' . number_format($this->budget, 2);
    }

    public function likes(){
    return $this->hasMany(SurveyLike::class, 'event_id');
    }
       
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'event_id'); // Correct relationship
    }

    public function surveys()
    {
        return $this->hasMany(SurveyLike::class, 'event_id');
    }

}
