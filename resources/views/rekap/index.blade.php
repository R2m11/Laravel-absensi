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
    <div class="card-header py-3">
        <form action="{{ route('rekap.index') }}" method="GET">
            <label for="tanggal_awal">Tanggal Awal:</label>
            <input type="date" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal', now()->subMonth()->format('Y-m-d')) }}">

            <label for="tanggal_akhir">Tanggal Akhir:</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir', now()->format('Y-m-d')) }}">

            <button type="submit">Filter</button>
        </form>
    </div>
    <div class="table-responsive p-3">

        @php
        $groupBagian = $kehadiran->groupBy('absenkaryawan.bagian.id');
        $User = $kehadiran->groupBy('absenkaryawan.user.id');
        $bagianAlreadyPrinted = [];

        $Userall = $kehadiran->groupBy('absenkaryawan.user.id');

        $tanggalAwal = \Carbon\Carbon::parse(request('tanggal_awal'));
        $tanggalAkhir = \Carbon\Carbon::parse(request('tanggal_akhir'));
        $filteredTanggalAbsensi = [];

        while ($tanggalAwal->lte($tanggalAkhir)) {
            $filteredTanggalAbsensi[] = $tanggalAwal->format('Y-m-d');
            $tanggalAwal->addDay();
        }
        @endphp
        <h2 class="text-primary text-center font-weight-bold m-4">Absen Pertanggal</h2>
            <table class="table table-bordered mb-1">
                <thead>
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Kode Karyawan</th>
                        <th colspan="{{ count($filteredTanggalAbsensi) * 2 }}">Status Kehadiran</th>
                    </tr>
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        @foreach ($filteredTanggalAbsensi as $tanggal)
                            <th colspan="2">{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentIndex = 0;
                    @endphp
                    @foreach ($Userall as $userId => $group)
                        @php
                            $user = $group->first()->absenkaryawan->user;
                            $kodeKaryawan = $user->profile->kode_karyawan;
                        @endphp
                        <tr>
                            <td>{{ ++$currentIndex }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $kodeKaryawan }}</td>
                            @foreach ($filteredTanggalAbsensi as $tanggal)
                                @php
                                    $absensi = $group->where('tanggal', $tanggal)->first();
                                    $status = $absensi ? $absensi->status : '-';
                                @endphp
                                <td class="text-center">{{ $status }}</td>
                                <td class="text-center">{{ $absensi ? $absensi->bagian->kode_bagian : '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table><br><br>


        <h2 class="text-primary text-center font-weight-bold m-4">Absen Perbagian</h2>
        @foreach ($groupBagian as $bagianId => $group)
            @php
            $bagian = $group->first()->absenkaryawan->bagian->nama_bagian;
            $groupUser = $group->groupBy('absenkaryawan.user.id');
            @endphp
            <table class="table table-bordered mb-1">
                <thead>
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Kode Karyawan</th>
                        <th colspan="{{ count($filteredTanggalAbsensi) * 2 }}">Status Kehadiran</th>
                    </tr>
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        @foreach ($filteredTanggalAbsensi as $tanggal)
                        <th>{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                        @endforeach
                    </tr>
                    @if (!in_array($bagianId, $bagianAlreadyPrinted))
                    @php
                    $bagianAlreadyPrinted[] = $bagianId;
                    @endphp
                    <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                        <th colspan="{{ 3 + (count($filteredTanggalAbsensi) * 2) }}">{{ $bagian }}</th>
                    </tr>
                    @endif
                </thead>
                <tbody>
                    @php
                    $currentIndex = 0;
                    @endphp
                    @foreach ($User as $UserId => $group)
                        @php
                        $user = $group->first()->absenkaryawan->user;
                        $kodeKaryawan = $user->profile->kode_karyawan;
                        @endphp
                        @php
                        $showRow = false;
                        foreach ($filteredTanggalAbsensi as $tanggal) {
                            $absensi = $group->where('bagian_id', $bagianId)->where('tanggal', $tanggal)->first();
                            if ($absensi && $absensi->status != '-') {
                                $showRow = true;
                                break;
                            }
                        }
                        @endphp
                        @if ($showRow)
                            <tr>
                                <td>{{ ++$currentIndex }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $kodeKaryawan }}</td>
                                @foreach ($filteredTanggalAbsensi as $tanggal)
                                    @php
                                    $absensi = $group->where('bagian_id', $bagianId)->where('tanggal', $tanggal)->first();
                                    $status = $absensi ? $absensi->status : '-';
                                    @endphp
                                    <td class="text-center">{{ $status }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endforeach
<br>
        <form action="{{ route('rekap.export.excel') }}" method="GET">
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            <button type="submit" class="btn btn-success">Export Excel</button>
        </form><br>


        <table class="table table-bordered mb-1">
            <thead>
                <tr  class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                    <th colspan="4">Data Karyawan</th>
                    <th colspan="5">Detail</th>
                    <th colspan="6">Penggajihan</th>
                </tr>
                <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kode Karyawan</th>
                    <th>Level Gaji</th>
                    <th>Masuk Libur</th>
                    <th>Hadir</th>
                    <th>Telat</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Total Jam Lembur</th>
                    <th>Gaji Lemburan</th>
                    <th>Gaji Harian</th>
                    <th>Kasbon Karyawan</th>
                    <th>Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentIndex = 0;
                    $grandTotal = 0;
                    $totalLemburan = 0;
                @endphp
                @foreach ($User as $userId => $group)
                    @php
                        $user = $group->first()->absenkaryawan->user;
                        $kodeKaryawan = $user->profile->kode_karyawan;
                        $gajiharian = $user->profile->gajiharian;


                        $hariLemburCount = $group->where('ket', 'Libur')->count();
                        $hadirCount = $group->where('status', 'Hadir')->count();
                        $telatCount = $group->where('status', 'Telat')->count();
                        $izinCount = $group->where('status', 'Izin')->count();
                        $sakitCount = $group->where('status', 'Sakit')->count();

                        $totalJamLembur = $group->sum(function ($item) {
                            return $item->lemburHarian ? $item->lemburHarian->lemburan : 0;
                        });
                        // Menghitung gaji lemburan dan gaji harian
                        $gajiHarian = $group->sum(function ($item){
                            if ($item->ket == 'Libur') {
                                return ($item->gajiHarian ? $item->gajiHarian->gaji : 0) * 2;
                            } elseif ($item->status === 'Izin' || $item->status === 'Sakit') {
                                return ($item->gajiHarian ? $item->gajiHarian->gaji : 0) * 0;
                            }
                            return $item->gajiHarian ? $item->gajiHarian->gaji : 0;
                        });
                        $lemburHarian = $group->sum(function ($item) {
                            $totalJamLemburItem = $item->lemburHarian ? $item->lemburHarian->lemburan : 0;
                            if ($item->ket == 'Libur') {
                                return ($item->gajiHarian ? $item->gajiHarian->lembur_perjam * $totalJamLemburItem * 2 : 0);
                            }
                            return ($item->gajiHarian ? $item->gajiHarian->lembur_perjam * $totalJamLemburItem : 0);
                        });
                        $totalKasbon = $kasbon->where('users_id', $user->id)->sum('jumlah');
                        // Menghitung total gaji berdasarkan kriteria yang Anda sebutkan
                        $totalGaji = ($lemburHarian + $gajiHarian)-$totalKasbon;
                        $grandTotal += $totalGaji;
                    @endphp
                    <tr>
                        <td>{{ ++$currentIndex }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $kodeKaryawan }}</td>
                        <td>{{ $gajiharian->desc_gaji }} - {{ $gajiharian->gaji }}</td>
                        <td>
                            Masuk : {{ $hariLemburCount }}
                            @foreach ($group->where('ket', 'Libur')->groupBy('bagian.kode_bagian') as $bagian => $kehadiran)
                            {{ $bagian }}: {{ $kehadiran->count() }} <br>
                            @foreach ($kehadiran as $item)
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }} <br>
                            @endforeach
                            @endforeach
                        </td>
                        <td>
                            Hadir: {{ $hadirCount }} <br>
                            @foreach ($group->where('status', 'Hadir')->groupBy('bagian.kode_bagian') as $bagian => $kehadiran)
                                {{ $bagian }}: {{ $kehadiran->count() }} <br>
                            @endforeach
                        </td>
                        <td>
                            Telat: {{ $telatCount }} <br>
                            @foreach ($group->where('status', 'Telat')->groupBy('bagian.kode_bagian') as $bagian => $kehadiran)
                                {{ $bagian }}: {{ $kehadiran->count() }} <br>
                            @endforeach
                        </td>
                        <td>
                            Izin: {{ $izinCount }} <br>
                            @foreach ($group->where('status', 'Izin')->groupBy('bagian.kode_bagian') as $bagian => $kehadiran)
                                {{ $bagian }}: {{ $kehadiran->count() }} <br>
                                @foreach ($kehadiran as $item)
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }} <br>
                                @endforeach
                            @endforeach
                        </td>
                        <td>
                            Sakit: {{ $sakitCount }} <br>
                            @foreach ($group->where('status', 'Sakit')->groupBy('bagian.kode_bagian') as $bagian => $kehadiran)
                                {{ $bagian }}: {{ $kehadiran->count() }} <br>
                                @foreach ($kehadiran as $item)
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }} <br>
                                @endforeach
                            @endforeach
                        </td>
                        <td>
                            {{$totalJamLembur}} jam <br>
                            Tanggal :
                            @foreach ($group as $item)
                            @if ($item->lemburHarian && $item->lemburHarian->id !== 1)
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d') }},
                            @endif
                        @endforeach
                        </td>
                        <td>
                            {{ 'Rp.' . number_format($lemburHarian, 0, ',', '.') }}<br>
                        </td>
                        <td>{{ number_format($gajiHarian, 0, ',', '.') }}</td>
                        <td>{{ '- Rp.' . number_format($totalKasbon, 0, ',', '.') }}</td>
                        <td>{{ 'Rp.' . number_format($totalGaji, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-light">
                    <td colspan="13" class="text-right font-weight-bold">Grand Total</td>
                    <td>{{ 'Rp.' . number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        <br><br>
    </div>
</div>
@endsection
