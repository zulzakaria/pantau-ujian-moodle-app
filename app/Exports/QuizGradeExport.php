<?php

namespace App\Exports;

use App\QuizGrade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class QuizGradeExport implements FromCollection
{
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('mdlyf_quiz_grades')
            ->join('mdlyf_user', 'mdlyf_quiz_grades.userid', '=', 'mdlyf_user.id')
            // ->join('mdlyf_quiz', 'mdlyf_quiz_grades.quiz', '=', 'mdlyf_quiz.id')
            ->select('mdlyf_user.lastname','mdlyf_user.firstname','mdlyf_quiz_grades.grade')
            ->orderby('mdlyf_user.id')
            ->where('mdlyf_quiz_grades.quiz', $this->id)
            ->get();
        

        // dd($data);    
        return $data;
    }
}
