@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('content')
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <h1>Tambah Data Kasbon Karyawan</h1>
        <form action="{{ route('kasbon.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tanggal">Tanggal :</label>
                <input type="date" id="tanggal" class="form-control" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="users_id">Nama Karyawan :</label>
                <select name="users_id" id="users_id" class="form-control" required>
                    <option value="" selected disabled>Pilih Karyawan</option>
                    @foreach($user as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah">Nominal Kasbon :</label>
                <input type="text" id="jumlah" class="form-control" name="jumlah" required>
            </div>
            <div class="button-save d-flex justify-content-end">
                <a href="/kasbon" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
