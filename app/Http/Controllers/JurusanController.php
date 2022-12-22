<?php

namespace App\Http\Controllers;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Tingkat;
use Validator;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DB;

class JurusanController extends Controller
{
    public function admin_jurusan_kelas_page(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Kelas::with(['jurusan','tingkat'])->withCount('siswa')->orderBy('jurusan_id')->get();
            return DataTables::of($data)
            ->addColumn('tingkatan_kelas', function($data) {
                return $data->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->addColumn('opsi', function($data) {
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modaldel"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-jurusan_name="'.$data->jurusan->jurusan_name.'"
                data-kelas_name="'.$data->kelas_name.'" data-jurusan_id="'.$data->jurusan_id.'" data-toggle="modal" data-target="#modaledit"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            })
            ->addColumn('siswa', function($data){
                return number_format($data->siswa_count).' - siswa';
            }) 
            ->rawColumns(['kelas_jurusan','opsi','siswa','tingkatan_kelas'])
            ->make(true);
        }
        $jurusan = Jurusan::get();
        $tingkat = Tingkat::get();
        return view('be_page.jurusan',['jurusan' => $jurusan, 'tingkat' => $tingkat]);
    }

    public function total_jurusan_kelas(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $jurusan = Jurusan::count();
            $kelas   = Kelas::count();

            return response()->json([
                'status' => 200,
                'data' => [
                    'kelas' => $kelas,
                    'jurusan' => $jurusan,
                ]
            ]);
        }
    }

    public function post_jurusan_kelas(Request $request) {
        if ($request->ajax()) {
            # code...
            if ($request->keterangan == 'new') {
                # code...
                $validator = Validator::make($request->all(),[
                    'jurusan_name' => 'required',
                    'total_kelas' => 'required'
                ]);

                if ($validator->fails()) {
                    # code...
                    return response()->json([
                        'status' => 400,
                        'message'=> $validator->messages()
                    ]);
                }else {
                    # code...
                    $exist = Jurusan::where('jurusan_name', $request->jurusan_name)->first();
                    if (!$exist) {
                        # code...
                        DB::beginTransaction();
                        try {
                            //code...
                            $jurusan = Jurusan::create([
                                'jurusan_name' => $request->jurusan_name,
                                'jurusan_slug' => Str::slug($request->jurusan_name),
                            ]);
    
                            $kelas = Kelas::where('jurusan_id', $jurusan->id)->count();
                            $total = $kelas + $request->total_kelas;
                            for ($i=$kelas; $i < $total ; $i++) { 
                                # code...
                                $kelas_baru =  [
                                    'kelas_name' => $i+1,
                                    'jurusan_id' => $jurusan->id,
                                ];
                                Kelas::insert($kelas_baru);
                            }  
                            DB::commit();

                        } catch (Exception $e) {
                            //throw $th;
                            DB::rollback();
                        }
                        
                        return response()->json([
                            'status' => 200,
                            'message' => 'new data has been updated',
                        ]);
                        
                    }else {
                        # code...
                        return response()->json([
                            'status' => 400,
                            'message' => ['jurusan tersebut sudah terdaftar'],
                        ]);
                    }
                }
            }else {
                # code...
                $validator = Validator::make($request->all(),[
                    'jurusan_id' => 'required',
                    'total_kelas' => 'required'
                ]);

                if ($validator->fails()) {
                    # code...
                    return response()->json([
                        'status' => 400,
                        'message'=> $validator->messages()
                    ]);
                }else {

                    $jurusan = Jurusan::where('id', $request->jurusan_id)->first();
                    $kelas   = Kelas::where('jurusan_id', $jurusan->id)->count();
                    $total = $kelas + $request->total_kelas;
                    for ($i=$kelas; $i < $total ; $i++) { 
                        # code...
                        $kelas_baru =  [
                            'kelas_name' => $i+1,
                            'jurusan_id' => $jurusan->id,
                        ];
                        Kelas::insert($kelas_baru);
                    }
                    
                    return response()->json([
                        'status' => 200,
                        'message' => 'new data has been updated',
                    ]);
                }
            }
        }
    }

    public function jurusan_dropdown(Request $request)
    {
        $jurusan = Jurusan::get();
        return response()->json([
            'status' => 200,
            'message' => 'menampilkan data jurusan',
            'data' => $jurusan,
        ]);
    }

    public function tingkat_dropdown(Request $request)
    {
        $tingkat = Tingkat::get();
        return response()->json([
            'status' => 200,
            'message' => 'menampilkan data jurusan',
            'data' => $tingkat,
        ]);
    }

