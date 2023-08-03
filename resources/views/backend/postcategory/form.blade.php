@extends('backend.master')
@section('content')
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/postcategories/create'))
                Thêm danh mục bài viết
                <?php 
                    $url = url('admincp/postcategories/');
                    $method = 'POST';
                ?>
            @else
                Sửa danh mục bài viết
                <?php 
                    $url = url('admincp/postcategories/' . Request::route('postcategory'));
                    $method = 'PUT';
                ?>
            @endif

        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active font-weight-600" aria-current="page">THÔNG TIN DANH MỤC</li>
                            </ol>
                        </nav>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Tên danh mục</label>
                            <input type="text" class="form-control"  name="title" value="{{ isset($data->title) ? $data->title : '' }}">
                            <p class="alert-title alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Mô tả ngắn</label>
                            <textarea class="form-control" name="description">{{ isset($data->description) ? $data->description : '' }}</textarea>
                            <p class="alert-description alert-errors"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active font-weight-600" aria-current="page">SEO</li>
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
                            <button type="submit" class="btn btn-primary" id="save-change">Lưu lại</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="meta-box-sortables">
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Ảnh đại diện</span></h4>
                        </div>
                        <div class="widget-body clearfix text-center">
                            @if(!empty($data->image))
                                <img id="filemanager-image" src="{{ asset('filemanager/data-images/'.$data->image) }}">
                            @else 
                                <img id="filemanager-image" src="">
                            @endif
                            <p class="alert-image alert-errors"></p>
                            <button type="button" class="btn btn-xs btn-primary text-center" data-toggle="modal" href="javascript:;" data-target="#myModalFilemanager">Chọn ảnh</button>
                            <script>
                                function responsive_filemanager_callback(field_id){
                                    var url=jQuery('#'+field_id).val();
                                    $('#filemanager-image').attr('src', url);
                                }
                            </script>
                            <div class="modal fade" id="myModalFilemanager">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Thư viện media</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe width="100%" height="450px" src="{{asset('filemanager/dialog.php')}}?type=22&field_id=filemanager-image" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Chuyên mục cha</span></h4>
                        </div>
                        <div class="widget-body clearfix text-center">
                            <select name="parent_id" class="form-control select2 wrap">
                                <option value="0">--</option>
                                {!! $categories !!}
                            </select>
                            <script>
                                var $select2 = $('.select2').select2({
                                    containerCssClass: "wrap"
                                })
                            </script>
                            <p class="alert-parent_id alert-errors"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('#save-change').click(function(){
            var data    = {
                _method           : "{{ $method }}",
                id           : "{{ Request::route('postcategory') }}",
                title : $('input[name=title]').val().trim(),
                description : $('textarea[name=description]').val().trim(),
                image           : $('#filemanager-image').attr('src'),
                parent_id : $('select[name=parent_id]').val().trim(),
                keywords : $('input[name=keywords]').val().trim(),
                seo_title : $('input[name=seo_title]').val().trim(),
                seo_description : $('textarea[name=seo_description]').val().trim(),
            };

            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
                type: "POST",
                url: "{{ $url }}",
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
                        Swal.fire({
                            type: 'success',
                            html: response.message,

                        }).then((result) => {
                            if (result.value) {
                                window.location.replace("{{ url('admincp/postcategories') }}");
                            }
                        });
                    }
                },
                error: function (data) {
                    $().toastmessage('showErrorToast', "Có lỗi xảy ra với dữ liệu. Vui lòng xem lại.");
                    var tmp = 0;

                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
                        if (tmp == 0) {
                            $('.alert-' + index).attr("tabindex",-1).focus();
                        }
                        tmp++;
                    });
                }
            });
        });
    </script>

@endsection