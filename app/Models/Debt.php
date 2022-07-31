<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Debt extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'creditor_phone',
        'debitor_phone',
        'amount_debt',
        'note',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'debitor_phone', 'phone_number');
    }
//    public function users_cr()
//    {
//        return $this->belongsTo(User::class, 'creditor_phone', 'phone_number');
//    }
}
