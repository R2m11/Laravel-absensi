@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('content')
<h1 class="text-primary font-weight-bold m-4">Data Karyawan</h1>

<div class="card mx-4 my-4">
    <div class="p-3">
        <form action="" method="POST">
            @csrf
            <div class="form-row ">
                <div class="col-md-4">
                    <label for="tanggalAwal">Tanggal Awal:</label>
                    <input type="date" class="form-control" id="tanggalAwal" name="tanggalAwal" required>
                </div>
                <div class="col-md-4">
                    <label for="tanggalAkhir">Tanggal Akhir:</label>
                    <input type="date" class="form-control" id="tanggalAkhir" name="tanggalAkhir" required>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Generate Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card mx-4 my-4">
    <div class="table-responsive p-3">
        @php
            $groupedKehadiran = $kehadiran->groupBy('absenkaryawan.bagian_id');
        @endphp

        @foreach ($groupedKehadiran as $bagianId => $group)
            @php
                $bagian = $group->first()->absenkaryawan->bagian->nama_bagian;
                $showStatus = true; // Variabel untuk menampilkan status
            @endphp

            <table class="table table-bordered mb-1">
                <thead class="thead-light">
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        <th colspan="1000">{{$bagian}}</th>
                    </tr>
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Kode Karyawan</th>
                        <th>Bagian</th>
                        @foreach ($tanggalAbsensi as $tanggal)
                            <th>{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                        @endforeach
                        @if ($showStatus)
                            <th>Hadir</th>
                            <th>Telat</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentIndex = 0;
                    @endphp
                    @foreach ($group as $index => $kehadiranItem)
                        <tr>
                            <td>{{ ++$currentIndex }}</td>
                            <td>{{ $kehadiranItem->absenkaryawan->user->name }}</td>
                            <td>{{ $kehadiranItem->absenkaryawan->user->profile->kode_karyawan }}</td>
                            <td>{{ $bagian }}</td>
                            @foreach ($tanggalAbsensi as $tanggal)
                                <td>
                                    @php
                                        $status = '-';
                                    @endphp
                                    @foreach ($group as $k)
                                        @if ($k->absenkaryawan->absensi->tanggal_absensi == $tanggal)
                                            @php
                                                $status = $k->status ?? '-';
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{ $status }}
                                </td>
                            @endforeach
                            @if ($showStatus)
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php
                $showStatus = false; // Setelah tampil sekali, status tidak ditampilkan lagi
            @endphp
        @endforeach
    </div>
</div>

@endsection
