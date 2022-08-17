<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Debt extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'creditor_phone',
        'debitor_phone',
        'amount_debt',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'debitor_phone', 'phone_number');
    }

    public function user_cr()
    {
        return $this->belongsTo(User::class, 'creditor_phone', 'phone_number');
    }
}
