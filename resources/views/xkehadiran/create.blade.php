@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('navbar')
    @include('part.navbar')
@endsection

@section('content')

<h1 class="text-primary font-weight-bold m-4">Absen Izin atau Sakit Karyawan</h1>

<div class="card mx-4 my-4 px-2 flexible-card d-flex flex-column">

    <form action="/xkehadiran" method="POST">
        @csrf
        <div class="form-group">
            <label for="absensi_id">Shift Masuk:</label>
            <select name="absensi_id" id="absensi_id" class="form-control" required>
                <option value="" selected disabled>Pilih Absen Yang Tersedia</option>
                @foreach($absensi as $ab)
                    <option value="{{ $ab->id }}">{{ $ab->jadwal->shift }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="users_id">Karyawan :</label>
            <select name="users_id" id="users_id" class="form-control" required>
                <option value="" selected disabled>Pilih Karyawan</option>
                @foreach($user as $u)
                    @if ($u->position_id == 2)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bagian_id">Bagian:</label>
            <select name="bagian_id" id="bagian_id" class="form-control" required>
                <option value="" selected disabled>Pilih Bagian</option>
                @foreach($bagian as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_bagian }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="userbagian_id">User Bagian:</label>
            <select name="userbagian_id" id="userbagian_id" class="form-control" required disabled>
                <option value="" selected disabled>Pilih User Bagian</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status" >Sakit/Izin :</label>
            <select class="form-control" name="status" id="status">
                <option value="">Pilih Opsi</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        <div class="form-group">
            <label for="ket">Alasan Tidak Masuk :</label>
            <input type="text" id="ket" class="form-control" name="ket" required>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <a href="/home" class="btn btn-danger px-3 py-2 my-3">Batal</a>
            <a class="btn btn-info px-3 py-2 my-3 mx-2" data-toggle="modal" data-target="#dataModal">Tambah</a>
        </div>

<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">KONFIRMASI KE TIDAK HADIRAN!!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda Yakin untuk tidak masuk hari ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary">Ya</button>
    </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
           const selectBagian = document.getElementById('bagian_id');
        const selectUserBagian = document.getElementById('userbagian_id');

        // Fungsi untuk memfilter data userbagian berdasarkan bagian_id yang dipilih
        function filterUserBagian() {
            // Ambil value bagian_id yang dipilih
            const selectedBagianId = selectBagian.value;

            // Kosongkan daftar userbagian saat ini
            selectUserBagian.innerHTML = '<option value="" selected disabled>Pilih User Bagian</option>';

            // Filter data userbagian berdasarkan bagian_id yang dipilih
            const filteredUserBagian = {!! json_encode($userbagian) !!}.filter(userBagian => userBagian.bagian_id == selectedBagianId);

            // Tambahkan daftar userbagian yang telah difilter ke dalam elemen select userbagian
            filteredUserBagian.forEach(userBagian => {
                const option = document.createElement('option');
                option.value = userBagian.id;
                option.textContent = userBagian.nama_user_bagian;
                selectUserBagian.appendChild(option);
            });

            // Aktifkan kembali elemen select userbagian
            selectUserBagian.disabled = false;
        }

        // Panggil fungsi filterUserBagian saat bagian_id dipilih
        selectBagian.addEventListener('change', filterUserBagian);
</script>

@endpush
