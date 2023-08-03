@extends('backend.master')

@section('content')
    <section class="content-header">
        <h1 class="text-center font-weight-600">
            @if(Request::is('admincp/pages/create'))
                Thêm trang
                <?php 
                    $url = url('admincp/pages/');
                    $method = 'POST';
                ?>
            @else
                Sửa trang
                <?php 
                    $url = url('admincp/pages/' . $data->id);
                    $method = 'PUT';
                ?>
            @endif

        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active font-weight-600" aria-current="page">THÔNG TIN</li>
                            </ol>
                        </nav>
                        <div class="form-group clearfix row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tên trang</label>
                                <input type="text" class="form-control"  name="title" value="{{ isset($data->title) ? $data->title : '' }}">
                                <p class="alert-title alert-errors"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Slug</label>
                                <input type="text" class="form-control" name="slug" maxlength="65" placeholder="Tối đa 65 ký tự" value="{{ isset($data->slug) ? $data->slug : '' }}">
                                <p class="alert-slug alert-errors"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix" style="height: 362px">
                            <label class="font-weight-bold">Mô tả</label>
                            <textarea class="form-control" name="description" id="description">{{ isset($data->description) ? $data->description : '' }}</textarea>
                            <p class="alert-description alert-errors"></p>
                        </div>
                        <div class="form-group" >
                            <label class="font-weight-bold">Nội dung</label>
                            <textarea class="form-control" id="content" name="content">{{ isset($data->content) ? $data->content : '' }}</textarea>
                            <p class="alert-content alert-errors"></p>
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
            <div class="col-md-3">
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
                                            @if (Request::get('language') == 'en' || Request::is('admincp/pages/create'))
                                                <img src="{{ asset('backend/images/en.png') }}" title="English">
                                            @else
                                                <img src="{{ asset('backend/images/vi.png') }}" title="Tiếng Việt">
                                            @endif
                                        </td>
                                        <td class="translation-column" style="width:20%">
                                            <select name="language" class="ui-select">
                                                @if (Request::get('language') == 'en' || Request::is('admincp/pages/create'))
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
            </div>
        </div>
        <div class="tmp_content hidden"></div>
    </section>

    <script>
        CKEDITOR.replace( 'description', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );
        CKEDITOR.replace( 'content', {
            filebrowserBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{ url("/") }}/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{ url("/") }}/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
        } );
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
        var data_seo; 

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
            let slug = $('input[name=slug]').val().trim();
            let seo_title = $('input[name=seo_title]').val().trim();
            var content = CKEDITOR.instances.content.getData();
            var description = CKEDITOR.instances.description.getData();

            if (slug == ''){
                slug = titleToSlug($( "input[name=title]" ).val());
            }
            if (seo_title == ''){
                seo_title = $('input[name=title]').val().trim();
            }

            var arr_tags = [];
 
            $('tags tag').each(function(i, obj) {
                arr_tags.push($(this).text())
            });


            var data    = {
                _method         : "{{ $method }}",
                title           : $('input[name=title]').val(),
                slug            : slug,
                language        : $('select[name=language]').val(),
                page_tag        : arr_tags,
                seo_title       : seo_title,
                seo_description : $('textarea[name=seo_description]').val().trim(),
                keywords        : $('input[name=keywords]').val().trim(),
                seo_indexed     : $('input[name=seo_indexed]').attr('data-index'),
                description     : description,
                content         : content,
            };

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
                                window.location.replace("{{ url('admincp/pages') }}");
                            }
                        });
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