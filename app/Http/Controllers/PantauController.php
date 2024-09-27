<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Quiz;
use App\UserMdl;
use App\QuizAttempt;
use Illuminate\Support\Facades\DB;
use App\Exports\QuizGradeExport;
use Maatwebsite\Excel\Facades\Excel;

class PantauController extends Controller
{
    public function index2(Request $request)
    {
        $course = Course::where('visible', '1')->where('summaryformat', '1')->get();
        if($request->has('course')){
            $quiz = Quiz::where('course',$request->course)->first();
        }else{
            $courseId = Course::where('visible', '1')->where('summaryformat', '1')->first();
            $quiz = Quiz::where('course',$courseId->id)->first();  
        }
        
        if($quiz == null){
            $idQuiz = 0;
        }else{
            $idQuiz = $quiz->id;
        }
        
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->paginate(50);
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->get();

        $attempts = DB::table('mdlyf_quiz_attempts')
            ->join('mdlyf_user', 'mdlyf_quiz_attempts.userid', '=', 'mdlyf_user.id')
            ->where('mdlyf_quiz_attempts.quiz', $idQuiz)
            ->get();


        $jumlahPeserta = QuizAttempt::where('quiz',$idQuiz)->count();;
        $user = UserMdl::all();

        return view('pantau2',['course'=>$course,'quiz'=>$quiz,'attempts'=>$attempts,'jumlahPeserta'=>$jumlahPeserta,'select'=>$request->course]);
    }

    public function index(Request $request)
    {
        $course = Course::where('visible', '1')->where('summaryformat', '1')->get();
        if($request->has('course')){
            $quiz = Quiz::where('course',$request->course)->first();
        }else{
            $courseId = Course::where('visible', '1')->where('summaryformat', '1')->first();
            $quiz = Quiz::where('course',$courseId->id)->first();  
        }
        
        if($quiz == null){
            $idQuiz = 0;
        }else{
            $idQuiz = $quiz->id;
        }
        
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->paginate(50);
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->get();

        $attempts = DB::table('mdlyf_quiz_attempts')
            ->join('mdlyf_user', 'mdlyf_quiz_attempts.userid', '=', 'mdlyf_user.id')
            ->join('mdlyf_quiz', 'mdlyf_quiz_attempts.quiz', '=', 'mdlyf_quiz.id')
            ->select('mdlyf_quiz_attempts.id','mdlyf_quiz.name','mdlyf_user.firstname','mdlyf_user.lastname',
                    'mdlyf_quiz_attempts.timestart','mdlyf_quiz_attempts.timefinish','mdlyf_quiz_attempts.state',
                    'mdlyf_quiz_attempts.sumgrades AS benar','mdlyf_quiz.sumgrades AS jumSoal')
            ->where('mdlyf_quiz_attempts.quiz', $idQuiz)
            ->get();

        // dd($attempts);
        
            
        $jumlahPeserta = QuizAttempt::where('quiz',$idQuiz)->count();;
        $user = UserMdl::all();

        return view('pantau',['course'=>$course,'quiz'=>$quiz,'attempts'=>$attempts,'jumlahPeserta'=>$jumlahPeserta,'select'=>$request->course]);
    }

    public function hasil(Request $request)
    {
        $course = Course::where('visible', '1')->where('summaryformat', '1')->get();
        if($request->has('course')){
            $quiz = Quiz::where('course',$request->course)->first();
        }else{
            $courseId = Course::where('visible', '1')->where('summaryformat', '1')->first();
            $quiz = Quiz::where('course',$courseId->id)->first();  
        }
        
        if($quiz == null){
            $idQuiz = 0;
            $hasil = null;
        }else{
            $idQuiz = $quiz->id;
            
            $hasil = DB::table('mdlyf_quiz_grades')
                ->join('mdlyf_user', 'mdlyf_quiz_grades.userid', '=', 'mdlyf_user.id')
                // ->join('mdlyf_quiz', 'mdlyf_quiz_grades.quiz', '=', 'mdlyf_quiz.id')
                ->select('mdlyf_user.lastname','mdlyf_user.firstname','mdlyf_quiz_grades.grade')
                ->orderby('mdlyf_user.id')
                ->where('mdlyf_quiz_grades.quiz', $quiz->id)
                ->get();
        }
        
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->paginate(50);
        // $attempts = QuizAttempt::where('quiz',$idQuiz)->get();

        // $attempts = DB::table('mdlyf_quiz_attempts')
        //     ->join('mdlyf_user', 'mdlyf_quiz_attempts.userid', '=', 'mdlyf_user.id')
        //     ->where('mdlyf_quiz_attempts.quiz', $idQuiz)
        //     ->get();

        


        $jumlahPeserta = QuizAttempt::where('quiz',$idQuiz)->count();;
        $user = UserMdl::all();

        return view('hasil',['course'=>$course,'quiz'=>$quiz,'data'=>$hasil,'jumlahPeserta'=>$jumlahPeserta,'select'=>$request->course]);
    }

    public function export($id){
        
        $quiz = Quiz::
                where('id','=',$id)->select('name')->first();
        // dd($quiz);
        return Excel::download(new QuizGradeExport($id), $quiz->name.'.xlsx' );
        
        // return [
        // (new QuizGradeExport($id))->withFilename($quiz->name.'_'.time(). '.xlsx'),
        // ];
    }
}
