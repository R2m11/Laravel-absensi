@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('content')

<h1 class="text-primary font-weight-bold m-4">Absen Karyawan</h1>
<h1 class="text-primary font-weight-bold m-4">{{ $time_local }}</h1>

@if ($absensi->isEmpty())
    <h1 class="text-primary font-weight-bold m-4">Belum Ada Absen Untuk Saat Ini</h1>
@else
    <div class="card mx-4 my-4 px-2"><br>
        <table class="table table-flush table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Tanggal Absen</th>
                    <th>Shift</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $absensi)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                        <td>{{ $absensi->jadwal->shift }}</td>
                        <td>{{ $absensi->jadwal->jam_masuk }}</td>
                        <td>{{ $absensi->jadwal->jam_keluar }}</td>
                    </tr>
                @endforeach
            </table>
        </tbody>
        <div class="d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="/absenkaryawan/create" class="btn btn-primary btn-block">Isi Absen Masuk</a>
                </div>
        </div><br>
    </div>
@endif
@endsection
