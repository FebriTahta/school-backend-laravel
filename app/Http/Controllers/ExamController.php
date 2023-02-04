<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use DataTables;
use App\Models\Exam;
use App\Models\Kelas;
use App\Models\Jawabanexam;
use App\Models\Soalexam;
use App\Models\Optionexam;
use App\Models\Siswa;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function manajemen_ujian(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Exam::with('soalexam','mapel','kelas')->withCount('soalexam','kelas')->get();
            return DataTables::of($data)
            ->addColumn('mapel',function($data){
                return strtoupper($data->mapel->mapel_name);
            })
            ->addColumn('kelas',function($data){
                return '<a href="#" data-toggle="modal" data-target="#modalkelas"
                    data-id='.$data->id.'>'.$data->kelas->count().' - KELAS'.'</a>';
            })
            ->addColumn('opsi', function($data){
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modalhapusexam"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-mapel_id="'.$data->mapel_id.'"
                data-exam_jenis="'.$data->exam_jenis.'" data-exam_lamapengerjaan="'.$data->exam_lamapengerjaan.'" data-exam_datetimestart="'.$data->exam_datetimestart.'"
                data-exam_datetimeend="'.$data->exam_datetimeend.'" data-exam_status="'.$data->exam_status.'"
                data-toggle="modal" data-target="#modaleditexam"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            })
            ->rawColumns(['mapel','opsi','kelas'])
            ->make(true);
        }

        $mapel = Mapel::get();
        return view('be_page.manajemen_ujian',['mapel'=>$mapel]);
    }

    public function exam_kelas(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Kelas::with(['jurusan','angkatan','mapel'])->withCount('siswa','mapel','guru')->orderBy('jurusan_id')->get();
            return DataTables::of($data)
            ->addColumn('angkatan_kelas', function($data) {
                return $data->angkatan->angkatan_name. ' - '.$data->angkatan->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->rawColumns(['kelas_jurusan','angkatan_kelas'])
            ->make(true);
        }
    }

    public function exam_remove(Request $request)
    {
        $exam = Exam::where('id', $request->id)->withCount('soalexam','jawabanexam')->first();
        if ($exam->soalexam_count > 0) {
            # code...
            $soal = Soalexam::where('exam_id', $request->id)->get();
            foreach ($soal as $key => $value) {
                # banyak soal code...
                $option = Optionexam::where('soalexam_id', $value)->delete();
            }
            Soalexam::where('exam_id', $request->id)->delete();
        }
        if ($exam->jawabanexam_count > 0) {
            # code...
            Jawabanexam::where('exam_id', $request->id)->delete();
        }
        $exam->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Exam / Ujian berhasil dihapus'
        ]);
    }

    public function kelas_keseluruhan(Request $request, $exam_id)
    {
        $exam = Exam::where('id', $exam_id)->first();
        $kelas_id = [];
        foreach ($exam->kelas as $key => $value) {
            # code...
            $kelas_id[] = $value->id;
        }
        
        $data = Kelas::whereNotIn('id', $kelas_id)->with(['jurusan','angkatan','mapel'])->withCount('siswa','mapel','guru')->orderBy('jurusan_id')->get();
            return DataTables::of($data)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="sub_chk" data-id="'.$data->id.'">';
            })
            ->addColumn('angkatan_kelas', function($data) {
                return $data->angkatan->angkatan_name. ' - '.$data->angkatan->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->rawColumns(['kelas_jurusan','angkatan_kelas','check'])
            ->make(true);
    }

    public function kelas_saatini(Request $request, $exam_id)
    {
        $exam = Exam::where('id', $exam_id)->first();
        $kelas_id = [];
        foreach ($exam->kelas as $key => $value) {
            # code...
            $kelas_id[] = $value->id;
        }
        
        $data = Kelas::whereIn('id', $kelas_id)->with(['jurusan','angkatan','mapel'])->withCount('siswa','mapel','guru')->orderBy('jurusan_id')->get();
            return DataTables::of($data)
            ->addColumn('angkatan_kelas', function($data) {
                return $data->angkatan->angkatan_name. ' - '.$data->angkatan->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="sub_chk2" data-id="'.$data->id.'">';
            })
            ->rawColumns(['kelas_jurusan','angkatan_kelas','check'])
            ->make(true);
    }

    public function tambah_kelas_ke_exam(Request $request)
    {
        $exam = Exam::where('id',$request->idexam)->first();
        $kelas_id = $request->kelas_id;
        $kelas = Kelas::whereIn('id', explode(",",$kelas_id))->get();
        foreach ($kelas as $key => $value) {
            # code...
            $exam->kelas()->attach($value->id);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ujian berhasil ditambahkan ke kelas terkait '
        ]);   
    }

    public function remove_kelas_di_exam(Request $request)
    {
        $exam = Exam::where('id',$request->idexam2)->first();
        $kelas_id = $request->kelas_id2;
        $kelas = Kelas::whereIn('id', explode(",",$kelas_id))->get();
        foreach ($kelas as $key => $value) {
            # code...
            $exam->kelas()->detach($value->id);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ujian berhasil dihapus ke kelas terkait '
        ]);   
    }

    public function doExam(Request $request,$ujian_id,$mapel_id,$kelas_id)
    {
        $request->siswaId =  Siswa::where('user_id', Auth::id())->first()->id;
        $request->ujian_id = $ujian_id;
        if ($request->jawabanId) {
            $data = Jawabanexam::where('siswa_id', $request->siswaId)
                ->where('exam_id', $request->ujian_id)
                ->where('soalexam_id', $request->soalId)->first();
            $data->optionexam_id = $request->jawabanId;
            $data->jawabanku = $request->jawabanId;
            $data->save();
        }
        $quiz = Soalexam::where('exam_id', $ujian_id)->inRandomOrder()->get();
        $cond = Jawabanexam::where('siswa_id', $request->siswaId)
            ->where('exam_id', $request->ujian_id);
        if ($cond->count() <= 0) {
            foreach ($quiz as $key => $value) {
                Jawabanexam::firstOrCreate([
                    'siswa_id' => $request->siswaId,
                    'kelas_id' => $request->kelas_id,
                    'mapel_id' => $request->mapel_id,
                    'exam_id' => $request->ujian_id,
                    'soalexam_id' => $value->id,
                    'optionexam_id' => null,
                    'jawabanku' => null,
                ]);
            }
        }
        $ujian = Exam::find($request->ujian_id);
        $now = Carbon::parse(Carbon::now());
        if ($now < $ujian->exam_datetimestart) {
            #abaikan
            // return 'belum dibuka pages here'; //bisa redirect pages
            // $status = 0;
            // return redirect()->route('home')->with('warning', 'ujian belum dibuka');
        }
        if ($now > $ujian->exam_datetimeend) {
            // return 'expired'; //bisa redirect pages
            // $status = 2;
            return redirect()->route('home')->with('success', 'ujian telah berakhir');
        }
        // 
        $quizCount = Soalexam::where('exam_id', $ujian->id)->count();
        $jawabanCount = Jawabanexam::where('siswa_id', $request->siswaId)
            ->where('exam_id', $ujian_id)
            // ->where('optionmulti_id', '!=', 0)
            ->count();
        $nextQuiz = Jawabanexam::where('siswa_id', $request->siswaId)
            ->where('exam_id', $request->ujian_id)
            // ->where('optionmulti_id', '!=', 0)
            ->first();
        $quizPanel = Jawabanexam::where('siswa_id', $request->siswaId)
            ->where('exam_id', $ujian_id)
            // ->where('optionmulti_id', '!=', 0)
            ->orderBy('id', 'asc')
            ->get();

        $soal = Soalexam::where('exam_id', $request->ujian_id)->with(['optionexam'])->orderBy('id', 'desc')->first();
        // $quiz = Soalmulti::inRandomOrder()->Get();
        // $arx = Jawabanmulti::where('siswa_id', $request->siswaId)
        //     ->where('ujian_id', $request->ujian_id)->orderBy('id', 'asc')->orderBy('id', 'asc')->pluck('id')->toArray();
        if ($jawabanCount >= $quizCount) {
            // return 'all soal done pages';
        } else {
            $soal = Soalexam::where('id', $nextQuiz->soalmulti_id)->orderBy('id', 'desc')->with(['optionexam'])->first();
        };
        
        if ($request->byPanel) {
            $jawaban = Jawabanexam::where('siswa_id', $request->siswaId)
                ->where('exam_id', $request->ujian_id)
                ->where('soalexam_id', $request->byPanel)->first();
            $soal = Soalexam::where('id', $request->byPanel)->with(['optionexam'])->first();
            $soal->jawabanSiswa = $jawaban->optionmulti_id;
            // foreach ($arx as $key => $value) {
            //     if ($value == $soal->id) $indx = $key + 1;
            // }
        }
        $indx = 1;
        $arr = Jawabanexam::where('siswa_id', $request->siswaId)
            ->where('exam_id', $request->ujian_id)->orderBy('id', 'asc')->pluck('soalexam_id')->toArray();
        foreach ($arr as $key => $value) {
            # code...
            // return $value;
            if ($value == $soal->id) {
                // return $value . ';'.$soal->id;
                $indx = $key ;
                // return $key;
            }
        }
        // $indx = array_search($soal->id, $arr);
        // return $indx;
        $indx++;
        $opts = ['A', 'B', 'C', 'D', 'E'];
        return view('fe_page.do_exam')->with([
            'quizCount' => $quizCount,
            'quiz' => $ujian,
            'indx' => $indx,
            'q' => $soal,
            'index' => $indx, //$count,
            'opts' => $opts,
            'quizPanel' => $quizPanel,
            'kelas_id'=> $kelas_id,
            'mapel_id'=> $mapel_id
        ]);
    }

    public function postExam(Request $request)
    {
        try {
            $request->siswaId =  Siswa::where('user_id', Auth::id())->first()->id;
            $data = Jawabanexam::where('siswa_id', $request->siswaId)
                ->where('mapel_id', $request->mapel_id)
                ->where('kelas_id', $request->kelas_id)
                ->where('exam_id', $request->exam_id)
                ->where('soalexam_id', $request->soalexam_id)->first();
            
            $data->optionexam_id = $request->jawabanId;
            $data->jawabanku = $request->optionexam_true;
            $data->save();

            return response()->json([
                'status'=>200,
                'data'=>'Jawaban dikirim'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function rekapNilai(Request $request)
    {
        $siswa = auth()->user()->siswa;
        $siswa_id = auth()->user()->siswa->id;
        if($request->ajax()){
            // $data = Exam::with('soalexam','mapel','kelas')->withCount('soalexam','kelas')->get();
            $data = $siswa->kelas->exam;
            return DataTables::of($data)
            ->addColumn('nilai',function($data)use ($siswa_id){
                $jawab = Jawabanexam::where('siswa_id',$siswa_id)->where('exam_id', $data->id)->get();
                $total = [];
                foreach ($jawab as $key => $value) {
                    # code...
                    $total[] = $value->jawabanku;
                }
                $totalsoal = $jawab->count();
                if($totalsoal > 0){
                    $hasil = (100 / $totalsoal) * array_sum($total);
                }else{
                    $hasil = '0';
                }
                return $hasil;
            })
            ->rawColumns(['nilai'])
            ->make(true);
        }
        
        return view('fe_page.rekap_nilai', ['siswa'=>$siswa]);
    }

    public function daftarPeringkat(Request $request)
    {
        $siswa_ini = auth()->user()->siswa;
        $kelas_id = $siswa_ini->kelas_id;
        // $siswa_seluruh = Siswa::where('kelas_id', $kelas_id)->get();
        // foreach($siswa_seluruh as $key => $item){
        //     $jawaban = Jawabankelas::where('kelas_id', $kelas_id)->where('siswa_id', $item->id)->get();

        // }
        
        // $ujian  = $siswa_ini->kelas->exam;
        // $nilai = [];
        // $nama_ujian = [];
        // foreach ($ujian as $key => $value) {
        //     # code...
        //     $jawabanku = Jawabanexam::where('exam_id', $value->id)->where('siswa_id', auth()->user()->siswa->id)->sum('jawabanku');
        //     if ($jawabanku > 0) {
        //         # code...
        //         $nilai[] = round(($jawabanku / Jawabanmulti::where('ujian_id', $value->id)->where('siswa_id', auth()->user()->siswa->id)->count()) * 100);
        //     }else {
        //         # code..
        //         $nilai[] = 0;
        //     }
             
        //     $nama_ujian[] = $value->ujian_name;
        // }

        // return implode(',',$nama_ujian);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $kelas = Kelas::where('id', $kelas_id)->first();

        $avg = [];
        foreach($siswa as $key=> $item){
            $ujian = $kelas->exam;
                                            
            $nilai = [];
            
            foreach ($ujian as $key => $value) {
                # code...
                $jawabanku = Jawabanexam::where('kelas_id', $kelas->id)
                                                    ->where('exam_id', $value->id)
                                                    ->where('siswa_id', $item->id)->sum('jawabanku');
                if ($jawabanku > 0) {
                    # code...
                    $nilai[] = ($jawabanku / Jawabanexam::where('exam_id', $value->id)->where('siswa_id', $item->id)->count()) * 100;
                }else {
                    # code...
                    $nilai[] = 0;
                }
            }
            $sum = array_sum($nilai);
            // $avg = '';
            if ($sum > 0) {
                # code...
                $avg[] = round($sum / $ujian->count());
            }else {
                # code...
                $avg[] = 0;
            }
        }
        return view('fe_page.peringkat', ['siswa'=>$siswa,'kelas'=>$kelas,'siswa_ini'=>$siswa_ini,'avg'=>$avg]);
    }
}
