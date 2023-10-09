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
        <h1 class="text-primary m-4">Daftar User Bagian</h1>
        <div class="card-body">
            <a href="{{ route('userbagian.create') }}" class="btn btn-primary mb-3">Tambah User Bagian</a>
        </div>
        @foreach($perusahaan as $p)
            <h2>{{ $p->nama_perusahaan }}</h2>
            <ul>
                @foreach($bagian as $b)
                    @if($b->perusahaan_id == $p->id)
                        <li>
                            {{ $b->nama_bagian }}
                            <ul>
                                @foreach($userbagian as $ub)
                                    @if($ub->bagian_id == $b->id)
                                        <li>{{ $ub->nama_user_bagian }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endforeach
    </div>
</div>
@endsection
