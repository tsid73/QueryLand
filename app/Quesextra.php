<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quesextra extends Model
{
 
    protected $table = 'ques_extra';
    protected $primaryKey = 'ques_id';
    
    public function extra()
    {
     return $this->belongsTo('App\Ques','user_id');
    }
}