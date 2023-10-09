@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/date-1.1.2/fc-4.1.0/r-2.3.0/sc-2.0.7/datatables.min.css" />
@endpush

@section('content')
<br>
<div class="card pb-5 mx-3">
    <h1 class="text-primary font-weight-bold m-4">Halaman Check Kehadiran</h1>
    <form action="/kehadiran/{{ $kehadiran->id }}" method="post">
        @csrf
        @method('put')
    <div class="form-group mx-4">
        <label for="tanggal_absensi" class="text-md text-primary font-weight-bold mt-2">Tanggal Absen</label>
        <input type="text" id="tanggal_absensi" class="form-control @error('tanggal_absensi') is-invalid @enderror" name="tanggal_absensi" value="{{ old('tanggal_absensi',\Carbon\Carbon::parse($kehadiran->absenkaryawan->absensi->tanggal_absensi)->format('d-m-Y')) }}" readonly>
    </div>
    <div class="form-group mx-4">
        <label for="name" class="text-md text-primary font-weight-bold mt-2">Nama Karyawan</label>
        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $kehadiran->absenkaryawan->user->name) }}" readonly>
    </div>
    <div class="form-group mx-4">
        <label for="bagian" class="text-md text-primary font-weight-bold mt-2">Bagian</label>
        <select name="bagian" id="bagian" class="form-control" required>
            <option value="">Pilih Bagian</option>
            @foreach($bagian as $b)
                <option value="{{ $b->id }}" {{ old('bagian', $kehadiran->absenkaryawan->bagian->id) == $b->id ? 'selected' : '' }}>{{ $b->nama_bagian }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mx-4">
        <label for="userbagian" class="text-md text-primary font-weight-bold mt-2">User Bagian</label>
        <select name="userbagian" id="userbagian" class="form-control" required>
            <option value="">Pilih User Bagian</option>
            @foreach($userbagian as $ub)
                <option value="{{ $ub->id }}" {{ old('userbagian', $kehadiran->absenkaryawan->userbagian->id) == $ub->id ? 'selected' : '' }}>{{ $ub->nama_user_bagian }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mx-4">
        <label for="shift" class="text-md text-primary font-weight-bold mt-2">Shift Masuk</label>
        <input type="text" id="shift" class="form-control @error('shift') is-invalid @enderror" name="shift" value="{{ old('shift', $kehadiran->absenkaryawan->absensi->jadwal->shift) }}" readonly>
    </div>
    <div class="form-group row mx-5">
        <div class="col-6">
            <label for="jam_masuk" class="text-md text-primary font-weight-bold">Jam Masuk</label>
            <input class="form-control @error('jam_masuk') is-invalid @enderror" type="time" name="jam_masuk" id="jam_masuk" value="{{ old('jam_masuk', $kehadiran->absenkaryawan->absensi->jadwal->jam_masuk) }}" readonly>
        </div>
        <div class="col-6">
            <label for="jam_keluar" class="text-md text-primary font-weight-bold">Jam Keluar</label>
            <input class="form-control @error('jam_keluar') is-invalid @enderror" type="time" name="jam_keluar" id="jam_keluar" value="{{ old('jam_keluar', $kehadiran->absenkaryawan->absensi->jadwal->jam_keluar) }}" readonly>
        </div>
    </div>
    <div class="form-group row mx-5">
        <div class="col-6">
            <label for="absen_masuk" class="text-md text-primary font-weight-bold">Absen Masuk Karyawan</label>
            <input class="form-control @error('absen_masuk') is-invalid @enderror" type="time" name="absen_masuk" id="absen_masuk" value="{{ old('absen_masuk', $kehadiran->absenkaryawan->absen_masuk) }}" readonly>
        </div>
        <div class="col-6">
            <label for="absen_keluar" class="text-md text-primary font-weight-bold">Absen Keluar Karyawan</label>
            <input class="form-control @error('absen_keluar') is-invalid @enderror" type="time" name="absen_keluar" id="absen_keluar" value="{{ old('absen_keluar', $kehadiran->absenkaryawan->absen_keluar) }}" readonly>
        </div>
    </div>
    <div class="form-group mx-4 d-flex justify-content-center">
        <label for="foto_absen" class="text-md text-primary font-weight-bold mt-2">Absensi Foto</label>
    </div>
    <div class="text-center">
        <a href="{{ asset('storage/' . $kehadiran->absenkaryawan->foto_absen) }}" data-lightbox="gallery">
            <img src="{{ asset('storage/' . $kehadiran->absenkaryawan->foto_absen) }}" alt="Foto Absen" class="lightbox mx-auto d-block" style="max-width: 30%; height: auto;">
        </a>
    </div>

    <div class="form-group mx-4">
        <label for="status" class="text-md text-primary font-weight-bold mt-2">Status Karyawan</label>
        <select class="form-control" name="status" id="status">
            <option value="">{{$kehadiran->status}}</option>
            <option value="Hadir">Hadir</option>
            <option value="Telat">Telat</option>
        </select>
    </div>
    <div class="form-group mx-4">
        <label for="ket" class="text-md text-primary font-weight-bold mt-2">Hitungan Hari biasa atau Lembur/Libur</label>
        <select class="form-control" name="ket" id="ket">
            <option value="">{{$kehadiran->ket}}</option>
            <option value="Hari Biasa">Hari Biasa </option>
            <option value="Libur">Libur</option>
        </select>
    </div>
    <div class="form-group mx-4">
        <label for="gajiharian_id" class="text-md text-primary font-weight-bold mt-2">Gaji Karyawan Harian</label>
        <input class="form-control @error('gajiharian_id') is-invalid @enderror" type="text" name="gajiharian_id" id="gajiharian_id" value="{{ old('gajiharian_id', $kehadiran->absenkaryawan->user->profile->gajiharian->desc_gaji) }}" readonly>
    </div>
    <div class="form-group mx-4">
        <label for="lemburharian_id" class="text-md text-primary font-weight-bold mt-2">Lembur Karyawan (Jika ada) :</label>
        <select name="lemburharian_id" id="lemburharian_id" class="form-control" required>
            <option value="" selected disabled>{{ $kehadiran->lemburharian->desc_lemburan }}</option>
            @foreach($lemburharian as $lembur)
                <option value="{{ $lembur->id }}">{{ $lembur->desc_lemburan }} = {{ $lembur->lemburan }} jam</option>
            @endforeach
        </select>
    </div>
    <div class="button-save d-flex justify-content-end">
        <a href="/kehadiran" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
        <a class="btn btn-primary mt-4 mx-2 px-5 py-1" data-toggle="modal" data-target="#dataModal">Simpan</a>
    </div>
</div>
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Konfirmasi Data Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Nama : <span id="modalNama"></span></p>
                <p>Bagian: <span id="modalBagian"></span></p>
                <p>Absen Masuk : <span id="modalAbsenMasuk"></span></p>
                <p>Karyawan Masuk : <span id="modalKaryawanMasuk"></span></p>
                <p>Absen keluar : <span id="modalAbsenKeluar"></span></p>
                <p>Karyawan keluar : <span id="modalKaryawanKeluar"></span></p>
                <p>Status Kehadiran : <span id="modalStatus"></span></p>
                <p>Masuk Lembur/Tidak : <span id="modalKet"></span></p>
                <p>Pastikan Data Lemburan perjam Yang Diinputkan Sudah Benar</p>
                <p>Dan Data-data yang lain agar tidak terjadi kesalahan</p>
                <p>Jika Sudah Yakin Anda Bisa Mengklik Tombol Konfirmasi Dibawah</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
        </form>
        </div>
    </div>
</div>
{{--
<script src="/path/to/lightbox.js"></script> --}}
@endsection

@push('scripts')
<script>
    $('#dataModal').on('show.bs.modal', function (event) {
        console.log('Modal event triggered.');
        const nama = $('#name').val();
        const bagian = $('#bagian').val();
        const absenMasuk = $('#jam_masuk').val();
        const karyawanMasuk = $('#absen_masuk').val();
        const absenKeluar = $('#jam_keluar').val();
        const karyawanKeluar = $('#absen_keluar').val();
        const status = $('#status').val();
        const ket = $('#ket').val();
        const lemburOption = $('#lemburharian_id option:selected');

        $('#modalNama').text(nama);
        $('#modalBagian').text(bagian);
        $('#modalAbsenMasuk').text(absenMasuk);
        $('#modalKaryawanMasuk').text(karyawanMasuk);
        $('#modalAbsenKeluar').text(absenKeluar);
        $('#modalKaryawanKeluar').text(karyawanKeluar);
        $('#modalStatus').text(status);
        $('#modalKet').text(ket);
    });
</script>
@endpush
