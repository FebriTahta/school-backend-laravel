<?php

namespace App\Http\Controllers;
use App\Models\Guru;
use App\Models\Mapelmaster;
use DataTables;
use Validator;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function admin_guru(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Guru::with(['kelas'])->get();
            return DataTables::of($data)
            ->addColumn('photos', function($data){
                $pho;
                if ($data->photo == null || $data->photo == "") {
                    # code...
                    $pho = '<span style="color:red">kosong</span>';
                }else {
                    # code...
                    $pho = '<img style="max-width:300px" src="'.$data->image.'" alt="">';
                }
                return $pho;
            })
            ->addColumn('opsi', function($data) {
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modaldel"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-toggle="modal" data-target="#modaledit"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            })
            ->addColumn('stats',function($data){
                $sts;
                if ($data->guru_status == "aktif") {
                    # code...
                    $sts = '<button class="btn btn-sm btn-primary">aktif</button>';
                }else{
                    $sts = '<button class="btn btn-sm btn-warning">tidak aktif</button>';
                }
                return $sts;
                
            })
            ->rawColumns(['photos','opsi','stats'])
            ->make(true);
        }
        return view('be_page.guru');
    }

    public function total_guru(Request $request)
    {
        $data = Guru::count();
        if ($data > 0) {
            # code...
            return response()->json([
                'status' => 200,
                'message' => 'menampilkan '.$data.' data guru',
                'data' => $data,
            ]);
        }else {
            # code...
            return response()->json([
                'status' => 400,
                'message' => 'tidak ditemukan data guru',
                'data' => $data,
            ]);
        }
    }

    public function post_mapel_master(Request $request)
    {
        foreach ($request->mapel_id as $key => $value) {
            # code...
            Mapelmaster::create([
                'guru_id'=> $request->guru_id,
                'mapel_id'=> $request->mapel_id[$key],
                'kelas_id'=> $request->id,
            ]);
        }

        return response()->json([
            'status'=> 200,
            'message'=> 'Guru pengampuh mapel telah ditambahkan'
        ]);
    }
}
