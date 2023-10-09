@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')


<div class="card mx-4 my-4 px-2">
    <h1 class="text-primary font-weight-bold m-4">Absen Keluar Karyawan</h1>
    <form action="/absenkaryawan/{{ $absenkaryawan->id }}" method="post">
        @csrf
        @method('put')
        <div class="form-group mx-4">
            <label for="name" class="text-md text-primary font-weight-bold mt-2">Nama Karyawan</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $absenkaryawan->user->name) }}" readonly>
        </div>
        <div class="form-group mx-4">
            <label for="shift" class="text-md text-primary font-weight-bold mt-2">Shift Masuk</label>
            <input type="text" id="shift" class="form-control @error('shift') is-invalid @enderror" name="shift" value="{{ old('shift', $absenkaryawan->absensi->jadwal->shift) }}" readonly>
        </div>
        <div class="form-group mx-4">
            <label for="bagian" class="text-md text-primary font-weight-bold mt-2">Bagian</label>
            <input type="text" id="bagian" class="form-control" name="bagian" value="{{ old('bagian', $absenkaryawan->bagian->nama_bagian) }}" readonly>
        </div>
        <div class="form-group mx-4">
            <label for="userbagian" class="text-md text-primary font-weight-bold mt-2">User Bagian</label>
            <input type="text" id="userbagian" class="form-control" name="userbagian" value="{{ old('userbagian', $absenkaryawan->userbagian->nama_user_bagian) }}" readonly>
        </div>
        <div class="form-group mx-4">
            <label for="absen_keluar" class="text-md text-primary font-weight-bold mt-2">Absen Anda Ketika Keluar</label>
            <input type="text" class="form-control" id="absen_keluar" name="absen_keluar" value="{{ $time_now }}" readonly>
        </div>
        <div class="text-center">
            <img src="{{ asset('storage/' . $absenkaryawan->foto_absen) }}" alt="Foto Absen" class="lightbox mx-auto d-block" style="max-width: 30%; height: auto;">
        </div>
        <div class="d-flex justify-content-center container-fluid">
            <button type="submit" class="btn btn-danger px-3 py-2 my-3 mx-2" style="width:100%">Absen Keluar</button>
        </div>
    </form>
</div>

@endsection
