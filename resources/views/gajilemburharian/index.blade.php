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
        <h1 class="text-primary m-4">Tambahkan Gaji dan Lemburan</h1>
        <div class="card-body d-flex justify-content-start">
            <a href="{{ route('gajiharian.create') }}" class="btn btn-primary mr-3">Tambah Gaji</a>
            <a href="{{ route('lemburharian.create') }}" class="btn btn-primary">Tambah Lemburan</a>
        </div>
    </div>
</div>
@endif
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Gaji Harian</h4>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Karyawan</th>
                        <th>Nominal Gaji Harian</th>
                        <th>Nominal Lembur Harian</th>
@if (Auth::user()->position->position_name == "Administrator")
                        <th>Aksi</th>
@endif
                    </tr>
                </thead>
                <tbody>
                    @if($gajiharian->count() > 0)
                    @foreach($gajiharian as $index=> $result)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $result->desc_gaji }}</td>
                            <td class="rupiah">{{ $result->gaji }}</td>
                            <td class="rupiah">{{ $result->lembur_perjam }}</td>
@if (Auth::user()->position->position_name == "Administrator")
                            <td>
                                <a href="/gajiharian/{{$result->id}}/edit" class="btn-sm btn-info px-3 py-2" style="text-decoration: none;color:white">Edit</a>
                                <form action="{{ route('gajiharian.destroy', $result->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data gaji harian ini?')">Hapus</button>
                                </form>
                            </td>
@endif
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


<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Lembur Harian</h4>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Lembur</th>
                        <th>Jam</th>
@if (Auth::user()->position->position_name == "Administrator")
                        <th>Aksi</th>
@endif
                    </tr>
                </thead>
                <tbody>
                    @if($lemburharian->count() > 0)
                    @foreach($lemburharian as $index=> $result)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $result->desc_lemburan }}</td>
                            <td>{{ $result->lemburan }} Jam</td>
@if (Auth::user()->position->position_name == "Administrator")
                            <td>
                                <a href="/lemburharian/{{$result->id}}/edit" class="btn-sm btn-info px-3 py-2" style="text-decoration: none;color:white">Edit</a>
                                <form action="{{ route('lemburharian.destroy', $result->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data lembur harian ini?')">Hapus</button>
                                </form>
                            </td>
@endif
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
