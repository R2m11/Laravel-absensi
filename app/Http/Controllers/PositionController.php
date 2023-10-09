<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();
        $positions = Position::all();
        return view('position.index', compact('positions','profile','user_position'));
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
        $positions = Position::all();
        return view('position.create', compact('positions','profile','user_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|min:2',
            'description' => 'nullable',
        ], [
            'position_name.required' => 'Nama Posisi harus diisi.',
            'position_name.min' => 'Nama Posisi minimal 2 karakter.',
        ]);

        $position = new Position();
        $position->position_name = $request->position_name;
        $position->description = $request->description;
        $position->save();

        Alert::success('success', 'Jabatan berhasil ditambahkan.');
        return redirect('/position');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        return view('position.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('position.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'position_name' => 'required|min:2',
        ], [
            'position_name.required' => 'Nama Posisi harus diisi.',
            'position_name.min' => 'Nama Posisi minimal 2 karakter.',
        ]);

        $position->update([
            'position_name' => $request->position_name,
            'description' => $request->description,
        ]);

        Alert::success('Berhasil', 'Jabatan berhasil diperbarui.');

        return redirect('position.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        Alert::success('Berhasil', 'Jabatan berhasil dihapus.');
        return redirect('position');
    }
}
