@extends('app')

@section('title')
    <h3 class="panel-title">Vendor</h3>
	<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
@endsection
@section('content')
    
<button type="button" class="btn btn-primary mb-3" id="btnModalTambah" data-toggle="modal" data-target="#modalTambah">
        Tambah Data
</button>

<p></p>

<table class="table table-responsive table-bordered table-hover" id="table_vendor">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Vendor</th>
            <th>Alamat Vendor</th>
            <th>Kontak Vendor</th>
            <th>Tindakan</th>
        </tr>
    </thead>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" id="csrf" value="{{Session::token()}}">
                <input type="hidden" id="id" value="">
                <div class="form-group">
                    <label for="vendor_name">Nama Vendor</label>
                    <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Vendor">
                </div>
                <div class="form-group">
                    <label for="vendor_contact">Kontak Vendor</label>
                    <input type="text" class="form-control" name="vendor_contact" id="vendor_contact" placeholder="Vendor">
                </div>
                <div class="form-group">
                    <label for="vendor_address">Alamat Vendor</label>
                    <textarea class="form-control" name="vendor_address" id="vendor_address" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

{{-- Modal Delete --}}
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalDeleteTitle">Konfirmasi Permintaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="text" name="csrf1" id="csrf1" value="{{ Session::token() }}">
                <input type="text" name="vendor_id" id="vendor_id">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="button" id="btnDelete" class="btn btn-primary">Save changes</button> --}}
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

            // TAMPIL DATA DI DATATABLE
            $('#table_vendor').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/vendor/query/tampil') }}',
                columns: [
                    {
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { data: 'vendor_name' },
                    { data: 'vendor_address' },
                    { data: 'vendor_contact' },
                    { data: 'action' }
                ]
            });

            // TAMBAH DATA BARU
            $('body').on('click', '#btnModalTambah', function() {
                console.log("success");
                // Lakukan perubahan pada modal tambah melalui jquery menggunakan script dibawah ini
                $('#exampleModalLongTitle').html('Tambah Data Mahasiswa');
                $('#vendor_name').val("");
                $('#vendor_contact').val("");
                $('#vendor_address').val("");
                $('#id').val("");
            })

            // OPERASI INSERT DAN UPDATE
            $('#btnSubmit').on('click', function(){
                var namaVendor = $('#vendor_name').val();
                var alamatVendor = $('#vendor_address').val();
                var kontakVendor = $('#vendor_contact').val();
                var id = $('#id').val();

                console.log($('#csrf').val());
                
                console.log(id);

                if (id === null || id === "") {
                    // TAMBAH DATA
                    console.log(namaVendor);
                    console.log(alamatVendor);
                    console.log(kontakVendor);
                    if (namaVendor === null) {
                        namaVendor = "-";
        
                        $.ajax({
                            url: '/submit/new-vendor',
                            type: 'POST',
                            data: {
                                // name of input tag or alias : value
                                _token: $('#csrf').val(),
                                vendor_name: namaVendor,
                                vendor_address:alamatVendor,
                                vendor_contact:kontakVendor,
                            },
                            cache: false,
                            success: function (result) {
                                var result = JSON.parse(result);
                                    swal({
                                        title: "Success!",
                                        text: "Data Berhasil Disimpan!",
                                        icon: "success",
                                        button: "Aww yiss!",
                                    });
        
                                    // TO RELOAD DATA TABLE IN REALTIME
                                    $('#table_vendor').DataTable().ajax.reload();
                                
                            }
                        });
    
                    }else{
                        $.ajax({
                            url: '/submit/new-vendor',
                            type: 'POST',
                            data: {
                                // name of input tag or alias : value
                                _token: $('#csrf').val(),
                                vendor_name: namaVendor,
                                vendor_address:alamatVendor,
                                vendor_contact:kontakVendor,
                            },
                            cache: false,
                            success: function (result) {
                                var result = JSON.parse(result);
                                    swal({
                                        title: "Success!",
                                        text: "Data Berhasil Disimpan!",
                                        icon: "success",
                                        button: "Aww yiss!",
                                    });
        
                                    // TO RELOAD DATA TABLE IN REALTIME
                                    $('#table_vendor').DataTable().ajax.reload();
                                
                            }
                        });
                    }
                } else {
                    console.log(namaVendor);
                    console.log(alamatVendor);
                    console.log(kontakVendor);
                    // UPDATE DATA
                    $.ajax({
                        url: '/vendor/update-vendor',
                        type: 'POST',
                        data: {
                            _token: $('#csrf').val(),
                            id: id,
                            vendor_name: namaVendor,
                            vendor_address:alamatVendor,
                            vendor_contact:kontakVendor,
                        }, success: function (result) {
                            var result = JSON.parse(result);
                            if (result.statusCode == 200) {
                                swal({
                                        title: "Success!",
                                        text: "Data Berhasil Disimpan!",
                                        icon: "success",
                                        button: "Aww yiss!",
                                });
                            }

                            // TO RELOAD DATA TABLE IN REALTIME
                            $('#table_vendor').DataTable().ajax.reload();
                        }
                    });
                }
            });

            // TAMPILKAN DATA YANG DIPILIH KEDALAM FORM YANG ADA PADA MODAL
            $('body').on('click', '#btnModalUpdate', function() {
                var id = $(this).data('id');
                console.log(id);
                // Lakukan perubahan pada modal tambah melalui jquery menggunakan script dibawah ini
                $('#exampleModalLongTitle').html('Ubah Data Mahasiswa');

                $.ajax({
                    url: '/vendor/update',
                    type: 'POST',
                    data: {
                        _token: $('#csrf').val(),
                        id: id}, 
                        success: function (result) {
                        var result = JSON.parse(result);
                        console.log(result.vendor_name);
                        $('#vendor_name').val(result.vendor_name);
                        $('#vendor_contact').val(result.vendor_contact);
                        $('#vendor_address').val(result.vendor_address);
                        $('#id').val(id);
                    
                    }
                });

            });

            // BUTTON DELETE
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var token = $(this).data('token');
                
                $.ajax({
                    url: "/vendor/destroy/" + id,
                    type: "DELETE",
                    data: {
                        "id": id,
                        "_method": "DELETE",
                        "_token": token,
                    }, success: function (data) {
                        var data = JSON.parse(data);
                        if (data.statusCode == 200) {
                            swal({
                                title: "Success!",
                                text: "Data Berhasil Disimpan!",
                                icon: "success",
                                button: "Aww yiss!",});

                                // TO RELOAD DATA TABLE IN REALTIME
                                $('#table_vendor').DataTable().ajax.reload();
                        }
                    }
                });
            });

        });
    </script>
@endpush


