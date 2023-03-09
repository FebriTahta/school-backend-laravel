<?php

namespace App\Http\Controllers;
use Cache;
use Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin_dashboard_page(Request $request)
    {
        return view('be_page.dashboard');
    }

    public function total_user_online(Request $request)
    {
        if ($request->ajax()) {
            # code...
            
            $user = User::whereNotNull('last_seen')->orderBy('last_seen', 'DESC')->get();
            $online = [];
            foreach ($user as $key => $value) {
                # code...
                if(Cache::has('user-is-online-' . $value->id)){
                    $online[] = 1;
                }
            }
            $semua   = User::count();
            $offline = $semua - array_sum($online);
            return response()->json([
                'status'=>200,
                'message'=>'total user online',
                'data'=>array_sum($online),
                'offline'=>$offline,
            ]);
        }
    }

    public function last_four_online(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $users = User::select("*")
                    ->whereNotNull('last_seen')
                    ->orderBy('last_seen', 'DESC')
                    ->limit(4)->get();
            $last_seen = [];
            foreach ($users as $key => $value) {
                # code...
                $last_seen[] = Carbon\Carbon::parse($value->last_seen)->diffForHumans();
            }

            $online = [];
            foreach ($users as $key => $value) {
                # code...
                if(Cache::has('user-is-online-' . $value->id)){
                    $online[] = $value;
                }
            }

            return response()->json([
                'status'=>200,
                'message'=>'display last 4 online user',
                'data'=>$users,
                'last_seen'=>$last_seen,
                'online'=>$online
            ]);
        }
    }
}
