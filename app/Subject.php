<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject_table';
    protected $primaryKey = 'subject_id';
    
    public function ques(){
        return $this->belongsTo('App\Ques','subject_id');
    }
}
