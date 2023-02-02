@extends('app')

@section('title')
    <h3 class="panel-title">Sales / Barang Keluar</h3>
	{{-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> --}}
@endsection

@section('content')

    <form action="" id="myform">
        <input type="hidden" name="csrf" id="csrf" value="{{ Session::token() }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="vendor_id">Nama Vendor</label>
                    <select class="form-control" id="vendor_id" name="vendor_id">
                        <option>-- Pilih Data --</option> 
                        @foreach ($dataVendor as $v)
                        <option value="{{ $v->id }}">{{ $v->vendor_name }}</option> 
                        @endforeach
                    </select>
                </div>    
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="item_id">Nama Item</label>
                    <select class="form-control myselect" id="item_id" name="item_id">
                        <option>-- Pilih Data --</option> 
                        {{-- @foreach ($dataItem as $v)
                            <option value="{{ $v->id }}">{{ $v->item_name }}</option> 
                            @endforeach --}}
                    </select>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="qty">Masukan Jumlah</label>
                    <input type="text" class="form-control" id="qty" name="qty" placeholder="Masukan Jumlah">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="total_price">Total Harga</label>
                    <input type="text" disabled class="form-control" id="total_price" name="total_price" placeholder="Rp.0">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="btnSave" class="btn btn-sm btn-primary">Simpan</button>
        </div>
    </form>    

    <p></p>

    <table class="table table-bordered table-hover" id="table-item-out">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Vendor</th>
                <th>Nama Item</th>
                <th>Jumlah Item</th>
                <th>Total Harga</th>
            </tr>
        </thead>
    </table>

@endsection

@push('script')
    {{-- SCRIPT --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.13.1/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var qty = document.getElementById('qty').value;
        console.log(qty);

        $(document).ready(function(){
            // GET ALL DATA
            $('#table-item-out').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/out-item/get-data') }}',
                columns: [
                    {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;}},
                    { data: 'vendor_name' },
                    { data: 'item_name' },
                    { data: 'qty' },
                    { data: 'total_price' }
                ]
            });

            // AUTOFILL AFTER CHOOSE SELECT OPTION
            $('body').on('change', '#vendor_id', function(){
                var vendorID = $(this).val();
                var oldResultValue = null;

                $.ajax({
                    url: '/vendor/data',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),
                        vendor_id: vendorID,
                    }, cache: false, success: function(result) {
                        var result = JSON.parse(result);
                        console.log(result.length);
                        $('#myform .myselect').empty();
                        for (var i=0; i<result.length; i++) {
                            console.log(result[i].id);
                            $('#myform .myselect').append('<option value="' + result[i].id + '">' + result[i].item_name + '</option>')
                        }
                    }
                });

            });

            // AUTOFILL TOTAL HARGA
            $('body').on('change', '#qty', function(){
                let totalPrice = parseInt($(this).val());
                var vendorId = $('#vendor_id').val();
                var itemId = $('#item_id').val();

                console.log('vendor id: ' + vendorId + ' item id: ' + itemId);

                $.ajax({
                    url: '/vendor/data/by-vendor-and-item',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),
                        vendor_id: vendorId,
                        item_id: itemId
                    }, cache: false, success: function(result){
                        var result = JSON.parse(result);
                        totalPrice = totalPrice * result.item_price;

                        $('#total_price').val(totalPrice);
                        console.log(totalPrice);
                        
                    }
                });
            });

            // SAVE DATA ITEMS OUT
            $('#btnSave').on('click', function(){
                var vendorId = $('#vendor_id').val();
                var itemId = $('#item_id').val();
                var qty = $('#qty').val();
                var totalPrice = $('#total_price').val();

                $.ajax({
                    url: '/out-item/save',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),
                        vendor_id: vendorId,
                        item_id: itemId,
                        qty: qty,
                        total_price: totalPrice
                    },cache: false, success: function(result){
                        var result = JSON.parse(result);
                        if (result.statusCode == 200) {
                            swal({
                                title: "Success!",
                                text: "Data Berhasil Disimpan!",
                                icon: "success",
                                button: "Aww yiss!",
                            });
                            $('#table-item-out').DataTable().ajax.reload();
                        }else{
                            swal({
                                title: "Failed!",
                                text: "Data Gagal Disimpan!" + result.message,
                                icon: "error",
                                button: "Aww noo!",
                            });
                            $('#table-item-out').DataTable().ajax.reload();

                        }
                    }
                });

            });
        });
    </script>

@endpush

