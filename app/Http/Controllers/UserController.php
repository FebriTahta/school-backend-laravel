<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\User;
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
        return view('be_page.user',compact('total_user'));
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
