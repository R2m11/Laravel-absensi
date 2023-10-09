<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use App\Models\absensi;
use App\Models\Bagian;
use App\Models\Kehadiran;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserBagian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class XkehadiranController extends Controller
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
        $user = User::all();
        $bagian = Bagian::all();
        $xkehadiran = Kehadiran::where('status',['Sakit','Izin'])->get();

        return view('xkehadiran.index', compact('profile', 'user_position', 'date_now','user','bagian','xkehadiran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id', $iduser)->first();
        $user_position = Position::where('id', $user_level)->first();
        $bagian = Bagian::all();
        $user = User::all();
        $userbagian = UserBagian::all();
        $date_now = Carbon::now()->toDateString();
        $absensi = Absensi::where('tanggal_absensi',$date_now)->get();

        return view('xkehadiran.create', compact('profile', 'user_position','bagian','user','absensi','userbagian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'ket' => 'required',
        ], [
            'status.required' => 'Keterangan sakit atau izin harus diisi',
            'ket.required' => 'Alasan Mengajukan sakit atau izin harus diisi',
        ]);
        $time_now = Carbon::now()->toTimeString();
        // Pindahkan baris ini setelah deklarasi $absenkaryawan
        $absenkaryawan = AbsenKaryawan::create([
            'users_id' => $request['users_id'],
            'absensi_id' => $request['absensi_id'],
            'bagian_id' => $request['bagian_id'],
            'userbagian_id' => $request['userbagian_id'],
            'absen_masuk'=> $time_now,
            'absen_keluar'=> $time_now,
            'foto_absen'=> $request['status'],
        ]);

        // Pastikan $absenkaryawan telah dideklarasikan sebelumnya
        $tanggal = $absenkaryawan->absensi->tanggal_absensi;
        $gajiharian = $absenkaryawan->user->profile->gajiharian->id;

        $kehadiran = Kehadiran::create([
            'users_id' => $request['users_id'],
            'absenkaryawan_id' => $absenkaryawan->id, // Menghubungkan kehadiran dengan absen karyawan
            'bagian_id' => $request['bagian_id'],
            'tanggal' => $tanggal,
            'status' => $request['status'],
            'ket' => $request['ket'],
            'gajiharian_id' => $gajiharian,
            'lemburharian_id' => '1'
        ]);
        // dd($request->all());

        Alert::success('Berhasil', 'Berhasil Mengisi Izin atau Sakit');
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('xkehadiran.show', compact('xkehadiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('xkehadiran.edit', compact('xkehadiran'));
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
    public function destroy()
    {
    }
}
