<?php

namespace App\Http\Controllers;
use App\Models\Mapelmateri;
use App\Models\Materi;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function post_materi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'materi_name'       => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }else {
            # code...
            $data = Materi::updateOrCreate(
                [
                    'id'=> $request->id,
                ],
                [
                    'mapelmaster_id'=> $request->mapelmaster_id,
                    'guru_id' => $request->guru_id,
                    'kelas_id' => $request->kelas_id,
                    'uploader_nip' => $request->uploader_nip,
                    'materi_name' => $request->materi_name,
                    'materi_slug' => Str::slug($request->materi_name)
                ]
            );

            return response()->json([
                'status'=> 200,
                'message' => 'Materi baru ditambahkan'
            ]);
        }
    }
}
