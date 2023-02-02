@extends('app')

@section('title')
    <h3 class="panel-title">Stock</h3>
	<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
@endsection
@section('content')
    
    <table class="table table-bordered table-hover" id="table-stock">
        <thead>
            <th>No</th>
            <th>Vendor Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
        </thead>
    </table>

@endsection

@push('script')
    
    {{-- SCRIPT --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.13.1/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            // TAMPIL DATA
            $('#table-stock').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/stock/get_data') }}',
                columns: [
                    {
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                    },
                    { data: 'vendor_name' },
                    { data: 'item_name' },
                    { data: 'total_stock' },
                ]
            });
        });
    </script>

@endpush