<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'username', 'email', 'password', 'class_id', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN_TYPE = 'admin';
    const SUPERADMIN_TYPE = 'super_admin';
    const DEFAULT_TYPE = 'member';
    const LP = 'LP';
    const LG = 'LG';

    public function isAdmin()
    {
        return $this->role === self::ADMIN_TYPE;
    }

    public function isSuperAdmin()
    {
        return $this->role === self::SUPERADMIN_TYPE;
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\MailResetPasswordNotification($token));
    }

}