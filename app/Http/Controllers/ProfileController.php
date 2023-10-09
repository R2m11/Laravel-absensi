<?php

namespace App\Http\Controllers;

use App\Models\GajiHarian;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iduser = Auth::id();
        $profile = Profile::where('users_id', $iduser)->first();
        $user_level = Auth::user()->position_id;
        $user_position = Position::where('id',$user_level)->first();
        // dd($user_position)
        return view('profile.index',compact('profile','user_position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $profile = Profile::where('users_id',$iduser)->first();
        $user_level = Auth::user()->position_id;
        $user_position = Position::where('id',$user_level)->first();
        return view('profile.edit',compact('profile','user_position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'address'=> 'required',
            'phone_number'=> 'required',
            'profile_picture'=> 'nullable|mimes:jpg,jpeg,png|max:2048'
        ],
        [
            'address.required'=>"address tidak boleh kosong",
            'phone_number.required'=>"Nomor Telepon tidak boleh kosong",
            'profile_picture.mimes' =>"Foto Profile Harus Berupa jpg,jpeg,atau png",
            'profile_picture.max' => "ukuran gambar tidak boleh lebih dari 2048"
        ]);
        $iduser = Auth::id();
        $profile = Profile::where('users_id',$iduser)->first();
        $user = User::where('id',$iduser)->first();

        if($request->has('profile_picture')){
         $path='images/photoProfile';

         'File'::delete($path.$profile->profile_picture);

         $namaGambar = time().'.'.$request->profile_picture->extension();

         $request->profile_picture->move(public_path('images/profile_picture'),$namaGambar);

         $profile->profile_picture =$namaGambar;

         $profile->save();
        }
        $profile->address = $request->address;
        $profile->phone_number = $request->phone_number;

        $profile->save();
        $user->save();

        'Alert'::success('Success', 'Berhasil Mengubah Profile');
        return redirect('/profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
