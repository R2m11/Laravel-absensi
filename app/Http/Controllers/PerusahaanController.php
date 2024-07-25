<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PerusahaanController extends Controller
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
        return view('proyek.perusahaan.index',compact('perusahaan','profile','user_position'));
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
        return view('proyek.perusahaan.create',compact('perusahaan','profile','user_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Perusahaan::create($request->all());
        Alert::success('Berhasil', 'Berhasil Menambahkan Nama Perusahaan');
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
        $perusahaan = Perusahaan::find($id);
        return view('proyek.perusahaan.edit',compact('profile','user_position','perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $request->validate([
            'nama_perusahaan' => 'required'
        ]);
        $perusahaan->update($request->all());
        return redirect('proyek');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();
        Alert::success('Berhasil', 'perusahaan berhasil dihapus.');
        return redirect('proyek');
    }
}
