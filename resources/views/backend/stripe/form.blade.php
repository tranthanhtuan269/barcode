@extends('backend.master')

@section('content')
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/location/create'))
                Thêm trang
                <?php 
                    $url = url('admincp/payment-logs/');
                    $method = 'POST';
                ?>
            @else
                Sửa dicount
                <?php 
                    $url = url('admincp/payment-logs/' . Request::route('payment-logs'));
                    $method = 'PUT';
                ?>
            @endif

        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Tên</label>
                            <input type="text" class="form-control"  name="name" value="{{ isset($data->name) ? $data->name : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="text" class="form-control"  name="name" value="{{ isset($data->email) ? $data->email : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Billing email</label>
                            <input type="text" class="form-control"  name="name" value="{{ isset($data->billing_email) ? $data->billing_email : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Dicount</label>
                            <input type="text" class="form-control" id="discountRequest" name="name" value="{{ isset($data->discount) ? $data->discount : '' }}">
                            <p class="alert-discount alert-errors"></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="save-change" data-action="@if(\Request::is('admincp/payment-logs/create'))create @endif">
                            @if(\Request::is('admincp/payment-logs/create')) Thêm mới @else Cập nhật @endif

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>

        document.getElementById('discountRequest').onkeydown = function(e) {
            if(isNaN(e.key) && e.keyCode != 8){
				return false;
			}
        }
        
        $('#save-change').click(function(){

            var discountRequest = $('#discountRequest').val(); 
            if(/^[a-zA-Z0-9- ]*$/.test(discountRequest) == false) {
                $('.alert-discount').text('Not contain special characters.');
                return false;
            }

            if(discountRequest > 100){
                $('.alert-discount').text('Discount must be less than 100.');
                return false;
            }

            url = baseURL + '/admincp/payment-logs/' + {!! $data->id !!};
            // var method = "POST";

            // if ($(this).attr('data-action') != 'create ') {
            //     url += '/{{ Request::route("payment-logs/") }}';
                method = "PUT";
            // }
            var data    = {
                _method             : method,
                discountRequest     : discountRequest,
            };

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $('.alert-errors').html('');
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(response) {
                    if(response.status == 200){
                        $().toastmessage('showSuccessToast', response.message);
                        setTimeout(function(){ window.location.href = baseURL + "/admincp/payment-logs"; }, 1000);
                    }else{
                        alert('error');
                    }
                },
                error: function (response) {
                    $().toastmessage('showErrorToast', "Có lỗi xảy ra với dữ liệu. Vui lòng xem lại.");
                    if(response.status == 422){
                        var tmp = 0;
                        $.each(response.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
                        if (tmp == 0) {
                            $('.alert-' + index).attr("tabindex",-1).focus();
                        }
                        tmp++;
                        });
                    }
                }
            });
        });
    </script>

@endsection