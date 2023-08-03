@extends('backend.master')

@section('content')

    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if (Request::is('admincp/services/create'))
                Thêm mới
            @else
                Sửa
            @endif
            
            dịch vụ
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <script src="{{ url('/') }}/templateEditor/ckeditor/ckeditor.js"></script>
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active font-weight-600" aria-current="service">THÔNG TIN</li>
                            </ol>
                        </nav>
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề</label>
                            <input type="text" class="form-control"  name="title" value="{{ isset($data->title) ? $data->title : '' }}">
                            <p class="alert-title alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nội dung</label>
                            <textarea rows="4" onkeydown="expandtext(this);" name="content">{{ isset($data->content) ? $data->content : '' }}</textarea>

                            <p class="alert-content alert-errors"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active font-weight-600" aria-current="service">SEO</li>
                            </ol>
                        </nav>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Từ khóa</label>
                                <input type="text" class="form-control" name="keywords" value="{{ isset($data->keywords) ? $data->keywords : '' }}">
                                <p class="alert-keywords alert-errors"></p>
                                <small id="fileHelp" class="form-text text-muted">Phân cách các từ khóa bằng dấu phẩy. Vd: áo nam, áo nữ...</small>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tiêu đề</label>
                                <input type="text" class="form-control" name="seo_title" value="{{ isset($data->seo_title) ? $data->seo_title : '' }}">
                                <p class="alert-seo_title alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Mô tả</label>
                            <textarea class="form-control"  name="seo_description">{{ isset($data->seo_description) ? $data->seo_description : '' }}</textarea>
                            <p class="alert-seo_description alert-errors"></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="save-change" data-action="@if(\Request::is('admincp/services/create'))create @endif">
                              @if(\Request::is('admincp/services/create')) Thêm mới @else Cập nhật @endif

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
      CKEDITOR.replace( 'content', {
          'filebrowserBrowseUrl' : '{{ url("/") }}/templateEditor/kcfinder/browse.php?opener=ckeditor&type=files',
          'filebrowserImageBrowseUrl' : '{{ url("/") }}/templateEditor/kcfinder/browse.php?opener=ckeditor&type=images',
          'filebrowserFlashBrowseUrl' : '{{ url("/") }}/templateEditor/kcfinder/browse.php?opener=ckeditor&type=flash',
          'filebrowserUploadUrl' : '{{ url("/") }}/templateEditor/kcfinder/upload.php?opener=ckeditor&type=files',
          'filebrowserImageUploadUrl' : '{{ url("/") }}/templateEditor/kcfinder/upload.php?opener=ckeditor&type=images',
          'filebrowserFlashUploadUrl' : '{{ url("/") }}/templateEditor/kcfinder/upload.php?opener=ckeditor&type=flash',
          'height': '300px',
      } );
      $('#save-change').click(function(){
        url = baseURL + '/admincp/services';
        var method = "POST";

        if ($(this).attr('data-action') != 'create ') {
            url += '/{{ Request::route("service") }}';
            method = "PUT";
        }

        var data    = {
            _method           : method,
             title : $('input[name=title]').val(),
             content : CKEDITOR.instances['content'].getData(),
             keywords : $('input[name=keywords]').val(),
             seo_title : $('input[name=seo_title]').val(),
             seo_description : $('textarea[name=seo_description]').val(),
        };

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $('.alert-error').html('');
            },
            complete: function(data) {
                if(data.responseJSON.status == 200){
                    $().toastmessage('showSuccessToast', data.responseJSON.Message);
                    setTimeout(function(){ window.location.href = baseURL + "/admincp/services"; }, 1000);
                }else{
                    if(data.status == 422){
                        $().toastmessage('showErrorToast', 'Errors');
                        var tmp = 0;
                        $.each(data.responseJSON.errors, function( index, value ) {
                          $('.alert-' + index).html(value);
                          if (tmp == 0) {
                            $('.alert-' + index).attr("tabindex",-1).focus();
                          }
                          tmp++;
                        });
                    }else{
                        if(data.status == 401){
                          window.location.replace(baseURL);
                        }else{
                         $().toastmessage('showErrorToast', errorConnect);
                        }
                    }
                }
            }
        });
      });
    </script>

@endsection