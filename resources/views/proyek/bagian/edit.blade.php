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
        <h1>Edit Bagian Perusahaan</h1>
        <form action="/bagian/{{$bagian->id}}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="perusahaan_id">Perusahaan:</label>
                <select name="perusahaan_id" id="perusahaan_id" class="form-control" required>
                    <option value="" selected disabled>{{old('perusahaan_id',$bagian->perusahaan->nama_perusahaan)}}</option>
                    @foreach($perusahaan as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_bagian">Nama Bagian:</label>
                <input type="text" id="nama_bagian" class="form-control" name="nama_bagian" value="{{old('nama_bagian',$bagian->nama_bagian)}}" required>
            </div>
            <div class="form-group">
                <label for="kode_bagian">Initial Bagian:</label>
                <input type="text" id="kode_bagian" class="form-control" name="kode_bagian" value="{{old('kode_bagian',$bagian->kode_bagian)}}" required>
            </div>
            <div class="form-group">
                <label for="tagihan_harian">Tagihan Harian Perbagian:</label>
                <input type="text" id="tagihan_harian" class="form-control" name="tagihan_harian" value="{{old('tagihan_harian',$bagian->tagihan_harian)}}" required>
            </div>
            <div class="form-group">
                <label for="tagihan_harian_perjam">Tagihan Harian Lemburan PerJam:</label>
                <input type="text" id="tagihan_harian_perjam" class="form-control" name="tagihan_harian_perjam" value="{{old('tagihan_harian_perjam',$bagian->tagihan_harian_perjam)}}" required>
            </div>
            <div class="button-save d-flex justify-content-end">
                <a href="/proyek" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tagihanInput = document.getElementById('tagihan_harian');
        const tagihanLemburPerjamInput = document.getElementById('tagihan_harian_perjam');

        tagihanInput.addEventListener('input', function() {
            const tagihan = parseFloat(tagihanInput.value);
            if (!isNaN(tagihan)) {
                const tagihanLemburPerjam = (tagihan * 22) / 173;
                tagihanLemburPerjamInput.value = tagihanLemburPerjam.toFixed(2);
            } else {
                tagihanLemburPerjamInput.value = '';
            }
        });
    });
</script>
@endsection
