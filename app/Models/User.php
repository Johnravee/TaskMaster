<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use MongoDB\Laravel\Eloquent\Casts\ObjectId;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Eloquent implements AuthenticatableContract, CanResetPassword
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


     /**
     * Get the email address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }


    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Customize your notification logic here.
         $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}