<?php

namespace App\Http\Controllers;

use App\Models\Kasbon;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();
        $kasbon = Kasbon::all();

        return view('kasbon.index',compact('profile','user_position','kasbon'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();
        $user = User::all();
        $kasbon = Kasbon::all();

        return view('kasbon.create',compact('profile','user_position','user','kasbon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=>'required',
            'users_id'=>'required',
            'jumlah'=>'required'
        ]);

        $date_now = Carbon::now()->toDateString();
        $user = User::findOrFail($request->input('users_id'));

        $kasbon = Kasbon::create([
            'tanggal'=> $date_now,
            'users_id'=> $request->users_id,
            'jumlah'=> $request->jumlah,
        ]);
        Alert::success('Berhasil', 'Berhasil Menambahkan Kasbon Karyawan');
        return redirect('/kasbon');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kasbon)
    {
        $user = User::all();
        return view('kasbon.index',compact('user','kasbon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kasbon $kasbon)
    {
        $kasbon->delete();
        Alert::success('Berhasil', 'Berhasil Menghapus Data');
        return redirect('/kasbon');
    }
}
