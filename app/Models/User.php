<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class User extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;


    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'isAdmin',
        'remember_token'
    ];

    /** @var array<int, string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}