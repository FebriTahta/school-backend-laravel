<?php

namespace App\Http\Controllers;
use App\Models\Guru;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home_lms()
    {
        $siswa = auth()->user()->siswa;
        return view('fe_page.landing',compact('siswa'));
    }

    public function home_lms_guru()
    {
        $guru = Guru::where('user_id',auth()->user()->id)->first();
        return view('fe_page.landing_guru',compact('guru'));
    }
}
