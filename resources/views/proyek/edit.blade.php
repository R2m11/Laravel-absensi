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
        <h4 class="m-0 font-weight-bold text-primary">Edit Proyek</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('proyek.update', $perusahaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan</label>
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{ $perusahaan->nama_perusahaan }}">
            </div>
            <div class="form-group">
                <label for="nama_bagian">Nama Bagian</label>
                <input type="text" class="form-control" id="nama_bagian" name="nama_bagian" value="{{ $bagian->nama_bagian }}">
            </div>
            <div class="form-group">
                <label for="nama_user_bagian">Nama User Bagian</label>
                <input type="text" class="form-control" id="nama_user_bagian" name="nama_user_bagian" value="{{ $userbagian->nama_user_bagian }}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
