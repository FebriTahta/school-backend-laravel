<?php

namespace App\Http\Controllers;

use App\Models\Jawabanmulti;
use App\Models\Soalmulti;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{

    public function addUjian()
    {
    }

    public function doQuiz($id, Request $request)
    {
        $request->siswaId = 13;
        $request->ujian_id = 2;
        if ($request->jawabanId) {
            $data = Jawabanmulti::where('siswa_id', $request->siswaId)
                ->where('ujian_id', $request->ujian_id)
                ->where('soalmulti_id', $request->soalId)->first();
            $data->optionmulti_id = $request->jawabanId;
            $data->jawabanku = $request->jawabanId;
            $data->save();
        }
        $quiz = Soalmulti::inRandomOrder()->Get();
        $cond = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $request->ujian_id);
        if ($cond->count() <= 0) {
            foreach ($quiz as $key => $value) {
                Jawabanmulti::firstOrCreate([
                    'siswa_id' => $request->siswaId,
                    'ujian_id' => $request->ujian_id,
                    'soalmulti_id' => $value->id,
                    'optionmulti_id' => null,
                    'jawabanku' => null,
                ]);
            }
        }
        $ujian = Ujian::find($request->ujian_id);
        $now = Carbon::parse(Carbon::now());
        if ($now < $ujian->ujian_datetimestart) {
            return 'belum dibuka pages here'; //bisa redirect pages
        }
        if ($now > $ujian->ujian_datetimeend) {
            return 'expired'; //bisa redirect pages
        }
        // 
        $quizCount = Soalmulti::where('ujian_id', $ujian->id)->count();
        $jawabanCount = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $id)
            ->where('optionmulti_id', '!=', null)
            ->count();
        $nextQuiz = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $request->ujian_id)
            ->where('optionmulti_id', null)->first();
        $quizPanel = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $id)->get();
        $soal = [];
        if ($jawabanCount >= $quizCount) {
            // return 'all soal done pages';
        } else {
            $soal = Soalmulti::where('id', $nextQuiz->soalmulti_id)->with(['OptionMulti'])->first();
        }
        $now = Carbon::parse(Carbon::now());
        if ($now < $ujian->ujian_datetimestart) {
            return 'belum dibuka pages here';
        }
        if ($request->byPanel) {
            $jawaban = Jawabanmulti::where('siswa_id', $request->siswaId)
                ->where('ujian_id', $request->ujian_id)
                ->where('soalmulti_id', $request->byPanel)->first();
            $soal = Soalmulti::where('id', $request->byPanel)->with(['OptionMulti'])->first();
            $soal->jawabanSiswa = $jawaban->optionmulti_id;
        }
        $opts = ['A', 'B', 'C', 'D', 'E'];
        return view('fe_page.do_quiz')->with([
            'quizCount' => $quizCount,
            'quiz' => $ujian,
            'q' => $soal,
            'index' => 0, //$count,
            'opts' => $opts,
            'quizPanel' => $quizPanel,
        ]);
    }

    public function prevQuiz($id, Request $request)
    {
        $request->siswaId = 13;
        $request->ujian_id = 2;
        if ($request->jawabanId) {
            $data = Jawabanmulti::where('siswa_id', $request->siswaId)
                ->where('ujian_id', $request->ujian_id)
                ->where('soalmulti_id', $request->soalId)->first();
            $data->optionmulti_id = $request->jawabanId;
            $data->jawabanku = $request->jawabanId;
            $data->save();
        }
        $quiz = Soalmulti::inRandomOrder()->Get();
        $cond = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $request->ujian_id);
        if ($cond->count() <= 0) {
            foreach ($quiz as $key => $value) {
                Jawabanmulti::firstOrCreate([
                    'siswa_id' => $request->siswaId,
                    'ujian_id' => $request->ujian_id,
                    'soalmulti_id' => $value->id,
                    'optionmulti_id' => '0',
                    'jawabanku' => '0',
                ]);
            }
        }
        $ujian = Ujian::find($request->ujian_id);
        $now = Carbon::parse(Carbon::now());
        if ($now < $ujian->ujian_datetimestart) {
            // return 'belum dibuka pages here'; //bisa redirect pages
        }
        if ($now > $ujian->ujian_datetimeend) {
            // return 'expired'; //bisa redirect pages
        }

        $now = Carbon::parse(Carbon::now());
        if ($now < $ujian->ujian_datetimestart) {
            // return 'belum dibuka pages here';
        }
        $quizCount = Soalmulti::where('ujian_id', $ujian->id)->count();
        $jawabanCount = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $id)
            ->where('optionmulti_id', '!=', null)
            ->count();
        $nextQuiz = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $request->ujian_id)
            ->where('optionmulti_id', '0')->first();
        $quizPanel = Jawabanmulti::where('siswa_id', $request->siswaId)
            ->where('ujian_id', $id)->orderBy('id', 'asc')->get();
        $soal = [];
        if ($jawabanCount >= $quizCount) {
            // return 'all soal done pages';
        } else {
            $soal = Soalmulti::where('id', $nextQuiz->soalmulti_id)->with(['OptionMulti'])->first();
        }
        if ($request->byPanel) {
            $jawaban = Jawabanmulti::where('siswa_id', $request->siswaId)
                ->where('ujian_id', $request->ujian_id)
                ->where('soalmulti_id', $request->byPanel)->first();
            $soal = Soalmulti::where('id', $request->byPanel)->with(['OptionMulti'])->first();
            $soal->jawabanSiswa = $jawaban->optionmulti_id;
        }

        $opts = ['A', 'B', 'C', 'D', 'E'];
        return view('fe_page.do_quiz_preview')->with([
            'quizCount' => $quizCount,
            'quiz' => $ujian,
            'q' => $soal,
            'index' => 0, //$count,
            'opts' => $opts,
            'quizPanel' => $quizPanel,
        ]);
    }

    public function postQuiz(Request $request)
    {
        try {
            $request->siswaId = 13;
            $data = Jawabanmulti::where('siswa_id', $request->siswaId)
                ->where('ujian_id', $request->ujianId)
                ->where('soalmulti_id', $request->soalId)->first();
            $data->optionmulti_id = $request->jawabanId;
            $data->jawabanku = $request->jawabanId;
            $data->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function finishQuiz(Request $request)
    {
        return 'finish here';
        return $request->all();
    }

    public function ujianStore(Request $request)
    {
        try {
            $request['ujian_jenis'] = 1;
            $request['ujian_slug'] = Str::slug($request['ujian_name']) . '-' . Str::random(5);
            Ujian::create($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Materi baru ditambahkan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
