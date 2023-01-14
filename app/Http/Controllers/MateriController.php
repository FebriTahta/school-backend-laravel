<?php

namespace App\Http\Controllers;
use App\Models\Mapelmateri;
use App\Models\Materi;
use App\Models\Vids;
use App\Models\Docs;
use Response;
use File;
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

    public function post_vids(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mapelmaster_id'  => 'required',
            'materi_id'       => 'required',
            'vids_name'       => 'required',
            'vids_desc'       => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 200,
                'message' => $validator->messages(),
            ]);
        }else {
            # code...
            $source = $request->vids_link;
            $base = 'https://www.youtube.com/embed/';
            if (substr($source,0,30) !== $base) {
                # code...
                return response()->json([
                    'status' => 400,
                    'message' => ['sumber url salah & tidak dapat diterima'],
                ]);
            }else {
                # code...
                $data = Vids::updateOrCreate(
                    [
                        'id' => $request->id,
                    ],
                    [
                        'mapelmaster_id' => $request->mapelmaster_id,
                        'vids_name' => $request->vids_name,
                        'vids_link' => $source,
                        'vids_desc' => $request->vids_desc,
                        'materi_id' => $request->materi_id,
                    ]
                );
    
                return response()->json([
                    'status' => 200,
                    'message' => 'video baru berhasil ditambahkan'
                ]);
            }
        }
    }

    public function post_docs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mapelmaster_id'  => 'required',
            'materi_id'       => 'required',
            'docs_file'       => 'required|mimes:pdf,docx,csv,xlsx',
            'docs_name'       => 'required',
            'docs_desc'       => 'required|'
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 200,
                'message' => $validator->messages(),
            ]);
        }else {
            # code...
            if($request->hasFile('docs_file')) {
                # code...
                if ($request->id !== null) {
                    # code...
                    $exist = Docs::findOrFail($request->id);
                    if ($exist) {
                        # code...
                        if(File::exists(public_path('docs_files/'.$exist->docs_files)))
                        {
                            File::delete(public_path('docs_files/'.$exist->docs_files));
                        }
                    }
                }

                $filename    = time().'_'.$request->docs_file->getClientOriginalName();
                $request->file('docs_file')->move('docs_files/',$filename);

                $data = Docs::updateOrCreate(
                    [
                        'id' => $request->id,
                    ],
                    [
                        'mapelmaster_id' => $request->mapelmaster_id,
                        'materi_id' => $request->materi_id,
                        'docs_file' => $filename,
                        'docs_name' => $request->docs_name,
                        'docs_desc' => $request->docs_desc,
                    ]
                );
            }else {
                # code...
                $data = Docs::updateOrCreate(
                    [
                        'id' => $request->id,
                    ],
                    [
                        'materi_id' => $request->materi_id,
                        'docs_name' => $request->docs_name,
                        'docs_desc' => $request->docs_desc,
                    ]
                );
            }

            return response()->json([
                'status' => 200,
                'message' => 'Dokumen barhasil ditambahkan ke materi terkait'
            ]);
        }
    }

    public function download_docs($docs_id)
    {
        $docs = Docs::findOrFail($docs_id);
        $filepath = public_path('docs_files/'.$docs->docs_file);
        return Response::download($filepath); 
    }
}
