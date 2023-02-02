@extends('app')

@section('title')
    <h3 class="panel-title">Item In</h3>
	{{-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> --}}
@endsection
@section('content')

<button type="button" class="btn btn-primary" id="btnModalTambah" data-toggle="modal" data-target="#modalTambahItem">
    Tambah Data
</button>


        <p></p>
        {{-- TABLE ITEM IN --}}
        <table id="table-item-in" class="table table-bordered table-hover mt-3 table-responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Vendor Name</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
        </table>

        {{-- MODAL TAMBAH DATA --}}

        <!-- Modal -->
        <div class="modal fade" id="modalTambahItem" tabindex="-1" role="dialog" aria-labelledby="modalTambahItemLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTambahItemLabel">Tambah Data item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="myform">
                        <input type="hidden" id="csrf" value="{{Session::token()}}">
                        <input type="hidden" id="id" value="">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="vendor_id">Pilih Vendor</label>
                                    <select class="form-control" name="vendor_id" id="vendor_id">
                                        <option>-- pilih --</option>
                                        @foreach ($dataVendor as $v)
                                            <option value="{{ $v->id }}">{{ $v->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="item_id">Pilih Item</label>
                                    <select class="form-control" name="item_id" id="item_id">
                                       <option>-- pilih --</option>
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
                                    <label for="total">Total Harga</label>
                                    <input type="text" class="form-control" id="total" name="total" disabled placeholder="Masukan Harga Satuan">
                                </div>
                            </div>  
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="saveItem">Save</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>

@endsection

@push('script')
    {{-- SCRIPT --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.13.1/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {

            // DATATABLE
            $('#table-item-in').DataTable({
                processing: true,
                serverSide:true,
                ajax: '{{ url('/itemin/get-data') }}',
                columns:[
                    {
                        render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;}
                    },
                    { data: 'vendor_name' },
                    { data: 'item_name' },
                    { data: 'qty' },
                    { data: 'total_price' },
                    { data: 'action' },
                ]
            });
            // INSERT DATA [BELUM BERHASIL]
            $('#saveItem').on('click', function(){
                var vendorId = $('#vendor_id').val();
                var itemId = $('#item_id').val();
                var itemQty = $('#qty').val();
                var id = $('#id').val();
                
                if (!id) {
                    console.log('idnya adalh:'+ id);
                    $.ajax({
                            url: '/itemin/store',
                            type: 'POST',
                            data: {
                                    // input name : value
                                    _token: $('#csrf').val(),
                                    vendor_id: vendorId,
                                    item_id: itemId,
                                    qty: itemQty,
                                }, cache: false, success: function (result) {
                                        var result = JSON.parse(result);
                                        if (result.statusCode == 200) {
                                                swal({
                                                            title: "Success!",
                                                            text: "Data Berhasil Disimpan!",
                                                            icon: "success",
                                                            button: "Aww yiss!",
                                                        });
                                                        $('#table-item-in').DataTable().ajax.reload();
                                                }
                                            }
                                        });
                                    } else {
                                        console.log('berikut id:'+id);
                                        
                                        $.ajax({
                                            url: '/get-update-data/proses',
                                            type: 'POST',
                                            data: {
                                                // name of input tag or alias : value
                                                _token: $('#csrf').val(),
                                                id: id,
                                                vendor_id: vendorId,
                                                item_id: itemId,
                                                qty: itemQty,
                                            }, cache: false, success: function (result) {
                                                var result = JSON.parse(result);
                                                if (result.statusCode == 200) {
                                                    swal({
                                                            title: "Success!",
                                                            text: "Data Berhasil Disimpan!",
                                                            icon: "success",
                                                            button: "Aww yiss!",
                                                        });
                                                        $('#table-item-in').DataTable().ajax.reload();
                                                    }else{
                                                    swal({
                                                            title: "Error!",
                                                            text: "Data Gagal Disimpan!",
                                                            icon: "error",
                                                            button: "oh no!",
                                                        });
                                                        $('#table-item-in').DataTable().ajax.reload();

                                                }
                                            }
                                        });
                }

            });
            // DELETE DATA
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var token = $(this).data('token');

                console.log(id);

                $.ajax({
                    url: '/item/destroy/' + id,
                    type: 'DELETE',
                    data: {
                        'id':id,
                        '_method':'DELETE',
                        '_token':token
                    }, success: function (data) {
                        var data = JSON.parse(data);
                        if (data.statusCode == 200) {
                            swal({
                                title: "Success!",
                                text: "Data Berhasil Disimpan!",
                                icon: "success",
                                button: "Aww yiss!",});

                                // TO RELOAD DATA TABLE IN REALTIME
                                $('#table-item-in').DataTable().ajax.reload();
                        }
                    }
                })

            });
            // MENAMPILKAN DATA YANG DIPILIH KE MODAL
            $('body').on('click', '#btnModalEdit', function() {
                var id = $(this).data('id');
                $('#id').val(id);
                $('#modalTambahItemLabel').html("Update Data");

                $.ajax({
                    url: '/get-update-data',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),id: id},
                            cache: false, 
                            success: function(result){
                            var result = JSON.parse(result);
                            
                            $('#vendor_id').val(result.vendor_id).change();
                            $('#item_id').val(result.item_id).change();
                            $('#qty').val(result.qty);
                            $('#total').val(result.total_price);
                            // $('#vendor_id').val(result.vendor_id);
                        }
                });
            });
            // RESET FORM INPUTAN MENJADI KOSONG
            $('body').on('click', '#btnModalTambah',function(){
                $('#modalTambahItemLabel').html("Tambah Data");
                $('#vendor_id').prop('selected', false); // first way to unselect
                $('#item_id').removeAttr('selected'); // second way to unselect
                $('#qty').empty();
                $('#id').empty();
            });
            // AUTO COUNT TOTAL
            $('#qty').on('change', function(){
                var vendorID = $('#vendor_id').val()
                var itemID = $('#item_id').val()

                $.ajax({
                    url: '/item/vendor_id/item_id/'+vendorID+'/'+itemID,
                    type: 'GET',
                    cache: false, success: function(result){
                        var result = JSON.parse(result);
                        var totalHarga = result.item_price * $('#qty').val();
                        $('#total').val(totalHarga);
                        

                    }
                });
            });
            // AUTO CHANGE VALUE OPTION OF ITEM
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
                        // console.log(result.length);
                        $('#myform #item_id').empty();
                        for (var i=0; i<result.length; i++) {
                            // console.log(result[i].id);
                            $('#myform #item_id').append('<option value="' + result[i].id + '">' + result[i].item_name + '</option>')
                        }
                    }
                });

            });


        });

    </script>

@endpush