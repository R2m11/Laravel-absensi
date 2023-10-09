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

<div class="card mx-4 my-4">
    <h1 class="text-primary text-center font-weight-bold m-4">Daftar Hadir Pegawai</h1>
    <div class="table-responsive p-3">
        <table class="table table-flush table-hover"  data-bs-searching="true">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">User Bagian</th>
                    <th scope="col">Shift Masuk</th>
                    <th scope="col">Keterangan Hari</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tombol Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($kehadiran->isEmpty())
                    <h2 class="text-center">Belum Ada Karyawan yang mengisi absen</h2><br>
                @else
                @foreach ($kehadiran as $item)
                @if ($item->absenkaryawan && $item->absenkaryawan->absen_keluar == null)

                    <h2>Belum ada absen karyawan yang masuk</h2><br>
                @else
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->absenkaryawan->absensi->tanggal_absensi)->format('d-m-Y') }}</td>
                    <td>{{ $item->absenkaryawan->user->name }}</td>
                    <td>{{ $item->absenkaryawan->bagian->nama_bagian }}</td>
                    <td>{{ $item->absenkaryawan->userbagian->nama_user_bagian }}</td>
                    <td>{{ $item->absenkaryawan->absensi->jadwal->shift }}</td>
                    <td>{{ $item->absenkaryawan->absensi->deskripsi }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        @if ($item->status == 'Belum Diisi')
                            <a href="/kehadiran/{{ $item->id }}/edit" class="btn btn-block btn-danger">Check Kehadiran</a>
                        @else
                            <a href="/kehadiran/{{ $item->id }}/edit" class="btn btn-block btn-primary">Check Kehadiran</a>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="card mx-4 my-4">
    <h1 class="text-primary text-center font-weight-bold m-4">Semua Data kehadiran Pegawai</h1>
    <div class="table-responsive p-3">
        <table class="table table-flush table-hover" id="dataTableHover" data-bs-searching="true">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">User Bagian</th>
                    <th scope="col">Shift Masuk</th>
                    <th scope="col">Keterangan Hari</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kehadiranall as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->absenkaryawan->user->name }}</td>
                    <td>{{ $item->absenkaryawan->bagian->nama_bagian }}</td>
                    <td>{{ $item->absenkaryawan->userbagian->nama_user_bagian }}</td>
                    <td>{{ $item->absenkaryawan->absensi->jadwal->shift }}</td>
                    <td>{{ $item->absenkaryawan->absensi->deskripsi }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <a href="/kehadiran/{{ $item->id }}/edit" class="btn btn-block btn-primary">Edit</a>
                        <form action="/kehadiran/{{ $item->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus bagian ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

