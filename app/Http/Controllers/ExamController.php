<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use DataTables;
use App\Models\Exam;
use App\Models\Kelas;
use App\Models\Jawabanexam;
use App\Models\Mapelmaster;
use App\Models\Soalexam;
use App\Models\Ranking;
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
        // return implode(',',$nama_ujian);
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $kelas = Kelas::where('id', $kelas_id)->first();
        //UTS1 UTS2 UAS1 UAS2
        $avg = [];
        $avg2 = [];
        $avg3 = [];
        $avg4 = [];
        foreach($siswa as $key=> $item){
            $ujian = $kelas->exam->where('exam_jenis', 'UTS SEMESTER 1');   
            $ujian2 = $kelas->exam->where('exam_jenis', 'UTS SEMESTER 2');   
            $ujian3 = $kelas->exam->where('exam_jenis', 'UAS SEMESTER 1');   
            $ujian4 = $kelas->exam->where('exam_jenis', 'UAS SEMESTER 2');   
            $nilai = [];
            $nilai2 = [];
            $nilai3 = [];
            $nilai4 = [];
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
            if ($sum > 0) {
                $avg[] = round($sum / $ujian->count());
            }else {
                $avg[] = 0;
            }

            foreach ($ujian2 as $key => $value) {
                # code...
                $jawabanku = Jawabanexam::where('kelas_id', $kelas->id)
                                        ->where('exam_id', $value->id)
                                        ->where('siswa_id', $item->id)->sum('jawabanku');
                if ($jawabanku > 0) {
                    # code...
                    $nilai2[] = ($jawabanku / Jawabanexam::where('exam_id', $value->id)->where('siswa_id', $item->id)->count()) * 100;
                }else {
                    # code...
                    $nilai2[] = 0;
                }
            }
            $sum2 = array_sum($nilai2);
            if ($sum2 > 0) {
                $avg2[] = round($sum2 / $ujian2->count());
            }else {
                $avg2[] = 0;
            }

            foreach ($ujian3 as $key => $value) {
                # code...
                $jawabanku = Jawabanexam::where('kelas_id', $kelas->id)
                                        ->where('exam_id', $value->id)
                                        ->where('siswa_id', $item->id)->sum('jawabanku');
                if ($jawabanku > 0) {
                    # code...
                    $nilai3[] = ($jawabanku / Jawabanexam::where('exam_id', $value->id)->where('siswa_id', $item->id)->count()) * 100;
                }else {
                    # code...
                    $nilai3[] = 0;
                }
            }
            $sum3 = array_sum($nilai3);
            if ($sum3 > 0) {
                $avg3[] = round($sum3 / $ujian3->count());
            }else {
                $avg3[] = 0;
            }

            foreach ($ujian4 as $key => $value) {
                # code...
                $jawabanku = Jawabanexam::where('kelas_id', $kelas->id)
                                        ->where('exam_id', $value->id)
                                        ->where('siswa_id', $item->id)->sum('jawabanku');
                if ($jawabanku > 0) {
                    # code...
                    $nilai4[] = ($jawabanku / Jawabanexam::where('exam_id', $value->id)->where('siswa_id', $item->id)->count()) * 100;
                }else {
                    # code...
                    $nilai4[] = 0;
                }
            }
            $sum4 = array_sum($nilai4);
            if ($sum4 > 0) {
                $avg4[] = round($sum4 / $ujian4->count());
            }else {
                $avg4[] = 0;
            }

            // Ranking
            $rank_uts1 = Ranking::where('kelas_id',$kelas_id)
                        ->where('ranking_jenis','UTS SEMESTER 1')
                        ->orderBy('ranking_rank','asc')->get();
            $myrank_uts1 = Ranking::where('kelas_id',$kelas_id)->where('siswa_id',$siswa_ini->id)
                        ->where('ranking_jenis','UTS SEMESTER 1')
                        ->orderBy('ranking_rank','asc')->first();
            $rank_uts2 = Ranking::where('kelas_id',$kelas_id)
                        ->where('ranking_jenis','UTS SEMESTER 2')
                        ->orderBy('ranking_rank','asc')->get();
            $myrank_uts2 = Ranking::where('kelas_id',$kelas_id)->where('siswa_id',$siswa_ini->id)
                        ->where('ranking_jenis','UTS SEMESTER 2')
                        ->orderBy('ranking_rank','asc')->first();
            $rank_uas1 = Ranking::where('kelas_id',$kelas_id)
                        ->where('ranking_jenis','UAS SEMESTER 1')
                        ->orderBy('ranking_rank','asc')->get();
            $myrank_uas1 = Ranking::where('kelas_id',$kelas_id)->where('siswa_id',$siswa_ini->id)
                        ->where('ranking_jenis','UAS SEMESTER 1')
                        ->orderBy('ranking_rank','asc')->first();
            $rank_uas2 = Ranking::where('kelas_id',$kelas_id)
                        ->where('ranking_jenis','UAS SEMESTER 2')
                        ->orderBy('ranking_rank','asc')->get();
            $myrank_uas2 = Ranking::where('kelas_id',$kelas_id)->where('siswa_id',$siswa_ini->id)
                        ->where('ranking_jenis','UAS SEMESTER 2')
                        ->orderBy('ranking_rank','asc')->first();
        }
        return view('fe_page.peringkat', ['siswa'=>$siswa,'kelas'=>$kelas,'siswa_ini'=>$siswa_ini
        ,'avg'=>$avg, 'avg2'=>$avg2, 'avg3'=>$avg3, 'avg4'=>$avg4, 'rank_uts1'=>$rank_uts1, 'myrank_uts1'=>$myrank_uts1
        ,'rank_uts2'=>$rank_uts2,'myrank_uts2'=>$myrank_uts2,'rank_uas1'=>$rank_uas1,'myrank_uas1'=>$myrank_uas1
        ,'rank_uas2'=>$rank_uas2,'myrank_uas2'=>$myrank_uas2
        ]);
    }


    public function data_ranking_kelas(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Kelas::with(['jurusan','angkatan'])->orderBy('jurusan_id')->get();
            return DataTables::of($data)
            ->addColumn('angkatan_kelas', function($data) {
                return $data->angkatan->angkatan_name. ' - '.$data->angkatan->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->addColumn('uts1', function($data) {
                if ($data->ranking->where('ranking_jenis','UTS SEMESTER 1')->count() > 0) {
                    # code...
                    return '<a href="uts1" data-kelas="'.$data->id.'" data-jenis="UTS SEMESTER 1"
                    data-toggle="modal" data-target="#modalrank" class="text-success">Update Peringkat UTS 1</a>';
                }else {
                    # code...
                    return '<a href="uts1" data-kelas="'.$data->id.'" data-jenis="UTS SEMESTER 1"
                    data-toggle="modal" data-target="#modalrank">Update Peringkat UTS 1</a>';
                }
            })
            ->addColumn('uts2', function($data) {
                if ($data->ranking->where('ranking_jenis','UTS SEMESTER 2')->count() > 0) {
                    return '<a href="uts2" data-kelas="'.$data->id.'" data-jenis="UTS SEMESTER 2"
                    data-toggle="modal" data-target="#modalrank" class="text-success">Update Peringkat UTS 2</a>';
                }else {
                    return '<a href="uts2" data-kelas="'.$data->id.'"
                    data-toggle="modal" data-target="#modalrank" data-jenis="UTS SEMESTER 2">Update Peringkat UTS 2</a>';
                }
            })
            ->addColumn('uas1', function($data) {
                if ($data->ranking->where('ranking_jenis','UAS SEMESTER 1')->count() > 0) {
                    return '<a href="uas1" data-kelas="'.$data->id.'" data-jenis="UAS SEMESTER 1"
                    data-toggle="modal" data-target="#modalrank" class="text-success">Update Peringkat UAS 1</a>';
                }else {
                    return '<a href="uas1" data-kelas="'.$data->id.'"
                    data-toggle="modal" data-target="#modalrank" data-jenis="UAS SEMESTER 1">Update Peringkat UAS 1</a>';
                }
            })
            ->addColumn('uas2', function($data) {
                if ($data->ranking->where('ranking_jenis','UAS SEMESTER 2')->count() > 0) {
                    return '<a href="uas2" data-kelas="'.$data->id.'" class="text-success"
                    data-toggle="modal" data-target="#modalrank" data-jenis="UAS SEMESTER 2">Update Peringkat UTS 2</a>';
                }else {
                    return '<a href="uas2" data-kelas="'.$data->id.'" 
                    data-toggle="modal" data-target="#modalrank" data-jenis="UAS SEMESTER 2">Update Peringkat UTS 2</a>';
                }
            })
            ->rawColumns(['kelas_jurusan','angkatan_kelas','uts1','uts2','uas1','uas2'])
            ->make(true);
        }

        return view('be_page.ranking_kelas');
    }

    public function update_rank(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $kelas = Kelas::where('id', $kelas_id)->first();
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();
        $avg = [];
        $jenis_exam = $request->jenis_exam;

        foreach($siswa as $key=> $item){
            $ujian = $kelas->exam->where('exam_jenis', $jenis_exam);
            $nilai = [];
            foreach ($ujian as $keys => $value) {
                # code...
                $jawabanku = Jawabanexam::where('kelas_id', $kelas->id)
                                        ->where('exam_id', $value->id)
                                        ->where('siswa_id', $item->id)->sum('jawabanku');
                if ($jawabanku > 0) {
                    # code...
                    $nilai[$keys] = ($jawabanku / Jawabanexam::where('exam_id', $value->id)->where('siswa_id', $item->id)->count()) * 100;
                }else {
                    # code...
                    $nilai[$keys] = 0;
                }
            }
            $sum = array_sum($nilai);
            if ($sum > 0) {
                $avg[$key] = round($sum / $ujian->count());
            }else {
                $avg[$key] = 0;
            }

            $rr = Ranking::updateOrCreate(['siswa_id'=>$item->id,'kelas_id'=>$kelas_id],
                [
                    'ranking_jenis'=> $jenis_exam,
                    'ranking_nilai'=> $avg[$key]
                ]
            );

            $lihat = $rr->select('ranking_nilai')->orderBy('ranking_nilai','desc')->get();
            foreach ($lihat as $x => $value) {
                # code...
                if (Ranking::where('siswa_id',$item->id)->where('kelas_id',$kelas_id)->select('ranking_nilai')->first() == $value) {
                    # code...
                    Ranking::where('siswa_id',$item->id)->where('kelas_id',$kelas_id)->update(['ranking_rank'=>$x+1]);
                }
            }
            
        }

        return response()->json([
            'status'=>200,
            // 'message'=> 'Ranking kelas telah di update'.implode(',',$rank).'-'.implode(',',$tes).'-'.$lihat
            'message'=> 'Ranking kelas telah di update'
        ]);
    }
}
