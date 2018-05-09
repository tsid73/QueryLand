<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $table = 'admin_table';
    protected $primaryKey = 'admin_id';
    
    protected $fillable = [
        'username', 'password',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
