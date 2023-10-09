@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
<h1 class="text-primary m-4">Profile Karywan</h1>
<div class="card m-4">
        <div class="row d-flex" style="gap:3rem">
            <div class="col-2 ml-5 my-4">
                @if ($profile->profile_picture !=null)
                <img src="{{ asset('/images/profile_picture/' . $profile->profile_picture) }}"
                        style="width:150px;height:150px;border-radius:100px">
                @else
                <img src="{{ asset('template/img/boy.jpg') }}" style="width:100px;height:100px;border-radius:50px">
                @endif
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="nama" class="text-lg text-primary font-weight-bold">Nama Lengkap</label>
                    <h4>{{ $profile->user->name }}</h4>
                </div>


                <div class="form-group">
                    <label for="position_name" class="text-lg text-primary font-weight-bold">Posisi</label>
                    <h4>{{ $karyawan->position->position_name }}</h4>
                </div>

                <div class="form-group">
                    <label for="npm" class="text-lg text-primary font-weight-bold">Nomor Pegawai</label>
                    <h4>{{ $profile->kode_karyawan }}</h4>
                </div>

                <div class="form-group">
                    <label for="prodi" class="text-lg text-primary font-weight-bold">Jenis Kelamin</label>
                    <h4>{{ $profile->gender }}</h4>
                </div>

                <div class="form-group">
                    <label for="prodi" class="text-lg text-primary font-weight-bold">Alamat</label>
                    <h4>{{ $profile->address }}</h4>
                </div>

                <div class="form-group">
                    <label for="prodi" class="text-lg text-primary font-weight-bold">Email</label>
                    <h4>{{ $profile->user->email }}</h4>
                </div>

                <div class="form-group mb-3">
                    <label for="prodi" class="text-lg text-primary font-weight-bold">Nomor Telephone</label>
                    <h4>{{ $profile->phone_number }}</h4>
                </div>

            </div>
        </div>
        <div class="edit d-flex justify-content-end my-4 mx-4">
            <a href="/karyawan" class="btn btn-primary px-5">Kembali</a>
        </div>
    </div>
    </div>
@endsection
