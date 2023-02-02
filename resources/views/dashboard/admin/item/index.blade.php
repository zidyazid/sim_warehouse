@extends('app')

@section('title')
    <h3 class="panel-title">All Item</h3>
	<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
@endsection
@section('content')

<form>
    <input type="hidden" id="csrf" value="{{Session::token()}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="vendor_id">Pilih Vendor</label>
                <select class="form-control" name="vendor_id" id="vendor_id">
                    @foreach ($dataVendor as $v)
                        <option value="{{ $v->id }}">{{ $v->vendor_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Enter Item Name">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="item_desc">Item Description</label>
        <textarea class="form-control" id="item_desc" name="item_desc" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="item_price">Item Price</label>
        <input type="text" class="form-control" name="item_price" id="item_price" placeholder="Enter Item Price">
    </div>

    <div class="form-group">
        <button type="button" id="btn_submit" class="btn btn-primary btn-sm">Save</button>
    </div>
</form>

    <table class="table table-responsive table-bordererd table-hover" id="table-item">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Vendor</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Desc</th>
                <th>Item Price</th>
                <th>Tindakan</th>
            </tr>
        </thead>
    </table>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" name="id" id="id" value="">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="vendor_id_modal">Pilih Vendor</label>
                            <select class="form-control" name="vendor_id_modal" id="vendor_id_modal">
                                @foreach ($dataVendor as $v)
                                    <option value="{{ $v->id }}">{{ $v->vendor_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="item_name_modal">Item Name</label>
                            <input type="text" class="form-control" name="item_name_modal" id="item_name_modal" placeholder="Enter Item Name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="item_desc_modal">Item Description</label>
                    <textarea class="form-control" id="item_desc_modal" name="item_desc_modal" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="item_price_modal">Item Price</label>
                    <input type="text" class="form-control" name="item_price_modal" id="item_price_modal" placeholder="Enter Item Price">
                </div>
            
                <div class="form-group">
                    <button type="button" id="btn_submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btnSaveChange">Save changes</button>
        </div>
        </div>
    </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.13.1/datatables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>
        $(document).ready(function(){
            // GET DATA
            $('#table-item').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/item/get') }}',
                columns: [
                    {
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    
                        {data: 'vendor_id'},
                        {data: 'item_code'},
                        {data: 'item_name'},
                        {data: 'item_desc'},
                        {data: 'item_price'},
                        {data: 'action'},
                ]
            });

            // SUBMIT DATA
            $('#btn_submit').on('click', function (){

                $.ajax({
                    url: '{{ url('/item/store') }}',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),
                        vendor_id: $('#vendor_id').val(),
                        item_name: $('#item_name').val(),
                        item_desc: $('#item_desc').val(),
                        item_price: $('#item_price').val(),
                    },
                    cache: false,
                    success: function(result){
                        var result = JSON.parse(result);
                        if (result.statusCode == 200) {
                            swal({
                                    title: "Success!",
                                    text: "Data Berhasil Disimpan!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });
                            
                            $('#table-item').DataTable().ajax.reload();
                        }
                    }
                });

            });

            // NOTE: SHOW DATA TO FORM FOR EDIT
            $('body').on('click', '#btnDetail', function() {
                var id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "/get-item/by-id",
                    type: "POST",
                    data:{
                        _token: $('#csrf').val(),
                        id:id
                    }, cache:false, success: function(result) {
                        var result = JSON.parse(result);

                        // SEND DATA TO FORM
                        $("#id_100 select").val(result.vendor_id).change();
                        $('#id').val(result.id);
                        $('#item_name_modal').val(result.item_name);
                        $('#item_desc_modal').val(result.item_desc);
                        $('#item_price_modal').val(result.item_price);
                        console.log(result);
                    }
                });
            });

            // NOTE: MENYIMPAN PERUBAHAN EDIT DATA
            $('#btnSaveChange').on('click', function() {
                var vendor_id = $('#vendor_id_modal').val();
                var item_name = $('#item_name_modal').val();
                var item_desc = $('#item_desc_modal').val();
                var item_price = $('#item_price_modal').val();

                $.ajax({
                    url: "/item/update-proses",
                    type: "POST",
                    data: {

                        _token: $('#csrf').val(),
                        id: $('#id').val(),
                        vendor_id: vendor_id,
                        item_name: item_name,
                        item_desc: item_desc,
                        item_price: item_price,

                    }, cache: false, success: function (result){
                        var result = JSON.parse(result);
                        if (result.statusCode == 200) {
                            swal({
                                    title: "Success!",
                                    text: "Data Berhasil Disimpan!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });

                            $('#table-item').DataTable().ajax.reload()

                            }else{
                            swal({
                                    title: "Failed!",
                                    text: "Data Gagal Disimpan!",
                                    icon: "error",
                                    button: "Aww noo!",
                                });
                        }
                    }
                });
            });
        });
    </script>

@endpush