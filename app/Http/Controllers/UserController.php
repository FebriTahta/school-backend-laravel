<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Angkatan;
use Illuminate\Support\Str;
use Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function daftar_user(Request $request)
    {  
        if ($request->ajax()) {
            # code...
            $data = User::get();
            return DataTables::of($data)
            ->make(true);
        }
        $total_user = User::count();
        $angkatan = Angkatan::get();
        return view('be_page.user',compact('total_user','angkatan'));
    }

    public function user_baru(Request $request)
    {
        if ($request->userbaru == 'userguru') {
            # code...
            $validator = Validator::make($request->all(), [
                'guru_name'       => 'required',
                'guru_nip'       => 'required',
            ]);
    
            if ($validator->fails()) {
                # code...
                return response()->json([
                    'status' => 400,
                    'message' => $validator->messages(),
                ]);
            } else {

                DB::beginTransaction();

                try {
                    $usr = new User;
                    $usr->username = $request->guru_name;
                    $usr->pass = $request->guru_nip;
                    $usr->password = Hash::make($request->guru_nip);
                    $usr->role = 'guru';
                    $usr->save();
    
                    $gur = DB::table('gurus')->insert(
                        [
                            'user_id' => $usr->id,
                            'guru_nip'=> $request->guru_nip,
                            'guru_name'=> $request->guru_name,
                            'guru_slug'=> Str::slug($request->guru_name),
                            'guru_status'=> 'aktif'
                        ]
                    );
                    
                    DB::commit();
                    return response()->json([
                        'status'=> 200,
                        'message'=> 'Guru baru berhasil didaftarkan'
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Galat input'
                    ]);
                }
                
            }
        }else {
            # code...
            $validator = Validator::make($request->all(), [
                'siswa_name'       => 'required',
                'siswa_nik'       => 'required',
                'angkatan_id'       => 'required',
            ]);
    
            if ($validator->fails()) {
                # code...
                return response()->json([
                    'status' => 400,
                    'message' => $validator->messages(),
                ]);
            } else {

                DB::beginTransaction();
                try {
                    $usr = new User;
                    $usr->username = $request->siswa_name;
                    $usr->pass = $request->siswa_nik;
                    $usr->password = Hash::make($request->siswa_nik);
                    $usr->role = 'siswa';
                    $usr->save();
    
                    $sis = DB::table('siswas')->insert(
                        [
                            'user_id' => $usr->id,
                            'siswa_nik'=> $request->siswa_nik,
                            'siswa_name'=> $request->siswa_name,
                            'angkatan_id'=> $request->angkatan_id,
                            'siswa_slug'=> Str::slug($request->siswa_name),
                            'siswa_status'=> 'aktif'
                        ]
                    );
    
                    DB::commit();
                    return response()->json([
                        'status'=> 200,
                        'message'=> 'Siswa baru berhasil didaftarkan'
                        // .$usr->id.'-'
                        // .$request->siswa_nik.'-'
                        // .$request->angkatan_id.'-'
                        // .$request->siswa_name
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Galat input'
                    ]);
                }
            }
        }
    }

    public function ubah_password(Request $request)
    {
        $id = $request->user_id;
        $data = User::where('id', $id)->update(
            [
                'username' => $request->username,
                'pass'     => $request->pass,
                'password' => Hash::make($request->pass),

            ]
        );

        return response()->json(
            [
                'status' => 200,
                'message' => 'credential users has been updated',
            ]
        );
    }
}
