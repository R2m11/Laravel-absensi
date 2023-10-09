<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\GajiHarian;
use App\Models\User;
use App\Models\Position;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iduser = Auth::id();
        $karyawan = User::with('position','profile')->get();
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$iduser)->first();
        $user_position = Position::where('id',$user_level)->first();

        return view('karyawan.index',compact('karyawan','profile','user_position'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = Profile::where('users_id',$iduser)->first();
        $user_level = Auth::user()->position_id;
        $user_position = Position::where('id',$user_level)->first();
        $position = Position::all();
        $gajiharian = GajiHarian::all();

        return view('karyawan.create',compact('profile','user_position','position','gajiharian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'kode_karyawan'=> 'required|unique:profile',
            'position'=> 'required',
            'gender'=> 'required',
            'address'=> 'required',
            'phone_number'=> 'required',
            'gajiharian_id'=> 'required',
            'email'=>'required|unique:users',
            // 'password'=>'|min:8',
        ],
        [
            'name.required'=>"Nama tidak boleh kosong",
            'kode_karyawan.required'=>"Nomor Induk tidak boleh kosong",
            'kode_karyawan.unique'=>"Kode Telah Ada",
            'position.required'=>"Posisi Tidak Boleh Kosong",
            'gender.required'=>"gender tidak boleh kosong",
            'address.required'=>"address tidak boleh kosong",
            'phone_number.required'=>"Nomor Telepon tidak boleh kosong",
            'gajiharian_id.required'=>"Wajib diisi, Gaji untuk gaji harian",
            'email.required'=>"Email tidak boleh kosong",
            'email.unique'=>"Email Telah Digunakan",
            // 'password.min'=>"Password tidak boleh kurang dari 8 karakter"
        ]);
        // dd($request->all());

        if ($request->password == null){
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['kode_karyawan']),
                'position_id'=>$request['position']
            ]);
            $profile = Profile::create([
                'kode_karyawan'=>$request['kode_karyawan'],
                'gender'=>$request['gender'],
                'address'=>$request['address'],
                'phone_number'=>$request['phone_number'],
                'gajiharian_id'=>$request['gajiharian_id'],
                'users_id'=>$user->id,
                ]);
        }
        else{
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'position_id'=>$request['position']
            ]);
            $profile = Profile::create([
                'kode_karyawan'=>$request['kode_karyawan'],
                'gender'=>$request['gender'],
                'address'=>$request['address'],
                'phone_number'=>$request['phone_number'],
                'gajiharian_id'=>$request['gajiharian_id'],
                'users_id'=>$user->id,
                ]);
        }
        Alert::success('Success', 'Berhasil Menambah Karyawan');
        return redirect('/karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $karyawan = User::find($id);
        $user_level = Auth::user()->position_id;
        $profile = Profile::where('users_id',$id)->first();
        $user_position = Position::where('id',$user_level)->first();
        $position = Position::get('position_name');

        return view('karyawan.details',compact('karyawan','profile','user_position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = User::find($id);
        $profile = Profile::where('users_id',$id)->first();
        $user_level = Auth::user()->position_id;
        $user_position = Position::where('id',$user_level)->first();
        $position = Position::all();
        $gajiharian = GajiHarian::all();

        return view('karyawan.edit',compact('karyawan','profile','user_position','position','gajiharian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> 'required',
            'kode_karyawan'=> 'required',
            'position'=> 'required',
            'gender'=> 'required',
            'address'=> 'required',
            'phone_number'=> 'required',
            'gajiharian_id'=> 'required',
            'profile_picture'=> 'nullable|mimes:jpg,jpeg,png|max:2048'
        ],
        [
            'name.required'=>"Nama tidak boleh kosong",
            'position.required'=>"Posisi tidak boleh kosong",
            'kode_karyawan.required'=>"Nomor Induk tidak boleh kosong",
            'gender.required'=>"gender tidak boleh kosong",
            'address.required'=>"address tidak boleh kosong",
            'phone_number.required'=>"Nomor Telepon tidak boleh kosong",
            'gajiharian_id.required'=>"Gaji Harian harus diisi",
            'profile_picture.mimes' =>"Foto Profile Harus Berupa jpg,jpeg,atau png",
            'profile_picture.max' => "ukuran gambar tidak boleh lebih dari 2048 MB"
        ]);

        $user = User::find($id);
        $profile = Profile::find($id);

        $user->name = $request->name;
        $user->position_id = $request->position;
        $profile->kode_karyawan = $request->kode_karyawan;
        $profile->gender = $request->gender;
        $profile->address = $request->address;
        $profile->phone_number = $request->phone_number;
        $profile->gajiharian_id =  $request->gajiharian;

        $profile->save();
        $user->save();

        Alert::success('Success', 'Berhasil Mengubah Profile');
        return redirect('/karyawan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();

        'Alert'::success('Berhasil', 'Berhasil Mengapus Karyawan');
        return redirect('/karyawan');
    }
}
