@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
<br>
@if (Auth::user()->position->position_name == "Administrator")
<div class="col-lg-12">
<div class="card mb-4">
    <div class="card-header">Tambah Shift</div>
    <div class="card-body">
        <form action="{{ route('jadwal.store') }}" method="POST" id="form-jadwal">
            @csrf
            <div class="form-group">
                <label for="shift" class="text-md text-primary font-weight-bold mt-2">Nama Shift</label>
                <input type="text" id="shift" class="form-control @error('shift') is-invalid @enderror" name="shift" value="{{ old('shift') }}">
                @error('shift')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="jam_masuk" class="text-md text-primary font-weight-bold">Jam Masuk</label>
                    <input class="form-control @error('jam_masuk') is-invalid @enderror" type="time" name="jam_masuk" id="jam_masuk">
                    @error('jam_masuk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="jam_keluar" class="text-md text-primary font-weight-bold">Jam Keluar</label>
                    <input class="form-control @error('jam_keluar') is-invalid @enderror" type="time" name="jam_keluar" id="jam_keluar">
                    @error('jam_keluar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
</div>
@endif

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Shift</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
                        @if (Auth::user()->position->position_name == "Administrator")
                        <th scope="col">Tombol Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->shift }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_keluar }}</td>
                            @if (Auth::user()->position->position_name == "Administrator")
                            <td>

                                <button class="btn btn-danger"><a data-toggle="modal"
                                        data-target="#DeleteModal{{ $item->id }}"><i
                                            class="fa-solid fa-trash"></i></a></button>

                                <!--Delete Modal -->
                                <div class="modal fade" id="DeleteModal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="ModalLabelDelete" aria-hidden="true">
                                    <!-- ... Kode modal hapus tetap sama ... -->
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
