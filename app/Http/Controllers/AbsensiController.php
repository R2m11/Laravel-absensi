<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\jadwal;
use App\Models\Libur;
use App\Models\Position;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    $iduser = Auth::id();
    $user_level = Auth::user()->position_id;
    $profile = Profile::where('users_id', $iduser)->first();
    $user_position = Position::where('id', $user_level)->first();
    $date_now = Carbon::now()->toDateString();
    $jadwal = Jadwal::all();

    $absensi = Absensi::where('tanggal_absensi', $date_now)->get();

    $absensiall = Absensi::all();

    return view('absensi.index', compact('absensi', 'profile', 'user_position', 'jadwal', 'date_now','absensiall'));
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
        $date_now = Carbon::now()->toDateString();
        $jadwal = jadwal::all();
        $absensi = Absensi::all();
        $absensi = Absensi::with('jadwal')->get();

        return view('absensi.create',compact('absensi','profile','user_position','jadwal','date_now'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_absensi'=>'required',
            'jadwal_id'=>'required',
            'jam_masuk'=>'required',
            'jam_keluar'=>'required',
            'deskripsi'=>'required'
        ],[
            'tanggal_absensi'=>'Tanggal Harus Diisi',
            'jadwal_id.required'=>'Shift tidak boleh kosong',
            'deskripsi'=>'Masukan hari'
        ]);

        $date_now = Carbon::now()->toDateString();
        $tgl_absensi = $request->tanggal_absensi;
        $jadwal = jadwal::findOrfail($request->input('jadwal_id'));


        // Simpan data absensi jika tidak ada masalah dengan validasi
        $absensi = Absensi::create([
            'tanggal_absensi' => $date_now,
            'jadwal_id' => $request->jadwal_id,
            'jam_masuk'=>$request->jam_masuk,
            'jam_keluar'=>$request->jam_keluar,
            'deskripsi' => $request->input('deskripsi'),
        ]);

        Alert::success('Berhasil', 'Berhasil Menambahkan Absensi');
        return redirect('absensi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id', $iduser)->first();
        $user_position = Position::where('id', $user_level)->first();
        $time_now = Carbon::now()->locale('id')->isoFormat('LLLL');
        $absensi = Absensi::find($id); // Menggunakan find() untuk mendapatkan objek berdasarkan ID

        return view('/absensi/detail', compact('absensi', 'profile', 'user_position', 'time_now'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id', $iduser)->first();
        $user_position = Position::where('id', $user_level)->first();
        $time_now = Carbon::now()->locale('id')->isoFormat('LLLL');
        $jadwal = jadwal::all();
        $absensi = Absensi::with('jadwal')->get();
        $absensi = Absensi::find($id); // Menggunakan find() untuk mendapatkan objek berdasarkan ID

        return view('/absensi/edit', compact('absensi', 'profile', 'user_position', 'time_now'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_absensi'=>'required',
            'deskripsi'=>'required'
        ],[
            'tanggal_absensi'=>'Tanggal Harus Diisi',
            'deskripsi'=>'Masukan hari'
        ]);

        $absensi = Absensi::find($id);
        $absensi->tanggal_absensi = $request->tanggal_absensi;
        $absensi->deskripsi = $request->deskripsi;
        $absensi->save();

        $tgl_absensi = $request->input('tanggal_absensi');

        return redirect('absensi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absensi = Absensi::find($id);
        $absensi->delete();

        Alert::success('Berhasil','Berhasil Menghapus Jadwal');
        return redirect('absensi');
    }
}
