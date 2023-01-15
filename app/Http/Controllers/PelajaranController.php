<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapelmaster;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Vids;
use Crypt;
use Validator;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    public function mapel_mapelmaster($mapelmaster_id)
    {
        // $mapelmaster_id = Crypt::decrypt($mapelmaster_id);
        $mapelmaster = Mapelmaster::findOrFail($mapelmaster_id)->with('materi')->withcount('docs','vids','ujian','materi')->first();
        $guru_id = Guru::where('user_id', '=', auth()->user()->id)->first();
        $tugas = Tugas::where('guru_id', '=', $guru_id->id);
        return view('fe_page.detail_mapel',[
            'mapelmaster'=> $mapelmaster,
            'tugas'=> $tugas
        ]);
    }

    public function mapel_mapelmaster_siswa($mapelmaster_id)
    {
        // $mapelmaster_id = Crypt::decrypt($mapelmaster_id);
        $mapelmaster = Mapelmaster::findOrFail($mapelmaster_id)->with('materi')->withcount('docs', 'vids', 'ujian', 'materi')->first();
        return view('fe_page.detail_mapel_siswa', ['mapelmaster' => $mapelmaster]);
    }

    public function add_tugas_siswa(Request $request){

        // dd($request);
        
        $validator = Validator::make($request->all(), [
            'tugas_name'       => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }else {
            # code...
            $data = Tugas::updateOrCreate(
                [
                    'id'=> $request->id,
                ],
                [
                    'mapelmaster_id'=> $request->mapelmaster_id,
                    'guru_id' => $request->guru_id,
                    'kelas_id' => $request->kelas_id,
                    'uploader_nip' => $request->uploader_nip,
                    'tugas_name' => $request->tugas_name,
                    'tugas_desc' => $request->tugas_desc
                ]
            );

            return response()->json([
                'status'=> 200,
                'message' => 'Tugas baru ditambahkan'
            ]);
        }
    }
}
