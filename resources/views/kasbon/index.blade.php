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
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <h1 class="text-primary m-4">Tambahkan Kasbon Karyawan</h1>
        <div class="card-body d-flex justify-content-start">
            <a href="{{ route('kasbon.create') }}" class="btn btn-primary mr-3">Tambah Kasbon</a>
        </div>
    </div>
</div>

<div class="card mx-5 my-4">
    <h1 class="text-primary font-weight-bold m-4">Daftar Kasbon Karyawan</h1>
    <div class="table-responsive p-3">
        <table class="table table-flush table-hover" id="dataTable">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Karyawan</th>
                    <th>Kasbon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($kasbon->count() > 0)
                @foreach($kasbon as $index=> $item)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td class="rupiah">{{ $item->jumlah }}</td>
                        <td>
                            <form action="{{ route('kasbon.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data gaji harian ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Tidak ada data ditemukan.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>





<script>
    $(document).ready(function() {
        // Fungsi untuk mengubah angka menjadi format Rupiah
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + ribuan;
        }

        // Looping untuk setiap elemen td dengan class "rupiah"
        $('.rupiah').each(function() {
            // Ambil nilai angka pada tiap elemen td
            var angka = $(this).text();

            // Format angka menjadi format Rupiah menggunakan fungsi formatRupiah
            var angkaRupiah = formatRupiah(angka);

            // Tampilkan angka dalam format Rupiah pada elemen td
            $(this).text(angkaRupiah);
        });
    });
    </script>

@endsection
