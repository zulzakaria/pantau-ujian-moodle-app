<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMdl extends Model
{
    protected $table = 'mdlyf_user';

    public function QuizAttempt(){
        return $this->belongsTo('App\QuizAttempt');
    }
}
