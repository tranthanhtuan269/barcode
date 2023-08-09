@extends('backend.master')
@section('title', 'Bài viết')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"/>
<link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
<script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
<section class="content-header">
    <h1 class="text-center font-weight-600">
        Danh sách barcode
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-5 form-group">
                    <label>Ngôn ngữ: </label>
                    <select name="language" class="form-control">
                        <option value="en" @if (Request::get('language') == 'en') selected @endif>English</option>
                        <option value="vi" @if (Request::get('language') == 'vi') selected @endif>Vietnammese</option>
                    </select>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Từ khóa: </label>
                    <input class="form-control" type="text" name="keyword" id="search-article">
                </div>
                <div class="col-sm-1 form-group">
                    <button type="button" class="btn btn-primary btn-sm" style="margin-top:26px" id="search">Tìm kiếm</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="article-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Ảnh đại diện</th>
                            <th>Tên sản phẩm</th>
                            <th>Kiểm duyệt</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>
                                <img src="{{ asset('backend/images/en.png') }}" title="English">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectCol" class="check-article" value="{{ $data->id }}" data-column="{{ $data->id }}">
                            </td>
                            <td>
                                @php
                                if(strlen($data->image) > 0){
                                    if(str_contains($data->image, ',')){
                                        $pieces = explode(",", $data->image);
                                        if (str_contains($pieces[0], 'http')){
                                            echo "<img src='$pieces[0]' width='60'>";
                                        }else{
                                            echo "<img src='/uploads/barcode/$pieces[0]' width='60'>";
                                        }
                                    }else{
                                        if (str_contains($data->image, 'http')){
                                            echo "<img src='$data->image' width='60'>";
                                        }else{
                                            echo "<img src='/uploads/barcode/$data->image' width='60'>";
                                        }
                                    }
                                }else{
                                @endphp
                                <img src="data:image/png;base64, {{ \DNS1D::getBarcodePNG($data->barcode, 'C39+',1,80) }}" alt="{{$data->barcode}}" width="60">
                                @php
                                }
                                @endphp
                                
                            </td>
                            <td>
                                <a href="/admincp/barcodes/{{ $data->id }}/edit?language=en" title="Sửa">{{ $data->name }}</a>
                            </td>
                            <td>
                                @if ($data->seo_indexed == 1)
                                <div class="text-success text-bold">YES</div>
                                @else
                                <div class="text-danger text-bold">NO</div>
                                @endif
                            </td>
                            <td>
                                {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->created_at, 'd/m/Y')}}
                            </td>
                            <td>
                                {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->updated_at, 'd/m/Y')}}
                            </td>
                            <td>
                                <a href="/admincp/barcodes/{{ $data->id }}/edit?language=en"  class="btn-edit" title="Sửa"><i class="fa fa-edit"></i></a>
                                <a href="/admincp/barcodes/{{ $data->id }}/remove-image?language=en"  class="btn-remove" title="Remove Image"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="float:right">
                    {{ $datas->appends(Request::all())->links() }}
                </div>
                <p class="action-selected-rows">
                    <span >Hành động trên các hàng đã chọn:</span>
                    <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span>
                </p>
            </div>
        </div>
    </div>
</section>
<script>
    var $select2 = $('.select2').select2({
        containerCssClass: "wrap",
        width: '100%',
    })
    language = 'vi';
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";
    
    $(document).ready(function(){
        addEventListener();
        checkCheckboxChecked();
    
        $('#article-table').css('width', '100%');

        $("#search").click(function(){
            $.ajax({
                url: "/admincp/barcodes/getBarcodeAjax",
                data: {
                    search : $('#search-article').val().trim()
                },
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(response) {
                    $('tbody').html(response);
                },
                error: function (data) {
                    
                }
            });
        });

        $("select[name=language]").change(function(){  
            language = $('select[name=language]').val();
            var request = $.ajax({
                url: "{{ route('info-cat-article-by-lang') }}" + "?language=" + language,
                method: "GET",
                dataType: "html"
            });

            request.done(function (msg) {
                $("select[name=cat_id]").html('<option value="0">--Tất cả--</option>');
                $("select[name=cat_id]").select2().select2('val', "0");
                $('.select2').select2({
                                        containerCssClass: "wrap",
                                        width: '100%',
                                    });
                $("select[name=cat_id] option").after(msg);
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $("#select-all-btn").change(function(){  
            $('#article-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });
    
        $('body').on('click', '#article-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#article-table tbody input[type="checkbox"]:checked').length == $('#article-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }
    
            // save localstore
            setCheckboxChecked();
        });
    
        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-article'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }
    
        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-article');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), userCheckList)){
                        $(this).prop('checked', 'true');
                        count_row++;
                    }
                });
    
                if(count_row == listUser.length){
                    $('#select-all-btn').prop('checked', true);
                }else{
                    $('#select-all-btn').prop('checked', false);
                }
            }else{
                $('#select-all-btn').prop('checked', false);
            }
        }
    
        function containsObject(obj, list) {
            var i;
            for (i = 0; i < list.length; i++) {
                if (list[i] === obj) {
                    return true;
                }
            }
    
            return false;
        }
    
        function checkEmptyTable(){
            if ($('#article-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    
    
        $('#apply-all-btn').click(function (){
            $.ajsrConfirm({
                message: "Bạn có chắc chắn muốn xóa ?",
                okButton: "Đồng ý",
                onConfirm: function() {
                    var $id_list = '';
                    $.each($('.check-article'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });
    
                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-article'), function (key, value){
                            if($(this).prop('checked') == true) {
                                $id_list += $(this).attr("data-column") + ',';
                            }
                        });
    
                        if($id_list.length > 0){
                            var data = {
                                id_list:$id_list,
                                _method:'delete'
                            };
                            $.ajax({
                                type: "post",
                                url: "{{ url('/') }}/admincp/barcodes/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-article'), function (key, value){
                                            if($(this).prop('checked') == true) {
                                                $(this).parent().parent().hide("slow");
                                            }
                                        });
                                        dataTable.ajax.reload(); 
                                        $().toastmessage('showSuccessToast', obj.Message);
                                    }
                                },
                                error: function (data) {
                                    if(data.status == 401){
                                      window.location.replace(baseURL);
                                    }else{
                                     $().toastmessage('showErrorToast', errorConnect);
                                    }
                                }
                            });
                        }
                    }
                },
                nineCorners: false,
            });
    
        });
    
        function addEventListener(){

            $('.find-category').click(function(){
                var category_name = $(this).attr('data-catId');
                $('select[name=cat_id]').val(category_name);
                $('select[name=cat_id]').select2('val',category_name);
            });
        }

        
    });
</script>
@endsection