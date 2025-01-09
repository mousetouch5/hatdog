<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeEducation extends Model
{
    //committee_education

    protected $table = 'committee_education';
   // Define the attributes that are mass assignable
    protected $fillable = [
        'budget',
        'year',
        'remaining_budget',
        'expenses',
        'user_id'
    ];

    // Define the relationship with the User model (assuming 'User' exists)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
