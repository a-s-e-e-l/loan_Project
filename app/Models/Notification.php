<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'data',
        'nontice_from',
        'notifiable_id',
        'notifiable_type',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'nontice_from', 'phone_number');
    }
}
