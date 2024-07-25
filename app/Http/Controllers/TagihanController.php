<?php

namespace App\Http\Controllers;

use App\Exports\TagihanExport;
use App\Models\AbsenKaryawan;
use App\Models\Kasbon;
use App\Models\Kehadiran;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
    $iduser = Auth::id();
    $user_level = Auth::user()->position_id;
    $profile = Profile::where('users_id', $iduser)->first();
    $user_position = Position::where('id', $user_level)->first();
    $absenkaryawan = AbsenKaryawan::all();
    $kasbon = Kasbon::all();
    $userAll = User::all();

    // Filter kehadiran berdasarkan tanggal
    $kehadiran = Kehadiran::with('absenkaryawan.user.profile', 'absenkaryawan.bagian')
        ->whereBetween('tanggal', [$request->input('tanggal_awal'), $request->input('tanggal_akhir')])
        ->get();

    return view('tagihan.index', compact('profile', 'user_position', 'userAll', 'kehadiran','absenkaryawan','kasbon'));
    }

    public function tagihanexcel(Request $request)
    {
        // Filter kehadiran berdasarkan tanggal
        $tanggalAwal = \Carbon\Carbon::parse($request->query('tanggal_awal'));
        $tanggalAkhir = \Carbon\Carbon::parse($request->query('tanggal_akhir'));

        $kehadiran = Kehadiran::with('absenkaryawan.user.profile', 'absenkaryawan.bagian')
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->get();
        $filteredTanggalAbsensi = [];

        while ($tanggalAwal->lte($tanggalAkhir)) {
            $filteredTanggalAbsensi[] = $tanggalAwal->format('d/m/Y');
            $tanggalAwal->addDay();
        }

        $kasbon = Kasbon::all();
        $groupUser = $kehadiran->groupBy('absenkaryawan.user.id');

        return Excel::download(new TagihanExport($kehadiran,$filteredTanggalAbsensi,$groupUser, $kasbon), 'Tagihan_'.$tanggalAwal->format('d-m-Y').'-'.$tanggalAkhir->format('d-m-Y').'.xlsx');
    }
}