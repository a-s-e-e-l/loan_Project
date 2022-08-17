<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'payer_phone',
        'recipient_phone',
        'amount',
        'note',
        'deadline',
        'agree',
        'type',
    ];
    protected $foreignKey = 'payer_phone';

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
    public function users()
    {
        return $this->belongsTo(User::class, 'payer_phone', 'phone_number');
    }

//    public function users_r()
//    {
//        return $this->belongsTo(User::class, 'recipient_phone', 'phone_number');
//    }

}
