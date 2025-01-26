<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'type',
        'reciept',
        'user_id', // Include the user_id in the fillable attributes
    ];

    protected $casts = [
        'eventStartDate' => 'date',
        'eventEndDate' => 'date', // Ensure eventDate is cast to a date format
        'budget' => 'decimal:2', // Ensure budget is cast to a decimal with 2 places
    ];

    public function getIsExpiredAttribute()
    {
        // Check if the event/project is marked as 'done'
        if ($this->eventStatus === 'done') {
            // Check if 14 days have passed since the eventEndDate
            return Carbon::parse($this->eventEndDate)->addDays(14)->isPast();
        }

        // If not 'done', it's not expired
        return false;
    }

    // Example of an accessor for formatted budget
    public function getFormattedBudgetAttribute()
    {
        return '$' . number_format($this->budget, 2);
    }

    public function likes()
    {
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

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
