@extends('app')

@section('content')

<div class="row d-flex justify-between">
    <div class="col-md-6">
LAPORAN BARANG {{ $title }}
    </div>
    <div class="col-md-6">
        Dikeluarkan Pada Tanggal: {{ $tanggal }}
    </div>
</div>
<div class="row d-flex justify-between">
    <div class="col-md-12">
        <br>
        <p>
            Berikut merupakan laporan data barang {{ $title }} :
        </p>
        <br>
        <table class="table table-bordered mt-3 table-responsive">
            <thead>
                <th>No</th>
                <th>Vendor ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </thead>
            <tbody>
                @foreach ($dataBarang as $v)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $v->vendor_id }}</td>
                        <td>{{ $v->item_id }}</td>
                        <td>{{ $v->qty }}</td>
                        <td>{{ $v->created_at }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="3">Total</td>
                        <td colspan="3">{{ $jumlahQty["quantity"] }}</td>
                    </tr>
            </tbody>
        </table>
        <br>
        <a href="{{ route('report.to_print', $title) }}" id="btnExportPdf" class="btn btn-primary">Export to PDF</a>
    </div>
</div>

@endsection

@push('script')
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $('body').on('click', '#btnExportPdf', function() {
            window.print()
        })
    </script>
@endpush