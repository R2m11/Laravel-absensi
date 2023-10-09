<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Perusahaan;
use App\Models\Position;
use App\Models\Profile;
use App\Models\UserBagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserBagianController extends Controller
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
        $perusahaan = Perusahaan::all();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();
        return view('proyek.userbagian.index',compact('perusahaan','bagian','userbagian','profile','user_position'));
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
        $perusahaan = Perusahaan::all();
        $bagian = Bagian::all();
        $userbagian = UserBagian::all();
        return view('proyek.userbagian.create',compact('perusahaan','bagian','userbagian','profile','user_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bagian_id' => 'required',
            'nama_user_bagian' => 'required',
        ], [
            'bagian_id.required' => "Nama Bagian Tidak Boleh Kosong",
            'nama_user_bagian.required' => "Nama User Bagian Tidak Boleh Kosong"
        ]);

        // Cari perusahaan berdasarkan ID yang terpilih
        $bagian = Bagian::findOrFail($request->input('bagian_id'));
        // Tambahkan bagian ke perusahaan
        $userbagian = UserBagian::create([
            'nama_user_bagian' => $request->input('nama_user_bagian'),
            'bagian_id' => $bagian->id
        ]);

        Alert::success('Berhasil', 'Berhasil Menambahkan User Bagian');
        return redirect('/proyek');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserBagian $userbagian)
    {
        $userbagian->delete();
        Alert::success('Berhasil', 'userbagian berhasil dihapus.');
        return redirect('proyek');
    }
}
