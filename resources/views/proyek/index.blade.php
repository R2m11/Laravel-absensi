@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
@if (Auth::user()->position->position_name == "Administrator")
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <h1 class="text-primary m-4">Tambahkan Perusahaan, Bagian, dan User Bagian</h1>
        <div class="card-body d-flex justify-content-start">
            <a href="{{ route('perusahaan.create') }}" class="btn btn-primary mr-3">Tambah Perusahaan</a>
            <a href="{{ route('bagian.create') }}" class="btn btn-primary mr-3">Tambah Bagian</a>
            <a href="{{ route('userbagian.create') }}" class="btn btn-primary">Tambah User Bagian</a>
        </div>
    </div>
</div>
@endif
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Perusahaan</h4>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Cari..." aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
            </form>
        </div>

        <div class="card-body">
            <table class="table table-flush table-hover" id="dataTable" data-bs-searching="true">
                <thead>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Nama Bagian</th>
                        <th>Nama User Bagian</th>
                    </tr>
                </thead>
                <tbody>
                    @if($searchResults->count() > 0)
                    @foreach($searchResults as $result)
                        <tr>
                            <td>{{ $result->nama_perusahaan }}</td>
                            <td>{{ $result->nama_bagian }} - {{ $result->tagihan_harian }}</td>
                            <td>{{ $result->nama_user_bagian }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">Tidak ada data ditemukan.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@if (Auth::user()->position->position_name == "Administrator")
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        @foreach($perusahaan as $p)
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>{{ $p->nama_perusahaan }}</h2>
                    <form action="{{ route('perusahaan.destroy', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <a href="/perusahaan/{{ $p->id }}/edit" class="btn-sm btn-info px-3 py-2" style="text-decoration: none;color:white">Edit</a>
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')">Hapus</button>
                    </form>
                </div>
                <hr>
                <ul>
                    @foreach($bagian as $b)
                        @if($b->perusahaan_id == $p->id)
                            <li>
                                <div class="d-flex justify-content-between align-items-center">
                                    {{ $b->nama_bagian }}  <p class="rupiah"> {{ $b->tagihan_harian }} </p>
                                    <form action="{{ route('bagian.destroy', $b->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/bagian/{{ $b->id }}/edit" class="btn-sm btn-info px-3 py-2" style="text-decoration: none;color:white">Edit</a>
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus bagian ini?')">Hapus</button>
                                    </form>
                                </div>
                                <hr>
                                <ul>
                                    @foreach($userbagian as $ub)
                                        @if($ub->bagian_id == $b->id)
                                            <li>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{ $ub->nama_user_bagian }}
                                                    <form action="{{ route('userbagian.destroy', $ub->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="/userbagian/{{ $ub->id }}/edit" class="btn-sm btn-info px-3 py-2" style="text-decoration: none;color:white">Edit</a>
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user bagian ini?')">Hapus</button>
                                                    </form>
                                                </div> <hr>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endif



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
