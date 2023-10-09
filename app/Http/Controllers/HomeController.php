<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use App\Models\absensi;
use App\Models\Kehadiran;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $date_now = Carbon::now()->locale('id')->toDateString();
        $time_now = Carbon::now()->locale('id')->toTimeString();
        $user_position = Position::where('id',$user_level)->first();
        $kehadiran = Kehadiran::where('status', 'Belum Diisi')->get();
        $user = User::where('position_id', '2')->get();
        $absensi = absensi::where('tanggal_absensi', $date_now)->get();
        $absenkaryawan = AbsenKaryawan::with(['absensi.jadwal'])->where('users_id', $iduser)->get();


        return view('home',compact('user_position','profile','date_now','time_now','kehadiran','user','absensi','absenkaryawan'));
    }
}
