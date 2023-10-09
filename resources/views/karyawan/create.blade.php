@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
<h1 class="text-primary m-4">Form Tambah Anggota</h1>
<form action="/karyawan" method="post">
    @csrf
    <div class="card pb-5 mx-3">
        <div class="form-group mx-4">
            <label for="nama" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
        </div>

        @error('name')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="kode_karyawan" class="text-md text-primary font-weight-bold">Nomor Karyawan</label>
            <input type="text" id="kode_karyawan" class="form-control @error('kode_karyawan') is-invalid @enderror" name="kode_karyawan" value="{{ old('kode_karyawan') }}">
        </div>

        @error('kode_karyawan')
        <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="kode_karyawan" class="text-md text-primary font-weight-bold">Posisi atau Jabatan</label>
            <select name="position" id="position" class="form-control">
            <option value="">Pilih Jabatan</option>
            @foreach ($position as $item )
            <option value="{{ $item->id }}">{{ $item->position_name }}</option>
            @endforeach
            </select>
        </div>

        @error('position')
        <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror


        <div class="form-group mx-4">
            <label for="gender" class="text-md text-primary font-weight-bold">Jenis Kelamin</label>
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        @error('gender')
            <div class="alert-danger mx-4 my-2 px-2 py-2 mx-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="address" class="text-md text-primary font-weight-bold">Alamat</label>
            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
        </div>

        @error('address')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="phone_number" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
            <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">
        </div>

        @error('phone_number')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="gajiharian_id" class="text-md text-primary font-weight-bold">Gaji Harian</label>
            <select name="gajiharian_id" id="gajiharian_id" class="form-control" required>
                <option value="" selected disabled>Pilih Gaji Harian</option>
                @foreach($gajiharian as $gaji)
                    <option value="{{ $gaji->id }}">{{ $gaji->desc_gaji }} --- Rp.{{ $gaji->gaji }}</option>
                @endforeach
            </select>
        </div>

        @error('phone_number')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="email" class="text-md text-primary font-weight-bold">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
        </div>

        @error('email')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="password" class="text-md text-primary font-weight-bold">Password (Default : Nomor Pegawai)</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
        </div>

        @error('password')
            <div class="alert-danger mx-4 my-2 px-2 py-2"> {{ $message }}</div>
        @enderror


        <div class="button-save d-flex justify-content-end">
            <a href="/karyawan" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
            <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
        </form>
        </div>
    </div>
@endsection
