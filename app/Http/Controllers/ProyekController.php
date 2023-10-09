<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Perusahaan;
use App\Models\Position;
use App\Models\Profile;
use App\Models\UserBagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();
        $search = $request->input('search');
        $searchResults = collect();

        if ($search) {
            $searchResults = Perusahaan::join('bagian', 'perusahaan.id', '=', 'bagian.perusahaan_id')
                ->join('user_bagian', 'bagian.id', '=', 'user_bagian.bagian_id')
                ->select('perusahaan.nama_perusahaan', 'bagian.nama_bagian', 'user_bagian.nama_user_bagian')
                ->where('perusahaan.nama_perusahaan', 'like', "%{$search}%")
                ->orWhere('bagian.nama_bagian', 'like', "%{$search}%")
                ->orWhere('user_bagian.nama_user_bagian', 'like', "%{$search}%")
                ->distinct()
                ->get();
        }

        $perusahaan = Perusahaan::all();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();

        return view('proyek.index', compact('perusahaan', 'bagian', 'userbagian', 'searchResults','profile','user_position'));
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perusahaan = Perusahaan::find($id);
        $bagian = Bagian::where('perusahaan_id', $id)->first();
        $userbagian = UserBagian::where('bagian_id', $bagian->id)->first();

        return view('proyek.edit', compact('perusahaan', 'bagian', 'userbagian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'nama_bagian' => 'required',
            'nama_user_bagian' => 'required',
        ], [
            'nama_perusahaan.required' => 'Nama Perusahaan tidak boleh kosong',
            'nama_bagian.required' => 'Nama Bagian tidak boleh kosong',
            'nama_user_bagian.required' => 'Nama User Bagian tidak boleh kosong',
        ]);

        $perusahaan = Perusahaan::find($id);
        $bagian = Bagian::where('perusahaan_id', $id)->first();
        $userbagian = UserBagian::where('bagian_id', $bagian->id)->first();

        $perusahaan->nama_perusahaan = $request->nama_perusahaan;
        $bagian->nama_bagian = $request->nama_bagian;
        $userbagian->nama_user_bagian = $request->nama_user_bagian;

        $perusahaan->save();
        $bagian->save();
        $userbagian->save();

        Alert::success('success', 'Berhasil Mengubah Proyek');
        return redirect('/proyek');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::find($id);
        if (!$perusahaan) {
            // Tambahkan logika untuk menangani jika perusahaan tidak ditemukan
            // Misalnya, tampilkan pesan error dan alihkan kembali ke halaman sebelumnya
        }

        // Hapus data bagian yang terkait dengan perusahaan
        Bagian::where('perusahaan_id', $perusahaan->id)->delete();

        // Hapus data userbagian yang terkait dengan perusahaan
        UserBagian::whereHas('bagian', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->delete();

        // Hapus perusahaan
        $perusahaan->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus data');
        return redirect('proyek');
    }

}
