@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('navbar')
    @include('part.navbar')
@endsection

@section('content')

<h1 class="text-primary font-weight-bold m-4">Absen Masuk Karyawan</h1>

<div class="card mx-4 my-4 px-2 flexible-card d-flex flex-column">

    <form action="/absenkaryawan" method="POST" enctype="multipart/form-data">
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

        <!-- Form-form bawah yang akan muncul jika absensi_id sudah diisi -->
        <div id="form-section" style="display: none;">
            <div class="form-group">
                <label for="bagian">Bagian:</label>
                <select name="bagian" id="bagian" class="form-control" required>
                    <option value="" selected disabled>Pilih Bagian</option>
                    @foreach($bagian as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_bagian }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="userbagian">User Bagian:</label>
                <select name="userbagian" id="userbagian" class="form-control" required disabled>
                    <option value="" selected disabled>Pilih User Bagian</option>
                </select>
            </div>
            <div class="form-group mx-4 text-center">
                <label for="foto_absen" class="text-md text-primary font-weight-bold">Tambah Photo Absen</label>
                <div class="custom-file">
                    <input type="file" name="foto_absen" id="foto_absen" onchange="previewImage(event)"><br> <br>
                    <div class="image-container d-flex justify-content-center align-items-center">
                        <img id="imagePreview" src="#" alt="Foto Absen" class="img-fluid" style="max-width: 290px; height: auto;">
                    </div>

                </div>
                @error('foto_absen')
                    <div class="alert-danger"> {{ $message }}</div>
                @enderror
            </div>

        <div class="d-flex justify-content-end align-items-center">
            <a href="/absenkaryawan" class="btn btn-danger px-3 py-2 my-3">Batal</a>
            <a class="btn btn-info px-3 py-2 my-3 mx-2" data-toggle="modal" data-target="#dataModal">Tambah</a>
        </div>

</div>

<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">KONFIRMASI KEHADIRAN!!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>PASTIKAN DATA YANG ANDA INPUTKAN SUDAH BENAR</p>
                <p>DAN PASTIKAN FOTO ABSENSI YANG BENAR AGAR TIDAK SALAH UPLOAD</p>
                <p>Shift Masuk: <span id="modalShiftMasuk"></span></p>
                <p>Bagian: <span id="modalBagian"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')
    <script>
        // Ambil elemen select absensi_id dan form-section
        const selectAbsensi = document.getElementById('absensi_id');
        const formSection = document.getElementById('form-section');

        // Fungsi untuk menampilkan atau menyembunyikan form-form bawahnya
        function toggleFormSection() {
            // Jika absensi_id sudah diisi (tidak bernilai kosong), maka tampilkan form-form bawahnya
            if (selectAbsensi.value !== "") {
                formSection.style.display = 'block';
            } else {
                // Jika absensi_id belum diisi (masih kosong), maka sembunyikan form-form bawahnya
                formSection.style.display = 'none';
            }
        }

        // Panggil fungsi toggleFormSection saat absensi_id berubah (event change)
        selectAbsensi.addEventListener('change', toggleFormSection);

        // Panggil fungsi toggleFormSection saat halaman dimuat untuk menampilkan form-form bawahnya jika absensi_id sudah terisi
        document.addEventListener('DOMContentLoaded', toggleFormSection);

        // Ambil elemen select bagian dan userbagian
        const selectBagian = document.getElementById('bagian');
        const selectUserBagian = document.getElementById('userbagian');

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


        function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
        }
    }

        $('#dataModal').on('show.bs.modal', function (event) {
        const absensiId = $('#absensi_id').val();
        const bagianId = $('#bagian').val();

        $('#modalShiftMasuk').text($('#absensi_id option:selected').text());
        $('#modalBagian').text($('#bagian option:selected').text());
    });

    </script>
@endpush
