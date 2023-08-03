@extends('backend.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách tài khoản</h1>
    <div class="add-item text-center">
        <a id="create_user" data-toggle="modal" data-target="#add_user_modal" class="btn btn-success btn-sm" title="Thêm tài khoản"><i class="fa fa-plus"></i> Thêm tài khoản</a>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="user-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <p class="action-selected-rows">
                    <span >Hành động trên các hàng đã chọn:</span>
                    <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span>
                </p>  
            </div>
        </div>
    </div>
    <div id="edit_user_modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">Chỉnh sửa tài khoản</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label">Tên <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="hidden" id="userID_upd" value="">
                    <input type="text" class="form-control" id="userName_upd" >
                    <div id="nameErrorUpd" class="alert-errors d-none" role="alert">
                      
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="userEmail_upd" >
                    <div id="emailErrorUpd" class="alert-errors d-none" role="alert">
                      
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="userPassword_upd" name="password" value="">
                    <div id="passwordErrorUpd" class="alert-errors d-none" role="alert">
                      
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="passConfirm_upd" name="confirmpassword" value="">
                    <div id="confirmpasswordErrorUpd" class="alert-errors d-none" role="alert">
                      
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userEmail_upd" class="col-sm-4 col-form-label">Vai trò <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    {{ Form::select('role_id', $roles, null, ['class' => 'form-control', 'id' => 'role_id']) }}
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveUser">Cập nhật</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
          </div>
        </div>
      </div>
    </div>

    <div id="add_user_modal" class="modal fade" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">Thêm tài khoản</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

           <!--  {!! Form::open(['url' => 'user']) !!} -->
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label">Tên <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="userName_Ins" name="name"  value="{{ Request::old('name') }}">
                    <div class="alert-errors d-none" role="alert" id="nameErrorIns">
                        
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userEmail_upd" class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="email_Ins" name="email"  value="{{ Request::old('email') }}">
                    <div class="alert-errors d-none" role="alert" id="emailErrorIns">
                        
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userPassword" class="col-sm-4 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password_Ins" name="password" value="{{ Request::old('password') }}">
                    <div class="alert-errors d-none" role="alert" id="passwordErrorIns">
                        
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="passConfirm" class="col-sm-4 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="confirmpassword_Ins" name="confirmpassword" value="{{ Request::old('confirmpassword') }}">
                    <div class="alert-errors d-none" role="alert" id="confirmpasswordErrorIns">
                        
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userEmail_upd" class="col-sm-4 col-form-label">Vai trò <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    {{ Form::select('role_id', $roles, null, ['class' => 'form-control', 'id' => 'role_id_Ins']) }}
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="createUser">Thêm mới</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
          </div>
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

        window.onbeforeunload = function() {
            if($('#edit_user_modal').hasClass('show') && ( 
                $('#userName_upd').val() != curr_user_name ||
                $('#userEmail_upd').val() != curr_user_email ||
                $('#userPassword_upd').val() != 'not_change' || 
                $('#passConfirm_upd').val() != 'not_change' )
                ){
                return "Bye now!";
            }
        };



        $('#edit_user_modal').on('shown.bs.modal', function () {
            var id      = $('#userID_upd').val();
            $.ajax({
                url: baseURL+"/admincp/users/getInfoByID/" + id,
                method: "GET",
                dataType:'json',
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        if(response.user.role_id == null){
                            $("#role_id").val(2);
                            $("#userPassword_upd").val(response.user.password);
                            $("#passConfirm_upd").val(response.user.password);
                        }else{
                            $("#role_id").val(response.user.role_id);
                            $("#userPassword_upd").val(response.user.password);
                            $("#passConfirm_upd").val(response.user.password);
                        }
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
        })

        var dataObject = [
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-user" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "name",
                class: "name-field"
            },
            { 
                data: "email",
                class: "email-field"
            },
            { 
                data: "role_name",
                class: "role_name-field",
                render: function(data, type, row){
                    return data;
                },
            },
            { 
                data: "created_at",
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    return '<a class="btn-edit mr-2 edit-user" data-id="'+data+'" data-name="'+row.name+'" data-email="'+row.email+'" title="Sửa"> <i class="fa fa-edit"></i></a> <a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                },
                orderable: false
            },
        ];

        dataTable = $('#user-table').DataTable( {
                        // serverSide: true,
                        aaSorting: [],
                        stateSave: false,
                        ajax: "{{ url('/') }}/admincp/users/getDataAjax",
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 10,
                        order: [[ 4, "desc" ]],
                        colReorder: {
                            fixedColumnsRight: 1,
                            fixedColumnsLeft: 1
                        },
                        oLanguage: {
                            sSearch: "Tìm kiếm",
                            sLengthMenu: "Hiển thị _MENU_ bản ghi",
                            // zeroRecords: "Không tìm thấy bản ghi",
                            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                            sInfoFiltered: "",
                            sInfoEmpty: "",
                            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
                        fnServerParams: function ( aoData ) {

                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            checkCheckboxChecked();
                        }
                    });

        $('#user-table').css('width', '100%');

        // $('#user-table').on( 'page.dt', function () {
        //     $('html,body').animate({
        //         scrollTop: $("#user-table").offset().top},
        //         'slow');
        // } );

        dataTable.search('').draw();

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('.page table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-user'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-user');
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

                $('#edit_user_modal').modal('show');

                $('#userID_upd').val(id);
                $('#userName_upd').val(curr_user_name);
                $('#userEmail_upd').val(curr_user_email);
                // $('#userPassword_upd').val("not_change");
                // $('#passConfirm_upd').val("not_change");
                $(".alert-errors").addClass("d-none");
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
                            url: baseURL+"/admincp/users/" + id,
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
            if ($('#user-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#saveUser').click(function(){
            var id = $('#userID_upd').val();
            var name = $('#userName_upd').val();
            var data    = {
                name                : name,
                email               : $('#userEmail_upd').val(),
                password            : $('#userPassword_upd').val(),
                confirmpassword     : $('#passConfirm_upd').val(),
                role_id             : $('#role_id').val(),
                _method             : "PUT"
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/users/" + id,
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                    current_page = dataTable.page.info().page;
                },
                success: function (data) {
                    var html_data = '';
                    if(data.status == 200){
                        if(id == {{ Auth::user()->id }}){
                            $('#user-name-txt').html(name);
                        }
                        $('#edit_user_modal').modal('hide');
                        dataTable.page(current_page).draw(false);
                        $().toastmessage('showSuccessToast', data.Message);
                    }else{
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#' + index + 'ErrorUpd').html(value);
                            $('#' + index + 'ErrorUpd').removeClass('d-none');
                        });
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#' + index + 'ErrorUpd').html(value);
                            $('#' + index + 'ErrorUpd').removeClass('d-none');
                        });
                    }else{
                        if(data.status == 401){
                          window.location.replace(baseURL);
                        }else{
                         $().toastmessage('showErrorToast', errorConnect);
                        }
                    }
                }
            });
        });

        $('#apply-all-btn').click(function (){
            $.ajsrConfirm({
                message: "Bạn có chắc chắn muốn xóa ?",
                okButton: "Đồng ý",
                onConfirm: function() {
                    var $id_list = '';
                    $.each($('.check-user'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });

                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-user'), function (key, value){
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
                                url: "{{ url('/') }}/admincp/users/delMultiUser",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-user'), function (key, value){
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

        $('#createUser').click(function(){
            var data    = {
                name             : $('#userName_Ins').val(),
                email            : $('#email_Ins').val(),
                password         : $('#password_Ins').val(),
                role_id          : $('#role_id_Ins').val(),
                confirmpassword  : $('#confirmpassword_Ins').val(),
            };

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: baseURL+"/admincp/users",
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                },
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        clearFormCreate();
                        $('#add_user_modal').modal('toggle');
                        $().toastmessage('showSuccessToast', response.Message);
                        dataTable.ajax.reload(); 
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#'+index+'ErrorIns').html(value);
                            $('#'+index+'ErrorIns').removeClass('d-none');
                        });
                    }
                }
            });
        });

        function clearFormCreate(){
            $('#userName_Ins').val('')
            $('#email_Ins').val('')
            $('#password_Ins').val('')
            $('#confirmpassword_Ins').val('')
            $('select[name=role_id]').val(1)
            $('.alert-errors').addClass("d-none")
        }
        
        // $('#search_txt').keyup(function() {
        //     if($('#search_txt').val().length <= 0){
        //         dataTable.search("").draw();
        //         old_search = '';
        //         $('.delete_text').hide();
        //     }else{
        //         $('.delete_text').show();
        //     }
        // });

        // $('.delete_text').click(function(){
        //   $('#search_txt').val('');
        //   if($('#search_txt').val().trim() != old_search){
        //     old_search = '';
        //     dataTable.search("").draw();
        //   }
        //   $(this).hide();
        // });

        $('#add_user_modal').on('hidden.bs.modal', function () {
            clearFormCreate();
        })
        
    });
</script>

@endsection