    public function remove_kelas(Request $request)
    {   
        $kelas = Kelas::where('id',$request->id)->withCount('siswa')->first();
        if ($kelas->siswa_count > 0) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => 'tidak dapat menghapus kelas / jurusan yang memiliki siswa',
            ]);
            
        }else {
            # code...
            $kelas->delete();
            return response()->json([
                'status' => 200,
                'message' => 'data has been deleted',
            ]);
        }
        
    }

    public function remove_jurusan(Request $request)
    {   
        $jurusan = Jurusan::where('id',$request->id)->withCount('kelas')->first();
        if ($jurusan->kelas_count > 0) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => 'tidak dapat menghapus jurusan yang memiliki kelas',
            ]);
           
        }else {
            # code...
            $jurusan->delete();
            return response()->json([
                'status' => 200,
                'message' => 'data has been deleted',
            ]);
        }
        
    }

    public function change_dropdown_jurusan(Request $request, $jurusan_id)
    {
        if ($request->ajax()) {
            # code...
            $data = Kelas::where('jurusan_id', $jurusan_id)->withCount('siswa')->with(['jurusan','tingkat'])->get();
            return DataTables::of($data)
            ->addColumn('tingkatan_kelas', function($data) {
                return $data->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->addColumn('opsi', function($data) {
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modaldel"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-jurusan_name="'.$data->jurusan->jurusan_name.'"
                data-kelas_name="'.$data->kelas_name.'" data-jurusan_id="'.$data->jurusan_id.'" data-toggle="modal" data-target="#modaledit"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            }) 
            ->addColumn('siswa', function($data){
                return number_format($data->siswa_count).' - siswa';
            }) 
            ->rawColumns(['kelas_jurusan','opsi','siswa','tingkatan_kelas'])
            ->make(true);
        }
    }

    public function change_dropdown_tingkat(Request $request, $tingkat_id)
    {
        if ($request->ajax()) {
            # code...
            $data = Kelas::where('tingkat_id', $tingkat_id)->withCount('siswa')->with(['jurusan','tingkat'])->get();
            return DataTables::of($data)
            ->addColumn('tingkatan_kelas', function($data) {
                return $data->tingkat->tingkat_name;
            })
            ->addColumn('kelas_jurusan', function($data) {
                return $data->jurusan->jurusan_name.' '.$data->kelas_name;
            })
            ->addColumn('opsi', function($data) {
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modaldel"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-jurusan_name="'.$data->jurusan->jurusan_name.'"
                data-kelas_name="'.$data->kelas_name.'" data-jurusan_id="'.$data->jurusan_id.'" data-toggle="modal" data-target="#modaledit"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            }) 
            ->addColumn('siswa', function($data){
                return number_format($data->siswa_count).' - siswa';
            }) 
            ->rawColumns(['kelas_jurusan','opsi','siswa','tingkatan_kelas'])
            ->make(true);
        }
    }

    public function daftar_jurusan(Request $request)
    {
        if ($request->ajax())
        {
            # code...
            $data = Jurusan::with('kelas')->withCount('kelas')->get();
            return DataTables::of($data)
            ->addColumn('total_kelas',function($data){
                return number_format($data->kelas_count).' - kelas';
            })
            ->addColumn('opsi', function($data){
                $btn  = ' <button class="btn btn-xs btn-danger" data-id="'.$data->id.'"
                data-toggle="modal" data-target="#modaldel2"><i style="margin-left: 15px" class="icon icon-trash"></i></button>';
                $btn .= ' <button class="btn btn-xs btn-info" data-id="'.$data->id.'" data-jurusan_name="'.$data->jurusan_name.'"
                data-toggle="modal" data-target="#modaledit2"><i style="margin-left: 15px" class="icon icon-pencil"></i></button>';
                return $btn;
            })
            ->rawColumns(['total_kelas','opsi'])
            ->make(true);
        }
    }   

    public function update_kelas(Request $request)
    {
        $kelas = Kelas::where('id', $request->id)->first();
        $exist = Kelas::where('kelas_name', $request->kelas_name)->where('jurusan_id', $request->jurusan_id)->first();
        if ($exist) {
            # code...
            if ($exist->id == $request->id) {
                # jika sama maka update code...
                $kelas->update([
                    'kelas_name' => $request->kelas_name
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'nama kelas berhasil dirubah'
                ]);
            }else {
                # tidak dapat diupdate karena bertabrakan dengan kelas lain code...
                return response()->json([
                    'status' => 400,
                    'message' => 'terdapat nama kelas yang sama pada jurusan yang sama'
                ]);
            }
        }else {
            # kelas baru code...
            $kelas->update([
                'kelas_name' => $request->kelas_name
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'nama kelas berhasil dirubah'
            ]);
        }
    }

    public function update_jurusan(Request $request) 
    {
        $data = Jurusan::where('id', $request->id)->first();
        $exist = Jurusan::where('jurusan_name', $request->jurusan_name)->first();
        if ($exist) {
            # code...
            if ($exist->id == $request->id) {
                # code...
                $data->update([
                    'jurusan_name'=> $request->jurusan_name
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'jurusan berhasil diperbarui'
                ]);
            }else {
                # code...
                return response()->json([
                    'status'=> 400,
                    'message' => 'terdapat jurusan dengan nama yang sama'
                ]);
            }
        }else {
            # code...
            $data->update([
                'jurusan_name'=> $request->jurusan_name
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'jurusan berhasil diperbarui'
            ]);
        }
    }

    public function post_tingkatan_kelas(Request $request)
    {
        $tingkat_name = $request->tingkat_name;
        
    }

}
