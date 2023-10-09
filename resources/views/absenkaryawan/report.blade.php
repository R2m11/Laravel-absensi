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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Daftar Hadir Anda</h1>
    <div class="d-flex justify-content-start align-items-center">
        @foreach ( $absenkaryawan as $absensi )
            @if ($absensi->absen_keluar == null)
                <h1 class="text-danger font-weight-bold m-0 mr-3">Anda Belum Melakukan Absen keluar hari ini</h1>
            @endif
        @endforeach
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal Absen</th>
                        <th>Shift Masuk</th>
                        <th>Bagian</th>
                        <th>User Bagian</th>
                        <th>Foto Absen</th>
                        <th>Status</th>
                        <th>Absen Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absenkaryawan as $absenk)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absenk->absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                            <td>{{ $absenk->absensi->jadwal->shift }}</td>
                            <td>{{ $absenk->bagian->nama_bagian }}</td>
                            <td>{{ $absenk->userbagian->nama_user_bagian }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $absenk->foto_absen) }}" alt="Foto Absen" style="max-width: 200px;">
                            </td>
                            <td>
                                @foreach($kehadiran as $k)
                                    @if($k->absenkaryawan_id == $absenk->id)
                                        {{ $k->status }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if($absenk->absen_keluar == null)
                                    <a href="/absenkaryawan/{{ $absenk->id }}/edit" class="btn btn-danger btn-sm btn-block">Isi Absen Keluar</a>
                                @else
                                    Absen Keluar Sudah Diisi
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
