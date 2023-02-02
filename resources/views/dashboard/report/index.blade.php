@extends('app')

@section('content')

<div class="row">
        <div class="col-md-4">
            <div class="metric">
                <span class="icon"><i class="lnr lnr-exit-up"></i></span>
                <p>
                    <span class="number">Laporan</span>
                    <span class="title">Barang Keluar</span>
                    <br>
                    <br>
                    <span class="title">
                        <a href="{{ route('report.detail', 'Keluar') }}" class="btn btn-primary">Detail</a>
                    </span>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric">
                <span class="icon"><i class="lnr lnr-entry-down"></i></span>
                <p>
                    <span class="number">Laporan</span>
                    <span class="title">Barang Masuk</span>
                    <br>
                    <br>
                    <a href="{{ route('report.detail', 'MASUK') }}" class="btn btn-primary">Detail</a>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric">
                <span class="icon"><i class="lnr lnr-store"></i></span>
                <p>
                    <span class="number">Laporan</span>
                    <span class="title">Stok Barang</span>
                    <br>
                    {{-- <a href="{{ route('report.detail') }}">Detail</a> --}}
                </p>
            </div>
        </div>
</div>

@endsection