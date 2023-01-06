<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\SiswaImport;
use App\Imports\GuruImport;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function import_data_siswa(Request $request)
    {
        $kelas = Kelas::where('id', $request->kelas_id)->with('angkatan')->first();
        Excel::import(new SiswaImport($kelas),request()->file('file'));        
        return redirect()->back()->with('success','data siswa berhasil diimport');
    }

    public function import_data_guru()
    {
        Excel::import(new GuruImport(),request()->file('file'));        
        return redirect()->back()->with('success','data guru berhasil diimport');
    }
}
