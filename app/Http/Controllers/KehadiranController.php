<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use App\Models\absensi;
use App\Models\Bagian;
use App\Models\GajiHarian;
use App\Models\Kehadiran;
use App\Models\LemburHarian;
use App\Models\Position;
use App\Models\Profile;
use App\Models\Rekap;
use App\Models\User;
use App\Models\UserBagian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KehadiranController extends Controller
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
        $absensi = Absensi::all();
        $absenkaryawan = AbsenKaryawan::all();
        $kehadiran = Kehadiran::where('status', 'Belum Diisi')->get();
        $kehadiranall = Kehadiran::all();


        return view('kehadiran.index', compact('kehadiran','absenkaryawan','absensi', 'profile', 'user_position', 'date_now','kehadiranall'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $date_now = Carbon::now()->toDateString();
        $absensi = Absensi::all();
        $absenkaryawan = AbsenKaryawan::all();
        $kehadiran = Kehadiran::all();

        $tanggalAbsensi = Absensi::select('tanggal_absensi')->distinct()->get();


        return view('kehadiran.detail', compact('absenkaryawan', 'absensi', 'kehadiran', 'profile', 'user_position', 'date_now'));
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
        $kehadiran = Kehadiran::find($id);
        $userbagian = UserBagian::all();
        $bagian = Bagian::all();
        $gajiharian = GajiHarian::all();
        $lemburharian = LemburHarian::all();

        return view('kehadiran.edit', compact('profile', 'user_position', 'kehadiran','userbagian','bagian','gajiharian','lemburharian'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
        ], [
            'status' => 'Status Harus Diisi',
        ]);

        $kehadiran = Kehadiran::find($id);
        $lemburharian = LemburHarian::findOrFail($request->input('lemburharian_id'));

        $kehadiran->status = $request->status;
        $kehadiran->lemburharian_id = $lemburharian->id;

        $kehadiran->save();

        Alert::success('Berhasil', 'Berhasil Mengecek Absen Karyawan');
        return redirect('/kehadiran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kehadiran = Kehadiran::find($id);

        if ($kehadiran) {
            // Hapus terlebih dahulu absen karyawan yang terhubung
            $absenkaryawan = $kehadiran->absenkaryawan;
            if ($absenkaryawan) {
                $absenkaryawan->delete();
            }

            // Hapus data kehadiran
            $kehadiran->delete();

            Alert::success('Berhasil', 'Berhasil Menghapus Data Kehadiran');
        } else {
            Alert::error('Gagal', 'Data Kehadiran Tidak Ditemukan');
        }

        return redirect('/kehadiran');
    }
}
