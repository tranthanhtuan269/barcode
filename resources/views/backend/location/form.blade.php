@extends('backend.master')

@section('content')
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/location/create'))
                Thêm trang
                <?php 
                    $url = url('admincp/location/');
                    $method = 'POST';
                ?>
            @else
                Sửa trang
                <?php 
                    $url = url('admincp/location/' . Request::route('location'));
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
                            <input type="text" class="form-control"  name="name" value="{{ isset($data->name) ? $data->name : '' }}">
                            <p class="alert-name alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề</label>
                            <input type="text" class="form-control"  name="intro" value="{{ isset($data->intro) ? $data->intro : '' }}">
                            <p class="alert-intro alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nội dung</label>
                            <textarea rows="4" onkeydown="expandtext(this);" name="content">{{ isset($data->content) ? $data->content : '' }}</textarea>

                            <p class="alert-content alert-errors"></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="save-change" data-action="@if(\Request::is('admincp/location/create'))create @endif">
                            @if(\Request::is('admincp/location/create')) Thêm mới @else Cập nhật @endif

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        CKEDITOR.replace( 'content', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );
        
        $('#save-change').click(function(){
            url = baseURL + '/admincp/location';
            var method = "POST";

            if ($(this).attr('data-action') != 'create ') {
                url += '/{{ Request::route("location") }}';
                method = "PUT";
            }

            var data    = {
                _method           : method,
                name : $('input[name=name]').val(),
                intro : $('input[name=intro]').val(),
                content : CKEDITOR.instances['content'].getData(),
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
                        setTimeout(function(){ window.location.href = baseURL + "/admincp/location"; }, 1000);
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