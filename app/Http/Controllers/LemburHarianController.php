<?php

namespace App\Http\Controllers;

use App\Models\LemburHarian;
use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LemburHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $lemburharian = LemburHarian::all();

        return view('gajilemburharian.lemburharian.create',compact('lemburharian','profile','user_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        LemburHarian::create($request->all());
        Alert::success('Berhasil', 'Berhasil Menambahkan Data Lembur Harian');
        return redirect('/gajilemburharian');
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
    public function destroy(LemburHarian $lemburharian)
    {
        $lemburharian->delete();
        Alert::success('Berhasil', 'Menghapus Data Lembur Harian.');
        return redirect('gajilemburharian');
    }
}
