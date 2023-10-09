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
        <h1>Tambah Lembur Harian</h1>
        <form action="{{ route('lemburharian.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="desc_lemburan">Deskripsi Lemburan :</label>
                <input type="text" id="desc_lemburan" class="form-control" name="desc_lemburan" required>
            </div>
            <div class="form-group">
                <label for="lemburan">Jam Lembur Harian:</label>
                <input type="text" id="lemburan" class="form-control" name="lemburan" required>
            </div>
            <div class="button-save d-flex justify-content-end">
                <a href="/gajilemburharian" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
