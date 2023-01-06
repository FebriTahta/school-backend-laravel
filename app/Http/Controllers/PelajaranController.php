<?php

namespace App\Http\Controllers;
use App\Models\Mapelmaster;
use App\Models\Materi;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    public function mapel_mapelmaster($mapelmaster_id)
    {
        $mapelmaster = Mapelmaster::findOrFail($mapelmaster_id);
        $materi = Materi::where('mapelmaster_id', $mapelmaster_id)->get();
        return view('fe_page.mapel_master',['mapelmaster'=> $mapelmaster, 'materi'=> $materi]);
    }
}
