@extends('backend.master')
@section('title', 'Quản lý bài viết')
@section('content')
    <link rel="stylesheet" href="{{ asset('backend/dist/css/bootstrap-multiselect.min.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('backend/dist/js/bootstrap-multiselect.min.js') }}"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js" integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/articles/create'))
                Thêm bài viết
                <?php 
                    $url = url('admincp/articles/');
                    $method = 'POST';
                ?>
            @else
                Sửa bài viết
                <?php 
                    $url = url('admincp/articles/' . $data->id);
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
                                <li class="breadcrumb-item active font-weight-600" aria-current="page">THÔNG TIN BÀI VIẾT</li>
                            </ol>
                        </nav>
                        <div class="form-group clearfix row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tên bài viết</label>
                                <input type="text" class="form-control"  name="title" value="{{ isset($data->title) ? $data->title : '' }}">
                                <p class="alert-title alert-errors"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{ isset($data->slug) ? $data->slug : '' }}">
                                <p class="alert-slug alert-errors"></p>
                            </div>
                        </div>
                       <div class="form-group clearfix">
                            <label class="font-weight-bold">Mô tả ngắn</label>
                            <textarea class="form-control" name="description" rows="5">{{ isset($data->description) ? $data->description : '' }}</textarea>
                            <p class="alert-description alert-errors"></p>
                        </div>
                       <div class="form-group clearfix">
                            <label class="font-weight-bold">Giới thiệu</label>
                            <textarea class="form-control" id="intro" name="intro" rows="5">{{ isset($data->intro) ? $data->intro : '' }}</textarea>
                            <p class="alert-intro alert-errors"></p>
                        </div>
                        <div class="form-group" >
                            <label class="font-weight-bold">Nội dung</label>
                            <textarea class="form-control" id="content" name="content">{{ isset($data->content) ? $data->content : '' }}</textarea>
                            <p class="alert-content alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Giới thiệu FAQ</label>
                            <textarea class="form-control" id="intro_faq" name="intro_faq" rows="5">{{ isset($data->intro_faq) ? $data->intro_faq : '' }}</textarea>
                            <p class="alert-intro_faq alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Hỏi đáp</label>
                            <textarea class="form-control" id="list_ask" name="list_ask" rows="10" autocorrect="off" spellcheck="false">{{ isset($data->list_ask) ?  $data->list_ask : '' }}</textarea>
                            <p class="alert-list_ask alert-errors"></p>
                        </div>
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Đoạn kết</label>
                            <textarea class="form-control" id="ending" name="ending" rows="5">{{ isset($data->ending) ? $data->ending : '' }}</textarea>
                            <p class="alert-ending alert-errors"></p>
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
                                                @if (Request::get('language') == 'en' || Request::is('admincp/articles/create'))
                                                    <img src="{{ asset('backend/images/en.png') }}" title="English">
                                                @else
                                                    <img src="{{ asset('backend/images/vi.png') }}" title="Tiếng Việt">
                                                @endif
                                            </td>
                                            <td class="translation-column" style="width:20%">
                                                <select name="language" class="ui-select">
                                                    @if (Request::get('language') == 'en' || Request::is('admincp/articles/create'))
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
                                            <iframe width="100%" height="450px" src="{{asset('filemanager/dialog.php')}}?type=1&sort_by=date&descending=1&field_id=filemanager-image&fldr=imgs" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Danh mục</span></h4>
                        </div>
                        <div class="widget-body clearfix text-center">
                            <select name="cat_id" class="form-control select2 wrap">
                                <option value="">--Chọn--</option>
                                @if($cache_all_categories)
                                    @if(isset($data))
                                        @foreach($cache_all_categories as $value)
                                            @if($value->id == $data->cat_id)
                                            <option value="{{$value->id}}" selected>{{$value->title}}</option>
                                            @else
                                            <option value="{{$value->id}}">{{$value->title}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($cache_all_categories as $value)
                                            <option value="{{$value->id}}">{{$value->title}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                            <p class="alert-cat_id alert-errors"></p>
                        </div>
                    </div> 
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Tags</span></h4>
                        </div>
                        <div class="widget-body clearfix text-left">
                            <link href="{{ asset('backend/css/tagify.css') }}" rel="stylesheet">
                            <script src="{{ asset('backend/js/jQuery.tagify.min.js') }}"></script>
                            <script src="{{ asset('backend/js/dragsort.js') }}"></script>
                            <input name='tags' value='{{ isset($data->list_tags) ? $data->list_tags : "" }}'>
                            <div class="text-center">
                                <button class='tags--removeAllBtn btn btn-xs btn-primary text-center' type='button' style="margin-top: 10px">Xóa hết tags</button>
                            </div>
                        </div>
                    </div>
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Xuất bản</span></h4>
                        </div>
                        <div class="widget-body clearfix text-left">
                            <div class="form-group">
                                <label class="font-weight-bold">Trạng thái:</label>
                                <select name="post_status" class="form-control select2 wrap">
                                    <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>Xuất bản</option>
                                    <option value="0" {{ isset($data->status) && $data->status == 0 ? 'selected' : '' }}>Chờ phê duyệt</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Ngày xuất bản:</label>
                                <div class='input-group date' id='post_public_datetimepicker'>
                                    <input type="text" class="form-control" placeholder="DD/MM/YYYY HH:mm" name="post_public_time" value="{{ isset($data->post_public_time) && $data->post_public_time != '' ? App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->post_public_time, 'd/m/Y H:i') : '' }}">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <script>
                                    $('#post_public_datetimepicker').datetimepicker({
                                        format: "DD/MM/YYYY HH:mm",
                                        // useCurrent: false,
                                        // minDate: moment()
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4><span>Bài viết liên quan</span></h4>
                        </div>
                        <div class="widget-body clearfix text-left">
                                @php
                                    if(isset($data->relative_acticles)){
                                        $relative_articles = json_decode($data->relative_acticles, TRUE);
                                    }
                                @endphp
                                <select class="js-example-basic-multiple w-100" id="relative" name="relative-acticles[]" multiple="multiple">
                                    @if(isset($relative_articles) && isset($data))
                                        @foreach($cache_all_article as $value)
                                            @if(in_array($value->id, $relative_articles))
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
                        </style>
                    </div>
                </div>
            </div>
        </div>
        <div class="tmp_content hidden"></div>
    </section>

    <style type="text/css">
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
        .multiselect-container {
            width: 100%;
        }

        .multiselect-filter{
            display: flex;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#relative').multiselect({
                buttonWidth:'100%',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
            })
        });
        var $input = $('input[name=tags]').tagify({
            whitelist : [
                {"id":1, "value":"some string"}
            ]
        })
        .on('add', function(e, tagName){
            console.log('JQEURY EVENT: ', 'added', tagName)
        })
        .on("invalid", function(e, tagName) {
            console.log('JQEURY EVENT: ',"invalid", e, ' ', tagName);
        });

        // get the Tagify instance assigned for this jQuery input object so its methods could be accessed
        var jqTagify = $input.data('tagify');

        // bind the "click" event on the "remove all tags" button
        $('.tags--removeAllBtn').on('click', jqTagify.removeAllTags.bind(jqTagify))


        var input = document.querySelector('input[name=drag-sort]'),
            tagify = new Tagify(input);


        var dragsort = new DragSort(jqTagify.DOM.scope, {
            selector:'.'+jqTagify.settings.classNames.tag,
            callbacks: {
                dragEnd: onDragEnd
            }
        })

        function onDragEnd(elm){
            jqTagify.updateValueByDOMTags()
        }

        var data_seo; // Dung de lay data SEO
        var $select2 = $('.select2').select2({
            containerCssClass: "wrap"
        })

        CKEDITOR.replace( 'intro', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'intro_faq', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'content', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );

        CKEDITOR.replace( 'ending', {
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
        @if (! Request::is('admincp/articles/create') && $data)
            if ("{{ isset($data->schema_type) ? $data->title : '' }}"){
                $('select[name=schema_select]').val('{{ $data->schema_type }}');
                $('.schema-content #schema_{{ $data->schema_type }}').addClass('active in');
                $('.headline-description').show();
                $('.test-schema-on-google').show();
                $('textarea[name=test_schema_json]').val('{!! $data->schema_code !!}');
            }
        @endif

        makeFaqJson = function(str) {

            return str;
        }

        $('#save-change').click(function(){

            $('input[name=submit_data_seo]').click(); // Dung de lay du lieu cho bien "data_seo"
            let slug = $('input[name=slug]').val().trim();
            let seo_title = data_seo.seo_title;
            let post_public_time = $('input[name=post_public_time').val().trim();

            if (slug == ''){
                slug = titleToSlug($( "input[name=title]" ).val());
            }
            if (seo_title == ''){
                seo_title = $('input[name=title]').val().trim();
            }

            var content = CKEDITOR.instances.content.getData();
            var ending = CKEDITOR.instances.ending.getData();
            var intro = CKEDITOR.instances.intro.getData();
            var intro_faq = CKEDITOR.instances.intro_faq.getData();

            var arr_tags = [];
 
            $('tags tag').each(function(i, obj) {
                arr_tags.push($(this).text())
            });

            var data    = {
                _method         : "{{ $method }}",
                id              : "{{ Request::route('articlecategory') }}",
                language        : $('select[name=language]').val(),
                title           : $('input[name=title]').val().trim(),
                slug            : slug,
                intro           : intro,
                intro_faq           : intro_faq,
                ending           : ending,
                description     : $('textarea[name=description]').val().trim(),
                relative_acticles : $('#relative').val(),
                content         : content,
                list_ask     : $('textarea[name=list_ask]').val().trim(),
                image           : $('#filemanager-image').attr('src'),
                cat_id          : $('select[name=cat_id]').val().trim(),
                status          : $('select[name=post_status]').val().trim(),
                post_public_time: post_public_time,
                seo_title       : seo_title,
                seo_description : data_seo.seo_description,
                keywords   : $('input[name=keywords]').val().trim(),
                article_tag        : arr_tags,
                seo_indexed     : data_seo.seo_indexed,
         
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
                                window.location.replace("{{ url('admincp/articles') }}");
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