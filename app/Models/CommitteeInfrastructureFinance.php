<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeInfrastructureFinance extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'committee_infrastructure_finance';

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

