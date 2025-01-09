<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeLawsGoodGovernance extends Model
{
    //

        protected $table = 'committee_laws_good_governance';
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
