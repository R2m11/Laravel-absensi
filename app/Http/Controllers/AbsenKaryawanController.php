<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use App\Models\absensi;
use App\Models\Bagian;
use App\Models\Kehadiran;
use App\Models\Position;
use App\Models\Profile;
use App\Models\UserBagian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AbsenKaryawanController extends Controller
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
        $time_local = Carbon::now()->locale('id')->isoFormat('LLLL');
        $date_now = Carbon::now()->toDateString();
        $time_now = Carbon::now()->toTimeString();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();

        $absensi = Absensi::where('tanggal_absensi', $date_now)->get();

        // Ambil semua data absen karyawan berdasarkan user ID
        $p = AbsenKaryawan::where('users_id', $iduser)->get('absen_masuk');

        return view('absenkaryawan.index', compact('profile', 'user_position', 'time_local', 'time_now', 'bagian', 'userbagian', 'absensi', 'p'));
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
        $time_local = Carbon::now()->locale('id')->isoFormat('LLLL');
        $date_now = Carbon::now()->toDateString();
        $time_now = Carbon::now()->toTimeString();
        $absensi = Absensi::where('tanggal_absensi',$date_now)->get();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();
        $absenkaryawan = AbsenKaryawan::all();
        $p = AbsenKaryawan::where('users_id', $iduser)
        ->where('absensi_id', $absensi->first()->id)
        ->first();

        if($absensi == null){
            Alert::warning('Oops', 'Absen Belum ada');
            return redirect('/home');
        }elseif ($p) {
            Alert::warning('Oops', 'Anda sudah berhasil melakukan Absen Masuk untuk hari ini');
            return redirect('/home');
        }

        return view('absenkaryawan.create',compact('profile','user_position','time_local','time_now','date_now','absensi','bagian','userbagian','p'));
    }

    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'absensi_id' => 'required',
            'foto_absen' => 'required',
        ], [
            'foto_absen.required' => 'Masukkan foto absen.'
        ]);

        // Ambil waktu sekarang menggunakan Carbon
        $time_now = Carbon::now()->toTimeString();

        // Ambil data absensi berdasarkan absensi_id yang dipilih
        $absensi = Absensi::findOrFail($request->input('absensi_id'));
        $foto_absen = $request->file('foto_absen')->store('absen_fotos', 'public');
        $bagian = Bagian::findOrFail($request->input('bagian'));
        $userbagian = UserBagian::findOrFail($request->input('userbagian'));
        $user = Auth::user();


        $absenKaryawan = AbsenKaryawan::create([
            'users_id'=> $user->id,
            'absensi_id'=> $absensi->id,
            'bagian_id'=> $bagian->id,
            'userbagian_id'=> $userbagian->id,
            'absen_masuk'=> $time_now,
            'foto_absen'=> $foto_absen,
        ]);

        Alert::success('Berhasil', 'Berhasil Mengisi Absen Masuk');
        return redirect('/absenkaryawan/report');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id', $iduser)->first();
        $user_position = Position::where('id', $user_level)->first();
        $absenkaryawan = AbsenKaryawan::all();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();
        $kehadiran = Kehadiran::all();

        // Ubah query untuk hanya mengambil data absen milik user saat ini dan termasuk relasi dengan tabel absensi dan jadwal
        $absenkaryawan = AbsenKaryawan::with(['absensi.jadwal'])->where('users_id', $iduser)->get();


        return view('absenkaryawan.report', compact('profile', 'user_position', 'absenkaryawan','bagian','userbagian','kehadiran'));
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
        $time_local = Carbon::now()->locale('id')->isoFormat('LLLL');
        $date_now = Carbon::now()->toDateString();
        $time_now = Carbon::now()->toTimeString();
        $absensi = Absensi::where('tanggal_absensi', $date_now)->first('jam_keluar');
        $absenkaryawan = AbsenKaryawan::find($id);

        // if (!$absenkaryawan) {
        //     return redirect()->back()->with('error', 'Data absenkaryawan tidak ditemukan.');
        // }elseif ($absensi->jam_keluar > $time_now){
        //     Alert::warning('Oops', 'Absen Keluar Tidak Tersedia Saat Ini');
        //     return redirect('/home');
        // }
        // elseif ($absenkaryawan->absen_keluar != null) {
        //     Alert::warning('Oops', 'Anda Telah Mengisi Absen Keluar Untuk Hari Ini');
        //     return redirect('/home');
        // }

        return view('absenkaryawan.edit', compact('profile', 'user_position', 'time_now', 'absensi', 'absenkaryawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['absen_keluar' => 'required']);

        $absenkaryawan = AbsenKaryawan::find($id);
        if (!$absenkaryawan) {
            return redirect()->back()->with('error', 'Data absen karyawan tidak ditemukan.');
        }

        // Update data absen_keluar dengan waktu sekarang
        $absenkaryawan->absen_keluar = Carbon::now()->toTimeString();
        // dd($absenkaryawan);
        $absenkaryawan->save();

        $tanggal = $absenkaryawan->absensi->tanggal_absensi;
        $userId = $absenkaryawan->users_id;
        $bagianId = $absenkaryawan->bagian_id;
        $gajiharian = $absenkaryawan->user->profile->gajiharian->id;

        $kehadiran = Kehadiran::where('absenkaryawan_id', $absenkaryawan->id)->first();

        // Jika belum ada kehadiran, buat kehadiran baru
        if (!$kehadiran) {
            $kehadiran = Kehadiran::create([
                'users_id'=> $userId,
                'absenkaryawan_id' => $absenkaryawan->id,
                'bagian_id' => $bagianId,
                'tanggal' => $tanggal,
                'status' => 'Belum Diisi',
                'ket' => 'Hari Biasa',
                'gajiharian_id' => $gajiharian,
                'lemburharian_id' => '1'
            ]);
        }

        Alert::success('Berhasil', 'Berhasil Mengisi Absen Keluar');
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function absenkeluar()
    {
        $iduser = Auth::id();
        $absenKaryawan = AbsenKaryawan::where('users_id', $iduser)->get();
        $absenKaryawanFilled = $absenKaryawan->filter(function ($item) {
            return $item->absen_keluar !== null;
        });

        return view('absenkaryawan.index', compact('absenKaryawanFilled'));
    }
}
