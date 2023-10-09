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
        <h1>Tambah Perusahaan</h1>
        <form action="{{ route('perusahaan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" id="nama_perusahaan" class="form-control" name="nama_perusahaan" required>
            </div>
            <div class="button-save d-flex justify-content-end">
                <a href="/proyek" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
