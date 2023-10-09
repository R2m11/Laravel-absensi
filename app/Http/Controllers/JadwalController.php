<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalController extends Controller
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
        $jadwal = Jadwal::all();
        return view('jadwal.index',compact('jadwal','profile','user_position'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jadwal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shift'=> 'required',
            'jam_masuk'=> 'required',
            'jam_keluar'=> 'required',
        ],[
            'shift'=>'Masukan Nama Shift',
            'jam_masuk'=>'Masukan Jam Masuk Untuk Shift Ini',
            'jam_keluar'=>'Masukan Jam Keluar Untuk Shift Ini',
        ]);

        $jadwal = new Jadwal();
        $jadwal->shift = $request->shift;
        $jadwal->jam_masuk = $request->jam_masuk;
        $jadwal->jam_keluar = $request->jam_keluar;
        $jadwal->save();

        Alert::success('Berhasil','Berhasil Menambahkan jadwal shift');
        return redirect('/jadwal');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        return view('jadwal.show',compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit',compact('jadwal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'shift'=> 'required',
            'jam_masuk'=> 'required',
            'jam_keluar'=> 'required',
        ],[
            'shift'=>'Masukan Nama Shift',
            'jam_masuk'=>'Masukan Jam Masuk Untuk Shift Ini',
            'jam_keluar'=>'Masukan Jam Keluar Untuk Shift Ini',
        ]);

        $jadwal->update([
            'shift'=> $request->shift,
            'jam_masuk'=> $request->jam_masuk,
            'jam_keluar'=> $request->jam_keluar
        ]);

        Alert::success('Berhasil','Berhail Mengubah Jadwal');
        return redirect('jadwal.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Data Shift');
        return redirect('jadwal');
    }
}
