<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userwork extends Model
{
    protected $table = 'user_basic';
    protected $primaryKey = 'user_id';
    
    public function ques()
    {
        return $this->belongsTo('App\Ques','user_id');
    }
}
