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
        <h1 class="text-primary m-4">Daftar Bagian Perusahaan</h1>
        <div class="card-body">
            <a href="{{ route('bagian.create') }}" class="btn btn-primary mb-3">Tambah Bagian</a>
        </div>
        @foreach($perusahaan as $p)
            <h2>{{ $p->nama_perusahaan }}</h2>
            <ul>
                @foreach($p->bagian as $bagian)
                    <li>{{ $bagian->nama_bagian }} - {{ $bagian->tagihan_harian }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>
@endsection
