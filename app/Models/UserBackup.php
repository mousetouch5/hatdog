<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserBackup extends Model
{


    use HasFactory;

    protected $table = 'user_backups';

    protected $fillable = [
        'user_id',
        'name',
        'position',
        'password',
    ];

    /**
     * Hash password before saving.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relationship: A UserBackup belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
}
