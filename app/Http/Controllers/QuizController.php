<?php

namespace App\Http\Controllers;

use App\Models\Soalmulti;
use App\Models\Ujian;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $quiz = [];

    public function __construct()
    {
        $this->quiz['belum'] = [];
        $this->quiz['sudah'] = [];
    }

    public function doQuiz($id, Request $request)
    {
        $ujian = Ujian::where('id', $id)->with(['soal' => function ($soal) {
            $soal->inRandomOrder()->with(['OptionMulti' => function ($opt) {
                $opt->inRandomOrder();
            }]);
        }])->first();
        // return $ujian;
        $quizCount = Soalmulti::where('ujian_id', $id)->count();
        $currQuiz = 0;
        $opts = ['A', 'B', 'C', 'D', 'E'];
        return view('fe_page.do_quiz')->with([
            'quizCount' => $quizCount,
            'quiz' => $ujian,
            'currQuiz' => $currQuiz,
            'opts' => $opts
        ]);
    }

    public function postQuiz(Request $request)
    {
        return $request->all();
    }
}
