<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Siswa;
use DataTables;
use DB;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function admin_siswa(Request $request)
    {
        if ($request->ajax()) {
            # code...

        }

        return view('be_page.siswa');
    }

    public function siswa_kelas($kelas_id,Request $request)
    {
        $data = Siswa::where('kelas_id', $kelas_id)->with(['kelas'])->get();
        return DataTables::of($data)
        ->addColumn('opsi', function($data){
            $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
            data-toggle="modal" data-target="#modaldel2"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
            $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-jurusan_name="'.$data->jurusan_name.'"
            data-toggle="modal" data-target="#modaledit2"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
            return $btn;
        })
        ->addColumn('status', function($data){
            $status;
            if ($data->siswa_status == 'aktif') {
                # code...
                $status = '<button class="btn btn-sm btn-info" data-id="'.$data->id.'" data-toggle="modal" data-target="#modalstatus"
                 data-status="'.$data->siswa_status.'" data-kata="Apa anda yakin akan menonaktifkan status siswa ini ?">'.$data->siswa_status.'</button>';
            }else {
                # code...
                $status = '<button class="btn btn-sm btn-warning" data-id="'.$data->id.'" data-toggle="modal" data-target="#modalstatus"
                 data-status="'.$data->siswa_status.'" data-kata="Apa anda yakin akan mengaktifkan status siswa ini ?">non aktif</button>';
            }
            return $status;
        })
        ->rawColumns(['opsi','status'])
        ->make(true);
    }

    public function status_siswa(Request $request)
    {
        $siswa = Siswa::where('id', $request->id)->first();
        if ($request->status == 'aktif') {
            # code...
            $siswa->update([
                'siswa_status' => 'off'
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'status siswa ('.$siswa->siswa_name.') telah di nonaktifkan',
                'data' => $siswa->siswa_status,
            ]);
        }else {
            # code...
            $siswa->update([
                'siswa_status' => 'aktif'
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'status siswa ('.$siswa->siswa_name.') telah di diaktifkan',
                'data' => $siswa->siswa_status,
            ]);
        }
    }
}
