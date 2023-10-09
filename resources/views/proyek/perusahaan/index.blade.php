@extends('layouts.master')

@section('navbar')
    @include('part.navbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection


@section('content')
<div class="card mx-5 my-4">
    <div class="card-header py-3">
        <h1 class="text-primary m-4">Daftarkan Perusahaan</h1>
        <div class="card-body">
            <a href="{{ route('perusahaan.create') }}" class="btn btn-primary mb-3">Tambah Perusahaan</a>
        </div>
        @foreach($perusahaan as $p)
            <h2>{{ $p->nama_perusahaan }}</h2>
        @endforeach
    </div>
</div>
@endsection
