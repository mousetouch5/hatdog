<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model
    protected $table = 'survey_responses';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'participation',
        'event_types',
        'event_info',
        'impact',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optionally, define any casts for the attributes
    protected $casts = [
        'event_types' => 'array',
        'event_info' => 'array',
        'impact' => 'array',
    ];
}
