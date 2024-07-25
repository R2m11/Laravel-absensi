@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/dt-1.12.1/date-1.1.2/fc-4.1.0/r-2.3.0/sc-2.0.7/datatables.min.css" />
@endpush

@push('scripts')
    <script src="{{ '/template/vendor/datatables/jquery.dataTables.min.js' }}"></script>
    <script src="{{ '/template/vendor/datatables/dataTables.bootstrap4.min.js' }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });
    </script>
@endpush
@section('content')
@if (Auth::user()->position->position_name == "HR")
<div class="card-body text-center">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Karyawan</p>
                                <h4 class="card-title">{{ count($user) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Tanggal: {{ \Carbon\Carbon::parse($date_now)->format('d-m-Y') }}</p>
                                <h6 class="card-title">Jam: {{ $time_now }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endif



@if (Auth::user()->position->position_name == "Administrator")
<div class="card-body text-center">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Karyawan</p>
                                <h4 class="card-title">{{ count($user) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Check Kehadiran</p>
                                <h4 class="card-title">{{ count($kehadiran) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Tanggal: {{ \Carbon\Carbon::parse($date_now)->format('d-m-Y') }}</p>
                                <h6 class="card-title">Jam: {{ $time_now }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mx-4 my-4 px-2"><br>
    <h1 class="text-primary text-center">Absensi Yang Sudah dibuat Hari Ini</h1><br>
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
            @if ($absensi->isEmpty())
            <tr>
                <td colspan="4" class="text-center">Anda Belum Membuat Absensi</td>
            </tr>
            @else
            @foreach ($absensi as $absensi)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                    <td>{{ $absensi->jadwal->shift }}</td>
                    <td>{{ $absensi->jadwal->jam_masuk }}</td>
                    <td>{{ $absensi->jadwal->jam_keluar }}</td>
                </tr>
            @endforeach
            @endif
        </table>
    </tbody>
    <div class="d-flex justify-content-center">
            <div class="col-md-4">
                <a href="/absensi/create" class="btn btn-primary btn-block">Buat Absensi</a>
            </div>
    </div><br>
</div>

<div class="card mx-4 my-4 px-2"><br>
    <h1 class="text-primary text-center">Check Kehadiran</h1><br>
    <div class="table-responsive p-3">
        <table class="table table-flush table-hover"  data-bs-searching="true" id="dataTable">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">User Bagian</th>
                    <th scope="col">Shift Masuk</th>
                    <th scope="col">Keterangan Hari</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($kehadiran->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Belum Ada Karyawan yang mengisi absen</td>
                </tr>
                @else
                @foreach ($kehadiran as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->absenkaryawan->absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                    <td>{{ $item->absenkaryawan->user->name }}</td>
                    <td>{{ $item->absenkaryawan->bagian->nama_bagian }}</td>
                    <td>{{ $item->absenkaryawan->userbagian->nama_user_bagian }}</td>
                    <td>{{ $item->absenkaryawan->absensi->jadwal->shift }}</td>
                    <td>{{ $item->absenkaryawan->absensi->deskripsi }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
                @endif
            </tbody>
        </table>
    <div class="d-flex justify-content-center">
        <div class="col-md-4">
            <a href="/kehadiran" class="btn btn-primary btn-block">Check Kehadiran</a>
        </div>
</div><br>
</div>
<h1 class="text-primary text-center">Inputan tidak Hadir Karyawan</h1><br>
<div class="d-flex justify-content-center">
    <div class="col-md-4">
        <a href="/xkehadiran/create" class="btn btn-danger btn-block">Izin || Sakit</a>
    </div>
    <div class="col-md-4">
        <a href="/xkehadiran" class="btn btn-primary btn-block">Lihat Data Izin || Sakit</a>
    </div>
</div><br>
@endif




{{-- Ini adalah Bagian untuk karyawan --}}
@if (Auth::user()->position->position_name == "Karyawan")
<div class="card-body text-center">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Tanggal: {{ \Carbon\Carbon::parse($date_now)->format('d-M-Y') }}</p>
                                <h6 class="card-title">Jam: {{ $time_now }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ( $absenkaryawan as $absensik )
@if ($absensik->absen_keluar == null)
    <h1 class="text-danger text-center font-weight-bold m-0 mr-3">Anda Belum Melakukan Absen keluar hari ini</h1>
@endif
@endforeach
    <div class="card mx-4 my-4 px-2"><br>
        <h1 class="text-primary text-center font-weight-bold m-0 mr-3">Absen Yang tersedia</h1><br>
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
                @forelse ($absensi as $absensi)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                    <td>{{ $absensi->jadwal->shift }}</td>
                    <td>{{ $absensi->jadwal->jam_masuk }}</td>
                    <td>{{ $absensi->jadwal->jam_keluar }}</td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="4">Absen Belum Dibuat Oleh admin</td>
                </tr>
                @endforelse
            </table>
        </tbody>
        <div class="d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="/absenkaryawan/create" class="btn btn-primary btn-block">Absen Masuk</a>
                </div>
                @foreach ( $absenkaryawan as $absensik )
                @if ($absensik->absen_keluar == null)
                <div class="col-md-4">
                    <a href="/absenkaryawan/{{ $absensik->id}}/edit"
                    class="btn btn-danger btn-block">Absen Keluar</a>
                </div>
                @endif
                @endforeach
        </div><br>
    </div>
@endif

@endsection
