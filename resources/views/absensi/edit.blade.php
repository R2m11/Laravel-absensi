@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('navbar')
    @include('part.navbar')
@endsection

@section('content')

<h1 class="text-primary font-weight-bold m-4">Edit Hadir Karyawan</h1>


<div class="card mx-4 my-4 px-2">

    <form action="/absensi/{{ $absensi->first()->id }}" method="post">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="text-md text-primary font-weight-bold">Pilih Tanggal</label>
            <input type="date" name="tanggal_absensi" class="form-control" value="{{ old('tanggal_absensi', $absensi->tanggal_absensi) }}">
        </div>
        @error('tanggal_absensi')
            <div class="alert-danger mx-2 px-2 py-2">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="exampleFormControlTextarea1" class="text-md text-primary font-weight-bold">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="exampleFormControlTextarea1" rows="3">{{ old('deskripsi', $absensi->deskripsi) }}</textarea>
        </div>

        <div class="d-flex justify-content-end">
            <a href="/absensi" class="btn btn-danger px-3 py-2 my-3">Batal</a>
            <button class="btn btn-info px-3 py-2 my-3 mx-2">Tambah</button>
        </div>

    </form>

</div>
@endsection

