<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'name' => $this->faker->name(),
            'name' => 'Admin',
//            'email' => $this->faker->unique()->safeEmail(),
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Crypt::encrypt('12345678'), // password
//            'remember_token' => Str::random(10),
        ];
    }
}
