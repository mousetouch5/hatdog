<?php




namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model {
        //

       // use HasFactory;

        protected $fillable = [
            'budget',
            'money_spent',
            'recieve_by',
            'authorize_official',
            'date',
            'description',
            'reciept',
            'is_approved',
        ];

        // Relationship with User
        public function authorizeOfficial()
        {
             return $this->belongsTo(User::class, 'authorize_official');
        }
        public function recieveBy()
        {
             return $this->belongsTo(User::class, 'recieve_by');
        }
}

    ?>
