
@php
$User = $kehadiran->groupBy('absenkaryawan.user.id');
$Bagian = $kehadiran->groupBy('absenkaryawan.bagian.id');
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
<h2 class="text-primary text-center font-weight-bold m-4">Gaji Karyawan</h2>
<p class="mb-2">Tanggal: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}</p>
      <table class="table table-bordered mb-1">
        <thead>
            <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
                <th>Nama</th>
                <th>Kode Karyawan</th>
                <th>Level Gaji dan Lemburan</th>
                <th>Total Masuk</th>
                <th>Total Jam Lembur</th>
                <th>Proyek Bagian</th>
                <th>Total Upah Lemburan</th>
                <th>Total Gaji Harian</th>
                <th>Kasbon</th>
                <th>Total Upah</th>
            </tr>
        </thead>
        <tbody>
            @php
            $grandTotal = 0;
            $grandTotalTagihan = 0;
            $totalLemburan = 0;
            @endphp
            @foreach ($User as $userId => $group)
            @php
                $user = $group->first()->absenkaryawan->user;
                $kodeKaryawan = $user->profile->kode_karyawan;
                $gajiharian = $user->profile->gajiharian;

                $hadirCount = $group->where('status', 'Hadir')->count();
                $weekendCount = $group->where('status', 'Weekend')->count();
                $telatCount = $group->where('status', 'Telat')->count();
                $masukCount =  $hadirCount + $telatCount;
                $day = $masukCount + $weekendCount;
                // Menghitung gaji lemburan dan gaji harian
                $gajiHarian = $group->sum(function ($item){
                    if ($item->ket == 'Libur') {
                        return ($item->gajiHarian ? $item->gajiHarian->gaji : 0) * 2;
                    } elseif ($item->status === 'Izin' || $item->status === 'Sakit') {
                        return ($item->gajiHarian ? $item->gajiHarian->gaji : 0) * 0;
                    }
                    return $item->gajiHarian ? $item->gajiHarian->gaji : 0;
                });
                $totalJamLembur = $group->sum(function ($item) {
                    return $item->lemburHarian ? $item->lemburHarian->lemburan : 0;
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
                <td>{{ $user->name }}</td>
                <td>{{ $kodeKaryawan }}</td>
                <td>
                    {{ 'Rp.' . number_format($gajiharian->gaji, 0, ',', '.') }} - {{ 'Rp.' . number_format($gajiharian->lembur_perjam, 0, ',', '.') }}
                </td>
                <td class="text-center">{{ $day }}</td>
                <td class="text-center">{{ $totalJamLembur }} jam</td>
                <td>
                    @foreach ($group->whereIn('status', ['Hadir', 'Telat','Weekend'])->groupBy('bagian.nama_bagian') as $bagian => $kehadiran)
                        {{ $bagian }}: {{ $kehadiran->count() }} <br>
                        @foreach ($group->where('status', 'Weekend')->groupBy('bagian.nama_bagian') as $k)
                        Weekend Masuk :
                            @foreach ($k as $item)
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }} <br>
                            @endforeach
                        @endforeach
                    @endforeach
                </td>
                <td>
                    {{ 'Rp.' . number_format($lemburHarian, 0, ',', '.') }}
                </td>
                <td>{{ 'Rp.' . number_format($gajiHarian, 0, ',', '.') }}</td>
                <td>{{ 'Rp.' . number_format($totalKasbon, 0, ',', '.') }}</td>
                <td>{{ 'Rp.' . number_format($totalGaji, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <td colspan="9" class="text-right font-weight-bold">Grand Total</td>
                <td>{{ 'Rp.' . number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <br><br>

    <h2 class="text-primary text-center font-weight-bold m-4">Tagihan Bagian</h2>
    <p class="mb-2">Tanggal: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}</p>
    @php
         $totalTagihan = 0;
    @endphp
    <table class="table table-bordered mb-1">
      <thead>
          <tr class="text-center bg-light" style="font-weight: bold; line-height: 1;">
              <th>Bagian</th>
              <th>Nilai Tagihan Harian</th>
              <th>Nilai Tagihan Lemburan Harian</th>
              <th>Total Masuk</th>
              <th>Total Jam Lembur</th>
              <th>Jumlah Tagihan Lemburan</th>
              <th>Jumlah Tagihan Harian</th>
              <th>Member Bagian</th>
              <th>Total Tagihan</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($Bagian as $bagianId => $group)
        @php
        $bagian = $group->first()->absenkaryawan->bagian;
        $totalMasuk = $group->whereIn('status', ['Hadir', 'Telat'])->count();
        $nilai = $bagian->tagihan_harian;
        $lembur = $bagian->tagihan_harian_perjam;
        $totalJamLembur = $group->sum(function ($item) {
            return $item->lemburHarian ? $item->lemburHarian->lemburan : 0;
        });
        $jumlahLembur = $totalJamLembur * $lembur;
        $jumlahTagihan = $totalMasuk * $nilai;
        $totalTagihan = $jumlahTagihan + $jumlahLembur;
        $grandTotalTagihan += $totalTagihan;
        @endphp
        <tr>
            <td>{{ $bagian->nama_bagian }}</td>
            <td>{{ 'Rp. ' . number_format($nilai, 0, ',', '.') }}</td>
            <td>{{ 'Rp. ' . number_format($lembur, 0, ',', '.') }}</td>
            <td>{{ $totalMasuk }}</td>
            <td>{{ $totalJamLembur }} jam</td>
            <td>{{ 'Rp. ' . number_format($jumlahLembur, 0, ',', '.') }}</td>
            <td>{{ 'Rp. ' . number_format($jumlahTagihan, 0, ',', '.') }}</td>
            <td>
                @foreach ($group->whereIn('status', ['Hadir', 'Telat'])->groupBy('user.name') as $user => $hadir)
                {{ $user }} : {{ $hadir->count() }} <br>
                @endforeach
            </td>
            <td>{{ 'Rp. ' . number_format($totalTagihan, 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr class="bg-light">
            <td colspan="8" class="text-right font-weight-bold">Grand Total Tagihan</td>
            <td>{{ 'Rp.' . number_format($grandTotalTagihan, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
  </table>
  <br><br>
