<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'activation_code',
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'address_line1',
        'address_line2',
        'address',
        'image',
        'draft',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasOne(Transaction::class, 'payer_phone', 'phone_number');
    }

    public function debt()
    {
        return $this->hasOne(Debt::class, 'debitor_phone', 'phone_number');
    }

    public function notifications()
    {
        return $this->hasOne(Debt::class, 'user_id', 'phone_number');
    }


}
