<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    // Specify the table name if it's not the default plural of the model
    protected $table = 'budget_table';

    protected $fillable = [
        'year', 
        'amount', 
    ];

}
