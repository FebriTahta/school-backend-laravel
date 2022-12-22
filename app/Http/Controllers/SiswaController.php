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
}
