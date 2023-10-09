<h2 class="text-primary font-weight-bold m-4">Rekapan Absen</h2>
<p class="mb-2">Tanggal: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}</p><br>
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
