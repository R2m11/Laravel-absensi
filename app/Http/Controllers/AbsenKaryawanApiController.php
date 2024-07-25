<?php

namespace App\Http\Controllers;


use App\Models\AbsenKaryawan;
use App\Models\absensi;
use App\Models\bagian;
use App\Models\jadwal;
use App\Models\Kehadiran;
use App\Models\Position;
use App\Models\Profile;
use App\Models\UserBagian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AbsenKaryawanApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date_now = Carbon::now()->toDateString();
        $absensi = Absensi::where('tanggal_absensi', $date_now)->get();

        $data = [];

        if ($absensi) {
            foreach ($absensi as $absen) {
                $jadwal = Jadwal::find($absen->jadwal_id);

                // Buat sebuah array untuk setiap data absensi
                $absensiData = [
                    'shift' => $jadwal->shift,
                    'jam_masuk' => $absen->jam_masuk,
                    'jam_keluar' => $absen->jam_keluar,
                ];

                // Tambahkan data absensi ke dalam $data
                $data[] = $absensiData;
            }

            // Pindahkan pernyataan return di luar loop
            return response()->json($data);
        } else {
            // Jika tidak ada data absensi, kembalikan pesan error
            return response()->json(['error' => 'Data absensi tidak ditemukan'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request);
        $date_now = Carbon::now()->toDateString();
        $absensi = Absensi::where('tanggal_absensi', $date_now)->get();
        $bagian = bagian::all();
        // dd($bagian);
        $userbagian = UserBagian::where('bagian_id',$bagian)->get();
        $data = [
            'bagian' => $bagian,
            'userbagian' => $userbagian,
        ];

        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'absensi_id' => 'required',
            'bagian_id' => 'required',
            'userbagian_id' => 'required',
            'absen_masuk' => 'required',
            'foto_absen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $time_now = Carbon::now()->toTimeString();
        $absensi = Absensi::findOrFail($request->input('absensi_id'));
        $foto_absen = $request->file('foto_absen')->store('absen_fotos', 'public');
        $bagian = Bagian::findOrFail($request->input('bagian_id')); // Perbaikan: gunakan 'bagian_id'
        $userbagian = UserBagian::findOrFail($request->input('userbagian_id')); // Perbaikan: gunakan 'userbagian_id'
        $user = Auth::user();

        $absenKaryawan = AbsenKaryawan::create([
            'users_id' => $user->id,
            'absensi_id' => $absensi->id,
            'bagian_id' => $bagian->id,
            'userbagian_id' => $userbagian->id,
            'absen_masuk' => $time_now,
            'foto_absen' => $foto_absen,
        ]);

        return response()->json($absenKaryawan);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $validated = $request->validate(['absen_keluar' => 'required']);

        $absenkaryawan = AbsenKaryawan::find($id);

        if (!$absenkaryawan) {
            return response()->json(['error' => 'Data absen karyawan tidak ditemukan.'], 404);
        }

        $absenkaryawan->update([
            'absen_keluar' => Carbon::now()->toTimeString(),
        ]);

        $kehadiran = Kehadiran::where('absenkaryawan_id', $absenkaryawan->id)->first();

        // Jika belum ada 'Kehadiran', buat 'Kehadiran' baru
        if (!$kehadiran) {
            $kehadiran = Kehadiran::create([
                'users_id' => $absenkaryawan->users_id,
                'absenkaryawan_id' => $absenkaryawan->id,
                'bagian_id' => $absenkaryawan->bagian_id,
                'tanggal' => $absenkaryawan->absensi->tanggal_absensi,
                'status' => 'Belum Diisi',
                'ket' => 'Hari Biasa',
                'gajiharian_id' => $absenkaryawan->user->profile->gajiharian->id,
                'lemburharian_id' => '1'
            ]);
        }

        return response()->json($absenkaryawan);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
