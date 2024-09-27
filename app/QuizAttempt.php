<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $table = 'mdlyf_quiz_attempts';

    public function UserMdl(){
        return $this->hasMany('App\UserMdl');
    }
}
