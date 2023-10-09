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
        <h1 class="text-primary font-weight-bold m-4">Daftar Absensi Yang dibuat</h1>
        <div class="table-responsive p-3">
            <table class="table table-flush table-hover" >
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Bagian Shift</th>
                        <th scope="col">Keterangan Hari</th>
                        <th scope="col">Tombol Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensi as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_absensi)->format('d-m-Y') }}</td>
                            <td>{{ $item->jadwal->shift }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                <form action="{{ route('absensi.destroy', $item->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Jadwal ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    <tr class="text-center bg-light">
                        <td colspan="4">Anda Belum Menambahkan Absensi Hari ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mx-3 my-4">
                <a href="/absensi/create" class="btn btn-info mx-2"> <i class="fa-solid fa-plus"></i> Tambah Daftar Hadir</a>
            </div>
        </div>
    </div>


    <div class="card mx-4 my-4">
        <h1 class="text-primary font-weight-bold m-4">Semua Data Absensi</h1>
        <div class="table-responsive p-3">
            <table class="table table-flush table-hover" id="dataTable"  >
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Bagian Shift</th>
                        <th scope="col">Keterangan Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensiall as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_absensi)->format('d-m-Y') }}</td>
                            <td>{{ $item->jadwal->shift }}</td>
                            <td>{{ $item->deskripsi }}</td>
                        </tr>
                    @empty
                        Tidak Ada Absensi Hari ini
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

