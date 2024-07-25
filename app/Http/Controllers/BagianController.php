<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Perusahaan;
use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BagianController extends Controller
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
        return view('proyek.bagian.index',compact('perusahaan','profile','user_position'));
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
        return view('proyek.bagian.create',compact('perusahaan','profile','user_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required',
            'nama_bagian' => 'required',
            'kode_bagian' => 'required',
        ], [
            'perusahaan_id.required' => "Perusahaan harus dipilih",
            'nama_bagian.required' => "Nama Bagian Tidak Boleh Kosong",
            'kode_bagian.required' => "Kode Bagian Tidak Boleh Kosong"
        ]);

        // Cari perusahaan berdasarkan ID yang terpilih
        $perusahaan = Perusahaan::findOrFail($request->input('perusahaan_id'));

        // Tambahkan bagian ke perusahaan
        $bagian = Bagian::create([
            'nama_bagian' => $request->input('nama_bagian'),
            'kode_bagian' => $request->input('kode_bagian'),
            'tagihan_harian' => $request->input('tagihan_harian'),
            'tagihan_harian_perjam' => $request->input('tagihan_harian_perjam'),
            'perusahaan_id' => $perusahaan->id
        ]);

        Alert::success('Berhasil', 'Berhasil Menambahkan Bagian');
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
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();
        $bagian = Bagian::find($id);
        $perusahaan = Perusahaan::all();

        return view('proyek.bagian.edit',compact('profile','user_position','bagian','perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bagian $bagian)
    {
        $request->validate([
            'nama_bagian'=>'required',
            'tagihan_harian'=>'required',
        ]);
        $bagian->update($request->all());

        Alert::success('Berhasil','Berhasil Mengedit Bagian Gedung');
        return redirect('proyek');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bagian $bagian)
    {
        $bagian->delete();
        Alert::success('Berhasil', 'Bagian berhasil dihapus.');
        return redirect('proyek');
    }
}
