@extends('backend.master')

@section('title', 'System Manager')


@section('content')
<link rel="stylesheet" href="{{ url('/') }}/backend/css/jquery-ui.css">
<script src="{{ url('/') }}/backend/js/jquery-ui.js"></script>
<style>
    #main-menu-list .product-image{ 
        height: 50px;
        float: left;
        /* cursor: pointer; */
    }
    #main-menu-list ul li{ 
        cursor: all-scroll;
        height: 70px;
    }
    #main-menu-list .form-control{
        width: 50%;
    }    
</style>
<section class="content-header">
    <h1 class="text-center font-weight-600">Thiết lập slide</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="note note-success">
                <p>Có thể sắp xếp vị trí hiển thị slide bằng cách kéo thả các bản ghi.</p>
            </div>
            <div class="card-body" id="main-menu-list">
                <ul id="sortable">
                    @if ( $listSlides )
                        <?php $i = 0; ?>
                        @foreach($listSlides as $key => $slide)
                        <?php $i++; ?>
                        <li id="slider-{{ $i }}" class="ui-state-default ui-sortable-handle" data-id="{{ $key }}" src="/" data-src="{{ $slide->image }}" data-link="{{ $slide->link }}">
                            <div id="menu-{{ $i }}">
                                <img src="{{ url('/') }}/filemanager/data-images/{{ $slide->image }}" class="product-image" data-id="{{ $i }}" id="image-{{ $i }}">
                            </div>
                            {{-- <input type="text" class="form-control link" value="{{ $slide->link }}"> --}}
                            <span class="btn-edit" data-toggle="modal" data-target="#myModalEditSlide"><i class="fa fa-edit"></i></span>
                            <span class="btn-remove"><i class="fa fa-times"></i></span>
                        </li>
                        @endforeach
                    @endif
                </ul>
                <div class="text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#myModalAddSlide"><i class="fa fa-plus"></i> Thêm mới</button></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="myModalAddSlide">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Thêm mới slide</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                Hình ảnh
                            </div>
                            <div class="col-sm-8">
                                <img id="filemanager-image" src="" class="hidden">
                                <img class="filemanager-image" src="">
                                <p class="alert-image alert-errors"></p>
                                <button type="button" class="btn btn-xs btn-primary text-center" data-toggle="modal" href="javascript:;" data-target="#myModalFilemanager">Chọn ảnh</button>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                Đường dẫn
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="add-slide">Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalEditSlide">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Chỉnh sửa slide</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                Hình ảnh
                            </div>
                            <div class="col-sm-8">
                                <img id="filemanager-image" src="" class="hidden">
                                <img class="filemanager-image" src="">
                                <p class="alert-image alert-errors"></p>
                                <button type="button" class="btn btn-xs btn-primary text-center" data-toggle="modal" href="javascript:;" data-target="#myModalFilemanager">Chọn ảnh</button>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                Đường dẫn
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="edit-slide">Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function responsive_filemanager_callback(field_id){
            var url=jQuery('#'+field_id).val();
            $('.filemanager-image').attr('src', url);
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

</section>
<script>
    var fullUrl = window.location.href;
    var jcrop_api;
    var canvas;
    var context;
    var image;
    var prefsize;
    var selected = '';

    var possitionMenu = 'slide';

    $(document).ready(function(){

        $('#add-slide').click(function(){
            var data    = {
                _method           : "POST",
                image : $('#myModalAddSlide .filemanager-image').attr('src'),
                link       : $('#myModalAddSlide input[name=link]').val().trim(),
            };

            $.ajax({
                type: "POST",
                url: "{{ route('config.add-slide') }}",
                data: data,
                dataType:'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (response) {
                    var html_data = '';

                    if(response.status == 200){
                        $().toastmessage('showSuccessToast', response.message);
                        setTimeout(function(){ location.reload(); }, 1000);
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

        id_edit_slide = '';

        $('.btn-edit').click(function(){
            var link_image = $(this).closest('.ui-state-default').attr('data-src');
            link_image = baseURL + '/filemanager/data-images/' + link_image;
            var link = $(this).closest('.ui-state-default').attr('data-link');
            id_edit_slide  = $(this).closest('.ui-state-default').attr('data-id');
            $('#myModalEditSlide .filemanager-image').attr('src', link_image);
            $('#myModalEditSlide input[name=link]').val(link);
        });

        $('#edit-slide').click(function(){
            var data    = {
                _method           : "POST",
                image : $('#myModalEditSlide .filemanager-image').attr('src'),
                link       : $('#myModalEditSlide input[name=link]').val().trim(),
                id : id_edit_slide,
            };

            $.ajax({
                type: "POST",
                url: "{{ route('config.edit-slide') }}",
                data: data,
                dataType:'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (response) {
                    var html_data = '';

                    if(response.status == 200){
                        $().toastmessage('showSuccessToast', response.message);
                        setTimeout(function(){ location.reload(); }, 1000);
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

        $(document).on('keyup', '.link', function(e) {
            var link = $(this).val(); 
            selected = $(this).attr('data-id');
            $('#slider-' + selected).attr('data-link', link);

            if(e.keyCode == 13) {
                var image = $(this).closest('li').attr('data-src');

                if (image == '') {
                    $().toastmessage('showErrorToast', "Xin vui lòng upload hình ảnh!");
                } else {
                    $(this).closest('li').attr('data-link', link); 
                    $('input').blur(); 
                    saveMenu(possitionMenu);
                }
            }
        });

        $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                $('#sortable li').removeClass('highlights');
                saveMenu(possitionMenu);
            }
        });

        $( "#sortable" ).disableSelection();

        $('.nav-list').click(function(){
            if($(this).find('.menu-icon-right').hasClass('fa-angle-down')){
                $(this).find('.menu-icon-right').removeClass('fa-angle-down').addClass('fa-angle-right');
            }else{
                $(this).find('.menu-icon-right').addClass('fa-angle-down').removeClass('fa-angle-right');
            }
        });

        $('#main-menu-list>ul>li>.label').click(function(){
            var text = $(this).html();
            $(this).parent().find('.editor>input').val(text);
            // $(this).addClass('d-none');
            $(this).parent().find('.editor').removeClass('d-none');
        });

        $('#main-menu-list>ul>li>.editor>.btn-save').click(function(){
            // save data to server
            saveMenu(possitionMenu);
        });

        $('#main-menu-list>ul>li>.editor>.btn-cancel').click(function(){
            $(this).parent().parent().find('.label').removeClass('d-none');
            // $(this).parent().addClass('d-none');
        });


        addEventRemove();
        function addEventRemove(){
            $('.btn-remove').off('click');
            $('.btn-remove').click(function(){
                var _self = $(this);
                $.ajsrConfirm({
                    message: "Bạn có chắc chắn muốn xóa ?",
                    okButton: "Đồng ý",
                    onConfirm: function() {
                        _self.parent().addClass('hidden removed');
                        saveMenu(possitionMenu);
                    },
                    nineCorners: false,
                });
            });
        }

        function saveMenu(name){
            var _self   = $(this);
            var key     = name;
            var value   = '';
            var success = 0;

            var jsonObj = [];
            $(".ui-state-default").each(function( index ) {
                if (!$(this).hasClass('removed')) {
                    item = {}
                    item ["image"] = $(this).attr('data-src');
                    item ["link"] = $(this).attr('data-link');
                    if (item ["image"] != '') {
                        jsonObj.push(item);
                    }
                }
            });
            jsonObj = JSON.stringify(jsonObj);

            var request = $.ajax({
                url: baseURL + "/admincp/menu/save-menu",
                method: "POST",
                data: { 
                    key     : key,
                    value   : jsonObj,
                },
                dataType: "json"
            });
                
            request.done(function( msg ) {
                if(msg.status == 200){
                    $().toastmessage('showSuccessToast', "Lưu thông tin thành công!");
                    // _self.parent().parent().find('.label').html(new_val);
                    _self.parent().parent().find('.label').removeClass('d-none');
                    _self.parent().addClass('d-none');
                    success = 1;
                }else{
                    $().toastmessage('showErrorToast', "Đã có lỗi trong quá trình lưu dữ liệu!");
                    success = 0;
                }
            });
                
            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                success = 0;
            });
            return success;
        }

    });
</script>
@endsection
    