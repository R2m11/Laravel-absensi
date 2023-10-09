@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('navbar')
    @include('part.navbar')
@endsection

@section('content')

<h1 class="text-primary font-weight-bold m-4">Tambah Absensi Untuk Absen Karyawan</h1>


<div class="card mx-4 my-4 px-2">

    <form action="/absensi" method="post">
        @csrf
        <div class="form-group">
            <label class="text-md text-primary font-weight-bold">Pilih Tanggal</label>
            <input type="date" name="tanggal_absensi" class="form-control">
        </div>
        @error('tanggal_absensi')
            <div class="alert-danger mx-2 px-2 py-2">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="bagian_id">Masukan Shift :</label>
            <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                <option value="" selected disabled>Pilih shift</option>
                @foreach($jadwal as $j)
                    <option value="{{ $j->id }}" data-jam-masuk="{{ $j->jam_masuk }}" data-jam-keluar="{{ $j->jam_keluar }}">{{ $j->shift }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <label for="jam_masuk" class="text-md text-primary font-weight-bold">Jam Masuk</label>
                <input class="form-control" type="time" name="jam_masuk" id="jam_masuk">
            </div>
            <div class="col-6">
                <label for="jam_keluar" class="text-md text-primary font-weight-bold">Jam Keluar</label>
                <input class="form-control" type="time" name="jam_keluar" id="jam_keluar">
            </div>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1" class="text-md text-primary font-weight-bold">Keterangan Hari</label>
            <select class="form-control" name="deskripsi" id="deskripsi">
                <option value="" selected disabled >-- Inputkan Hari --</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="/absensi" class="btn btn-danger px-3 py-2 my-3">Batal</a>
            <button class="btn btn-info px-3 py-2 my-3 mx-2">Tambah</button>
        </div>
    </form>
</div>

<script>
    // Get the select element for shift
    const shiftSelect = document.getElementById('jadwal_id');

    // Get the input elements for jam_masuk and jam_keluar
    const jamMasukInput = document.getElementById('jam_masuk');
    const jamKeluarInput = document.getElementById('jam_keluar');

    // Add event listener to the shift select element
    shiftSelect.addEventListener('change', function() {
        const selectedOption = shiftSelect.options[shiftSelect.selectedIndex];
        const jamMasuk = selectedOption.getAttribute('data-jam-masuk');
        const jamKeluar = selectedOption.getAttribute('data-jam-keluar');

        // Update the value of jam_masuk and jam_keluar inputs
        jamMasukInput.value = jamMasuk;
        jamKeluarInput.value = jamKeluar;
    });
</script>


@endsection

