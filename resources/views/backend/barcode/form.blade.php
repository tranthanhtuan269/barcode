@extends('backend.master')
@section('title', 'Quản lý bài viết')
@section('content')
    <link rel="stylesheet" href="{{ asset('backend/dist/css/bootstrap-multiselect.min.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('backend/dist/js/bootstrap-multiselect.min.js') }}"></script>
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/barcodes/create'))
                Thêm bài viết
                <?php 
                    $url = url('admincp/barcodes/');
                    $method = 'POST';
                ?>
            @else
                Sửa bài viết
                <?php 
                    $url = url('admincp/barcodes/' . $data->id);
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
                                <li class="breadcrumb-item active font-weight-600" aria-current="page">THÔNG TIN BARCODE</li>
                            </ol>
                        </nav>
                        <div class="form-group clearfix row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tên sản phẩm</label>
                                <input type="text" class="form-control"  name="name" value="{{ isset($data->name) ? $data->name : '' }}">
                                <p class="alert-name alert-errors"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Barcode</label>
                                <input type="text" class="form-control" name="barcode" value="{{ isset($data->barcode) ? $data->barcode : '' }}">
                                <p class="alert-barcode alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Model</label>
                                <input type="text" class="form-control"  name="model" value="{{ isset($data->model) ? $data->model : '' }}">
                                <p class="alert-model alert-errors"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Manufacturer</label>
                                <input type="text" class="form-control" name="manufacturer" value="{{ isset($data->manufacturer) ? $data->manufacturer : '' }}">
                                <p class="alert-manufacturer alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Avg Price</label>
                                <input type="text" class="form-control"  name="avg_price" value="{{ isset($data->avg_price) ? $data->avg_price : '' }}">
                                <p class="alert-avg_price alert-errors"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Currency Unit</label>
                                <input type="text" class="form-control" name="currency_unit" value="{{ isset($data->currency_unit) ? $data->currency_unit : '' }}">
                                <p class="alert-currency_unit alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix row">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Tiêu đề nội dung</label>
                                <input type="text" class="form-control" name="title_content" value="{{ isset($data->title_content) ? $data->title_content : '' }}">
                                <p class="alert-title_content alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Nội dung</label>
                            <textarea class="form-control" id="content" name="content" rows="5">{{ isset($data->content) ? $data->content : '' }}</textarea>
                            <p class="alert-content alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Hỏi đáp</label>
                            <textarea class="form-control" id="list_ask" name="list_ask" rows="10" autocorrect="off" spellcheck="false">{{ isset($data->list_ask) ?  htmlentities($data->list_ask) : '' }}</textarea>
                            <p class="alert-list_ask alert-errors"></p>
                        </div>
                       <div class="form-group clearfix">
                            <label class="font-weight-bold">Specification</label>
                            <textarea class="form-control" id="spec" name="spec" rows="5">{{ isset($data->spec) ? $data->spec : '' }}</textarea>
                            <p class="alert-spec alert-errors"></p>
                        </div>
                        <div class="form-group" >
                            <label class="font-weight-bold">Descriptions</label>
                            <textarea class="form-control" id="description" name="description">{{ isset($data->description) ? $data->description : '' }}</textarea>
                            <p class="alert-description alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Feature</label>
                            <textarea class="form-control" id="feature" name="feature" rows="5">{{ isset($data->feature) ? $data->feature : '' }}</textarea>
                            <p class="alert-feature alert-errors"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (isset($data))
                        @include('backend.seo.general', ['social'=>'social', 'schema'=>'schema', 'data_seo'=>$data])
                        @else
                        @include('backend.seo.general', ['social'=>'social', 'schema'=>'schema'])
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
                                                @if (Request::get('language') == 'en' || Request::is('admincp/barcodes/create'))
                                                    <img src="{{ asset('backend/images/en.png') }}" title="English">
                                                @else
                                                    <img src="{{ asset('backend/images/vi.png') }}" title="Tiếng Việt">
                                                @endif
                                            </td>
                                            <td class="translation-column" style="width:20%">
                                                <select name="language" class="ui-select">
                                                    @if (Request::get('language') == 'en' || Request::is('admincp/barcodes/create'))
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
                            <output id="Filelist" data-file="{{ $data->image }}">
                                <ul class="thumb-Images" id="imgList" style="list-style:none">
                                    @if(!empty($data->image))
                                    <li>
                                        <div class="img-wrap">
                                            <img width="200" src="{{ asset('uploads/barcode/'.$data->image) }}"class="thumb" id="thumbnail">
                                        </div>
                                    </li>
                                    @else 
                                    <li>
                                        <div class="img-wrap">
                                            <img src=""class="thumb" id="thumbnail">
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </output>
                            <span class="btn btn-success fileinput-button">
                                <span>Upload product image</span>
                                <input type="file" name="files[]" id="avatar" multiple accept="image/*"><br />
                            </span>
                        </div>
                    </div>
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Bài viết liên quan</span></h4>
                        </div>
                        <div class="widget-body clearfix text-left">
                                @php
                                    if(isset($data->related_articles)){
                                        $related_articles = json_decode($data->related_articles, TRUE);
                                    }
                                @endphp
                                <select class="js-example-basic-multiple w-100" id="related" name="related_articles" multiple="multiple">
                                    @if(isset($related_articles) && isset($data))
                                        @foreach($cache_all_article as $value)
                                            @if(in_array($value->id, $related_articles))
                                                <option value="{{ $value->id }}" selected>{{ $value->title }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->title }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($cache_all_article as  $value)
                                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="tmp_content hidden"></div>
    </section>

    <style type="text/css">
        .multiselect-container .multiselect-option.dropdown-item,
        .multiselect {
            background: #fff!important;
            border:1px solid #d1d1d1!important ;
        }
        .multiselect-container .multiselect-option:hover ,
        .multiselect-container .multiselect-option.active:not(.multiselect-active-item-fallback){
            background: #d1d1d1!important;
        }
        .multiselect-container .multiselect-option .form-check {
            display: flex;
            padding: 0;
        }
        .multiselect-container .multiselect-option .form-check-label {
            text-align: left;
            margin-left: 10px;
        }

        .fas {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            width: 10%;
            line-height: 33px;
        }
        .multiselect-container .multiselect-filter > input.multiselect-search {
            border: none;
            border-bottom: 1px solid lightgrey;
            padding-left: 10px;
            margin-left: 0!important;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .multiselect-container .multiselect-container {
            width: 100%;
        }

        .multiselect-filter{
            display: flex;
        }
    </style>

    <script>

        $(document).ready(function() {
            $('#related').multiselect({
                buttonWidth:'100%',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
            })
        });
        
        var data_seo; // Dung de lay data SEO

        CKEDITOR.replace( 'content', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'spec', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'description', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'feature', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );


        $('#save-change').click(function(){
            console.log($('#related').val())
            
            $('input[name=submit_data_seo]').click(); // Dung de lay du lieu cho bien "data_seo"
            var content = CKEDITOR.instances.content.getData();
            var spec = CKEDITOR.instances.spec.getData();
            var description = CKEDITOR.instances.description.getData();
            var feature = CKEDITOR.instances.feature.getData();

            var data    = {
                _method         : "{{ $method }}",
                id              : "{{ Request::route('articlecategory') }}",
                language        : $('select[name=language]').val(),
                name           : $('input[name=name]').val().trim(),
                barcode           : $('input[name=barcode]').val().trim(),
                model           : $('input[name=model]').val().trim(),
                image           : $('#Filelist').attr('data-file'),
                manufacturer           : $('input[name=manufacturer]').val().trim(),
                avg_price           : $('input[name=avg_price]').val().trim(),
                currency_unit           : $('input[name=currency_unit]').val().trim(),
                title_content        : $('input[name=title_content]').val(),
                content           : content,
                spec           : spec,
                description           : description,
                feature           : feature,
                seo_title       : data_seo.seo_title,
                list_ask     : $('textarea[name=list_ask]').val().trim(),
                seo_description : data_seo.seo_description,
                show_status : data_seo.seo_show_barcode,
                keywords   : $('input[name=keywords]').val().trim(),
                seo_indexed     : data_seo.seo_indexed,
                related_articles : $('#related').val(),
         
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
                                window.location.replace("{{ url('admincp/barcodes') }}");
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

    <script type="text/javascript">
        list_image = [];
        list_title_file_upload = [];
        /* WHEN YOU UPLOAD ONE OR MULTIPLE FILES */
        $(document).on('change','#avatar',function(){
            form_data = new FormData(); 
            len_files = $("#avatar").prop("files").length;
            param = 1;

            for (var i = 0; i < len_files; i++) {
                flag = true;
                var file_data = $("#avatar").prop("files")[i];

                if(jQuery.inArray(file_data.name, list_title_file_upload) !== -1) {
                    flag = false;
                    swal({
                        html: '<div class="alert-danger">File already exists</div>',
                        })
                }
                // alert(list_image.length + param)
                if (list_image.length + param > 10) {
                    flag = false;
                    swal({
                        html: '<div class="alert-danger">You have added more than 10 files. According to upload conditions you can upload 10 files maximum</div>',
                        })
                }
                // alert(file_data.size)
                if (file_data.size == 0) {
                    flag = false;
                    swal({
                        html: "<div class='alert-danger'>Please select a valid image!</div>",
                        })
                }

                if (file_data.size > 2097152) {
                    flag = false;
                    swal({
                        html: "<div class='alert-danger'>The file (" + file_data.name + ") does not match the upload conditions, The maximum file size for uploads should not exceed 2MB</div>",
                        })
                }

                if (flag == true) {
                    param++;
                    list_title_file_upload.push(file_data.name); 
                    form_data.append("avatar[]", file_data);
                }

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('barcode/uploadImageAjax') }}",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, // Setting the data attribute of ajax with form_data
                type: 'post',
                success: function(result) {
                    var html = '';

                    $.each(result.data , function(index, val) { 
                        var link = '{{ asset("uploads/barcode") }}' + '/' + val.new_name;
                        html += '<li><div class="img-wrap"><span class="close" old_name="'+ val.old_name +'" new_name="'+ val.new_name +'">×</span><img width="200" style="margin-top:5px" class="thumb" id="thumbnail" src="' + link + '"' + '></div></li>';
                        list_image.push(val.new_name);
                    });

                    $('#Filelist ul').html(html);
                    console.log(list_image.toString())
                    $('#Filelist').attr('data-file', list_image.toString())
                }
            })




        }); 

        $(document).on('click','.close',function(){
            var filenameOld = $(this).attr('old_name');
            var filenameNew = $(this).attr('new_name');

            list_image = jQuery.grep(list_image, function(value) {
                return value != filenameNew;
            });
            
            list_title_file_upload = jQuery.grep(list_title_file_upload, function(value) {
                return value != filenameOld;
            });

            $(this).closest("li").remove();
            $('#Filelist').attr('data-file', '')
        });


    </script>

@endsection