<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyLike extends Model
{
    // Specify the table name if it's not the default plural of the model
    protected $table = 'surveys';

    protected $fillable = [
        'user_id', 
        'event_id', 
        'liked',
    ];

    // Define the relationship with the Event model
// In SurveyLike.php
    public function event()
    {
    return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
