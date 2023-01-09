<?php

namespace App\Http\Controllers;
use App\Models\Mapelmaster;
use App\Models\Materi;
use App\Models\Vids;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    public function mapel_mapelmaster($mapelmaster_id)
    {
        $mapelmaster = Mapelmaster::findOrFail($mapelmaster_id);
        $materi = Materi::where('mapelmaster_id', $mapelmaster_id)
        ->withCount('vids','docs','ujian')->get();
        $vid = [];
        $doc = [];
        foreach ($materi as $key => $value) {
            # code...
            $vid[] = $value->vids_count;
            $doc[] = $value->docs_count;
        }
        $vid_total = array_sum($vid);
        $doc_total = array_sum($doc);
        return view('fe_page.detail_mapel',['mapelmaster'=> $mapelmaster, 'materi'=> $materi,'vid_total' => $vid_total,'doc_total'=> $doc_total]);
    }
}
