<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_basic';
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'username', 'email', 'password', 'user_field',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
