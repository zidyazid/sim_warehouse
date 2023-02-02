@extends('app')

@section('title')
    <h3 class="panel-title">Detail Vendor</h3>
	<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
@endsection
@section('content')
    
<div class="panel">
    <form>
        <input type="hidden" id="csrf" value="{{Session::token()}}">
        <input type="hidden" name="vendor_id" id="vendor_id" value="{{ $detailVendor->id }}">
        <div class="form-group">
            <label for="vendor_name">Nama Vendor</label>
            <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $detailVendor->vendor_name }}">
        </div>
        <div class="form-group">
            <label for="vendor_contact">Kontak Vendor</label>
            <input type="text" class="form-control" name="vendor_contact" id="vendor_contact" value="{{ $detailVendor->vendor_contact }}">
        </div>
        <div class="form-group">
            <label for="vendor_address">Alamat Vendor</label>
            <textarea class="form-control" name="vendor_address" id="vendor_address" rows="3">{{ $detailVendor->vendor_address }}</textarea>
        </div>
        <div class="modal-footer">
            <button type="button" id="btnSubmit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

@endsection

@push('script')

    {{-- SCRIPT --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.13.1/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){

            // UBAH DATA
            $('#btnSubmit').on('click', function(){
                var id = $('#vendor_id').val();
                var vendorName = $('#vendor_name').val();
                var vendorContact = $('#vendor_contact').val();
                var vendorAddress = $('#vendor_address').val();

                $.ajax({
                    url: "/vendor/update/"+id,
                    type: "POST",
                    data: {
                        _token : $('#csrf').val(),
                        vendor_name: vendorName,
                        vendor_contact: vendorContact,
                        vendor_address: vendorAddress
                    },
                    cache: false,
                    success: function (dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            console.log(dataResult.statusCode);
                            swal({
                                title: "Success!",
                                text: "Data Berhasil Dirubah!",
                                icon: "success",
                                button: "Aww yiss!",
                            });

                            window.location.href('/dashboard/admin/vendor');
                        }else if(dataResult.statusCode==201){
                            alert("Error occured !");
                        }
                    }
                });
            })

        });
    </script>

@endpush