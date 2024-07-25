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
        <h1>Edit Gaji Harian</h1>
        <form action="/gajiharian/{{$gajiharian->id}}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="desc_gaji">Deskripsi Gaji :</label>
                <input type="text" id="desc_gaji" class="form-control" name="desc_gaji" required value="{{old('desc_gaji',$gajiharian->desc_gaji)}}">
            </div>
            <div class="form-group">
                <label for="gaji">Nominal Gaji Harian:</label>
                <input type="text" id="gaji" class="form-control" name="gaji" required value="{{old('gaji',$gajiharian->gaji)}}">
            </div>
            <div class="form-group">
                <label for="lembur_perjam">Nominal Lembur Perjam:</label>
                <input type="text" id="lembur_perjam" class="form-control" name="lembur_perjam" required value="{{old('lembur_perjam',$gajiharian->lembur_perjam)}}">
            </div>
            <div class="button-save d-flex justify-content-end">
                <a href="/gajilemburharian" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const gajiInput = document.getElementById('gaji');
        const lemburPerjamInput = document.getElementById('lembur_perjam');

        gajiInput.addEventListener('input', function() {
            const gaji = parseFloat(gajiInput.value);
            if (!isNaN(gaji)) {
                const lemburPerjam = (gaji * 22) / 173;
                lemburPerjamInput.value = lemburPerjam.toFixed(2);
            } else {
                lemburPerjamInput.value = '';
            }
        });
    });
</script>

@endsection
