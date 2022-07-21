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
        'lender_phone' ,
        'amount_debt',
        'deadline',
    ];
}
