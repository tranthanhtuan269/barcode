@extends('backend.master')
@section('title', 'Sửa Danh mục')
@section('content')
    <script src="https://cdn.tiny.cloud/1/w5564ujp5we1y3jlgdiwnskpks9dzatf2hrlr4fd2sgo197n/tinymce/5/tinymce.min.js"></script>
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/articlecategories/create'))
                Thêm danh mục bài viết
                <?php 
                    $url = url('admincp/articlecategories/');
                    $method = 'POST';
                ?>
            @else
                Sửa danh mục bài viết
                <?php 
                    $url = url('admincp/articlecategories/' . $data->id);
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
                        <div class="form-group row">
                            <div class="form-group clearfix col-md-6">
                                <label class="font-weight-bold">Tên danh mục</label>
                                <input type="text" class="form-control" maxlength="80" name="title" value="{{ isset($data->title) ? $data->title : '' }}">
                                <p class="alert-title alert-errors"></p>
                            </div>
                            <div class="form-group clearfix col-md-6">
                                <label class="font-weight-bold">Slug</label>
                                <input type="text" class="form-control" maxlength="65" placeholder="Tối đa 65 ký tự" name="slug" value="{{ isset($data->slug) ? $data->slug : '' }}">
                                <p class="alert-slug alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix" style="height: 362px">
                            <label class="font-weight-bold">Mô tả</label>
                            <textarea class="form-control" name="description" id="description">{{ isset($data->description) ? $data->description : '' }}</textarea>
                            <p class="alert-description alert-errors"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (isset($data))
                        @include('backend.seo.general', ['social'=>'social', 'data_seo'=>$data])
                        @else
                        @include('backend.seo.general', ['social'=>'social'])
                        @endif
                        <br>
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
                            <h4><span>Languages</span></h4>
                        </div>
                        <div class="widget-body clearfix">
                            <div id="select-post-language">
                                <table class="select-language-table">
                                    <tbody>
                                        <tr>
                                            <td class="active-language" style="width:2%">
                                                @if (Request::get('language') == 'en' || Request::is('admincp/articlecategories/create'))
                                                    <img src="{{ asset('backend/images/en.png') }}" title="English">
                                                @else
                                                    <img src="{{ asset('backend/images/vi.png') }}" title="Tiếng Việt">
                                                @endif
                                            </td>
                                            <td class="translation-column" style="width:20%">
                                                <select name="language" class="ui-select">
                                                    @if (Request::get('language') == 'en' || Request::is('admincp/articlecategories/create'))
                                                        <option value="en" selected="selected">English</option>
                                                    @else
                                                        <option value="vi" selected="selected">Tiếng Việt</option>
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                            <iframe width="100%" height="450px" src="{{asset('filemanager/dialog.php')}}?type=22&field_id=filemanager-image&fldr=imgs" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
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
                                @if ($categories)
                                    {!! $categories !!}
                                @endif
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
        <div class="tmp_content hidden"></div>
    </section>
    <script>
        var data_seo; // Dung de lay data seo
        CKEDITOR.replace( 'description', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        $( "input[name=title]" ).keyup(function() {
            let slug_value = titleToSlug($( "input[name=title]" ).val());
            $( "input[name=slug]" ).val(slug_value)
        });
        $("input[name=slug]").on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
        });
        $('#save-change').click(function(){
            $('input[name=submit_data_seo]').click(); // Dung de lay du lieu cho bien "data_seo"
            let slug = $('input[name=slug]').val().trim();
            let seo_title = data_seo.seo_title;

            if (slug == ''){
                slug = titleToSlug($( "input[name=title]" ).val());
            }
            if (seo_title == ''){
                seo_title = $('input[name=title]').val().trim();
            }

            let data    = {
                _method     : "{{ $method }}",
                id          : "{{ Request::route('articlecategory') }}",
                language : $('select[name=language]').val(),
                title       : $('input[name=title]').val().trim(),
                slug        : slug,
                description : CKEDITOR.instances.description.getData(),
                image       : $('#filemanager-image').attr('src'),
                parent_id   : $('select[name=parent_id]').val().trim(),
                // keywords    : $('input[name=keywords]').val().trim(),
                seo_title   : seo_title,
                seo_description : data_seo.seo_description,
               keywords   : $('input[name=keywords]').val().trim(),
                seo_indexed     : data_seo.seo_indexed,
                // og_type         : data_seo.og_type,
                // og_title        : data_seo.og_title,
                // og_description  : data_seo.og_description,
                // og_image        : data_seo.og_image,
                // og_image_alt    : data_seo.og_image_alt,
                // twitter_title   : data_seo.twitter_title,
                // twitter_description   : data_seo.twitter_description,
                // twitter_image   : data_seo.twitter_image,
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
                                window.location.replace("{{ url('admincp/articlecategories') }}");
                            }
                        });
                    } else {
                        $().toastmessage('showErrorToast', "Có lỗi xảy ra với dữ liệu. Vui lòng xem lại.");
                        $.each( response.message, function( index, value) {
                            $('.alert-' + index).html(value);
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