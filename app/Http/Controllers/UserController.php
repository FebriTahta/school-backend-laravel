<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\User;
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
        return view('be_page.user',compact('total_user'));
    }
}
