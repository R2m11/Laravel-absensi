@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
<h1 class="text-primary mx-3 my-3">Form Edit Pegawai</h1>
<div class="card pb-5 mx-3">
        <form action="/karyawan/{{ $karyawan->id }}" method="post">
            @csrf
            @method('put')
        <div class="form-group mx-4">
            <label for="name" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{  old('name', $profile->user->name)  }}">
        </div>

        @error('name')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="kode_karyawan" class="text-md text-primary font-weight-bold">Nomor Pegawai</label>
            <input type="text" id="kode_karyawan" class="form-control @error('kode_karyawan') is-invalid @enderror" name="kode_karyawan" value="{{ old('kode_karyawan', $profile->kode_karyawan) }}">
        </div>

        @error('kode_karyawan')
        <div class="alert-danger mx-4 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="kode_karyawan" class="text-md text-primary font-weight-bold">Posisi atau Jabatan</label>
            <select name="position" id="position" class="form-control">
            <option value="{{ $karyawan->position_id }}" selected>{{ $karyawan->position->position_name }}</option>
            @foreach ($position as $item )
            <option value="{{ $item->id }}">{{ $item->position_name }}</option>
            @endforeach

            </select>
        </div>

        @error('position')
        <div class="alert-danger mx-4 px-2 py-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="gender" class="text-md text-primary font-weight-bold">Jenis Kelamin</label>
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                @if($karyawan->profile->gender == 'Laki-Laki')
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
                @elseif ($karyawan->profile->gender == 'Perempuan')
                <option value="Perempuan">Perempuan</option>
                <option value="Laki-Laki">Laki-Laki</option>
                @endif
            </select>
        </div>

        @error('gender')
            <div class="alert-danger mx-4 px-2 py-2 mx-2"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="address" class="text-md text-primary font-weight-bold">Alamat</label>
            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $profile->address) }}">
        </div>

        @error('address')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="phone_number" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
            <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $profile->phone_number)}}">
        </div>

        @error('phone_number')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4">
            <label for="gajiharian_id" class="text-md text-primary font-weight-bold">Gaji Harian</label>
            <select name="gajiharian_id" id="gajiharian_id" class="form-control" required>
            <option value="{{ $karyawan->gajiharian_id }}" selected>{{ $profile->gajiharian->desc_gaji }} - {{ $profile->gajiharian->gaji }}</option>
            @foreach ($gajiharian as $item )
                <option value="{{ $item->id }}">{{ $item->desc_gaji }} - {{$item->gaji}}</option>
            @endforeach
            </select>
        </div>

        <div class="button-save d-flex justify-content-end">
            <a href="/karyawan" class="btn btn-danger mt-4  px-4 py-1">Batal</a>
            <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
        </div>
    </form>
    </div>
@endsection
