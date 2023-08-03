@extends('backend.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách Page <a href="{{ url('/') }}/admincp/pages/create" class="btn btn-success btn-sm" title="Thêm mới danh mục bài viết">Thêm mới</a></h1>
    <!-- <div class="add-item text-center">
         <a href="{{ url('/') }}/admincp/pages/create" class="btn btn-success btn-sm" title="Thêm mới page"><i class="fa fa-plus"></i> Thêm mới</a>
    </div> -->
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="page-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Ngày cập nhật</th>
                            <th>
                                <img src="{{ asset('backend/images/en.png') }}" title="English">
                            </th>
                            <!-- <th scope="col">Thao tác</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectCol" class="check-page" value="{{ $data->id }}" data-column="{{ $data->id }}">
                            </td>
                            <td>
                                <p style="margin-bottom:0">{{ $data->title }}</p>
                            </td>
                            <td class="text-center">
                                {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->created_at, 'd/m/Y')}}
                            </td>
                            <td class="text-center">
                                {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->updated_at, 'd/m/Y')}}
                            </td>
                            <td>
                                <a href="/admincp/pages/{{ $data->id }}/edit?language=en"  class="btn-edit" title="Sửa"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="action-selected-rows">
                    <span >Hành động trên các hàng đã chọn:</span>
                    <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span>
                </p>  
            </div>
        </div>
    </div>
</section>

<script>
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

        $('#page-table').css('width', '100%');
        
        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#page-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#page-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#page-table tbody input[type="checkbox"]:checked').length == $('#page-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-page'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-page');
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

        function addEventListener(){
            $('.edit-user').off('click');
            $('.edit-user').click(function(){
                var id              = $(this).attr('data-id');
                curr_user_name            = $(this).attr('data-name');
                curr_user_email           = $(this).attr('data-email');
                $('#userID_upd').val(id);
                $('#userName_upd').val(curr_user_name);
                $('#userEmail_upd').val(curr_user_email);
                // $('#userPassword_upd').val("not_change");
                // $('#passConfirm_upd').val("not_change");
                $(".alert-danger").addClass("d-none");
            });

            $('.btn-delete').off('click');
            $('.btn-delete').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                $.ajsrConfirm({
                    message: "Bạn có chắc chắn muốn xóa ?",
                    okButton: "Đồng ý",
                    onConfirm: function() {
                        var data    = {
                            _method             : "DELETE"
                        };
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/pages/" + id,
                            data: data,
                            method: "POST",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                var html_data = '';
                                if(response.status == 200){
                                  dataTable.page(checkEmptyTable()).draw(false);
                                  $().toastmessage('showSuccessToast', response.Message);
                                }else{
                                  $().toastmessage('showErrorToast', response.Message);
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
                    },
                    nineCorners: false,
                });
            });
        }

        function checkEmptyTable(){
            if ($('#page-table').DataTable().data().count() <= 1 && current_page > 0) {
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
                    $.each($('.check-page'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });

                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-page'), function (key, value){
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
                                type: "POST",
                                url: "{{ url('/') }}/admincp/pages/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-page'), function (key, value){
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
    
    });
</script>

@endsection