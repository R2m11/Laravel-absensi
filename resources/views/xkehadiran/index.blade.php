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
    <h1 class="text-primary text-center font-weight-bold m-4">Semua Data Izin / Sakit Karyawan</h1>
    <div class="table-responsive p-3">
        <table class="table table-flush table-hover" id="dataTable" data-bs-searching="true">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">Status</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($xkehadiran as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->bagian->nama_bagian }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->ket }}</td>
                    <td>
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
        <div class="d-flex justify-content-center">
            <div class="col-md-4">
                <a href="/home" class="btn btn-danger btn-block">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

