@extends('backend.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách khách hàng</h1>
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
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Dịch vụ đang dùng</th>
                            <th scope="col">Số tiền hiện có</th>
                            <th scope="col">Ngày đăng ký</th>
                            <th scope="col" style="width: 10%">Thao tác</th>
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
    <div id="edit_customer_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-600">Chỉnh sửa thông tin khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Họ và tên <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="hidden" id="userID_upd" value="">
                        <input type="text" class="form-control" id="userName_upd" disabled>
                        <div id="nameErrorUpd" class="alert-errors d-none" role="alert">
                        
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="userEmail_upd" disabled>
                        <div id="emailErrorUpd" class="alert-errors d-none" role="alert">
                        
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Số tiền thêm <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" data-type="currency" id="userPrice_upd" value="">
                        <div id="priceErrorUpd" class="alert-errors d-none" role="alert">
                        
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="userAddress_upd" ></textarea>
                        <div id="addressErrorUpd" class="alert-errors d-none" role="alert">
                        
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveCustomer">Cập nhật</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
            </div>
            </div>
        </div>
        </div>
    <div id="edit_pass_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-600">Đổi mật khẩu tài khoản khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Họ và tên <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="email" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password">
                        <div id="passError" class="alert-errors d-none" role="alert"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="changePassCustomer">Cập nhật</button>
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
    id_user_edit_pass = '';
    $(document).ready(function(){

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
                name: 'users.name',
            },
            { 
                data: "email",
                name: 'users.email',
            },
            { 
                data: "phone",
                name: 'users.phone',
            },
            { 
                data: "service_name",
                name: 'users.name',
                render: function(data, type, row){
                    if (row.service_name != null) {
                        return 'Gói ' + row.service_name;
                    }
                    
                    return '';
                },
            },
            { 
                data: "price",
                name: 'users.price',
            },
            { 
                data: "created_at",
                name: 'users.created_at',
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    return '<a class="btn-edit mr-2 edit-pass" data-id="'+data+'" data-name="'+row.name+'" data-email="'+row.email+'" title="Đổi mật khẩu"> <i class="fa fa-key"></i></a><a class="btn-edit mr-2 edit-customer" data-id="'+data+'"  data-address="'+row.address+'" data-name="'+row.name+'" data-email="'+row.email+'" title="Sửa"> <i class="fa fa-edit"></i></a> <a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                },
                orderable: false
            },
        ];

        dataTable = $('#user-table').DataTable( {
            serverSide: true,
            aaSorting: [],
            stateSave: false,
            ajax: "{{ url('/') }}/admincp/customers/getDataAjax",
            columns: dataObject,
            order: [[ 1, "desc" ]],
            // bLengthChange: false,
            // pageLength: 10,
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
            },
        });

        $('#user-table').css('width', '100%');

        dataTable.search('').draw();
        
        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#user-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#user-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#user-table tbody input[type="checkbox"]:checked').length == $('#user-table tbody input[type="checkbox"]').length ){
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
            console.log(userCheckList);
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
            $('.edit-customer').off('click');
            $('.edit-customer').click(function(){
                $('#edit_customer_modal').modal('show');
                var id              = $(this).attr('data-id');
                curr_user_name            = $(this).attr('data-name');
                curr_user_email           = $(this).attr('data-email');
                curr_user_address     = $(this).attr('data-address');
                curr_user_price     = $(this).attr('data-price');
                $('#userID_upd').val(id);
                $('#userName_upd').val(curr_user_name);
                $('#userEmail_upd').val(curr_user_email);
                $('#userPrice_upd').val(curr_user_price);
                //  $('#userAddress_upd').val(curr_user_address);
                $(".alert-danger").addClass("d-none");
            });

            $('.edit-pass').off('click');
            $('.edit-pass').click(function(){
                $('#edit_pass_modal').modal('show');
                $('#passError').html('');
                $('#edit_pass_modal input[name=password]').val('');
                id_user_edit_pass  = $(this).attr('data-id');
                curr_user_name            = $(this).attr('data-name');
                curr_user_email           = $(this).attr('data-email');
                // curr_user_address     = $(this).attr('data-address');
                $('#edit_pass_modal input[name=username]').val(curr_user_name);
                $('#edit_pass_modal input[name=email]').val(curr_user_email);
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
                            url: baseURL+"/admincp/customers/" + id,
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

        $('#saveCustomer').click(function(){
            var id = $('#userID_upd').val();
            // var address = $('#userAddress_upd').val();
            var price = $('#userPrice_upd').val().replace(/,/g,'');
            price = price != '' ? price : 0;
            var data    = {
                price                : price,
                _method             : "PUT"
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/customers/" + id,
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
                        $('#edit_customer_modal').modal('hide');
                        dataTable.page(current_page).draw(false);
                        $().toastmessage('showSuccessToast', data.message);
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

        $('#changePassCustomer').click(function(){
            var data    = {
                _method             : "PUT",
                password : $('#edit_pass_modal input[name=password]').val(),
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/customers/" + id_user_edit_pass,
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (data) {
                    var html_data = '';
                    if(data.status == 200){
                        $('#edit_pass_modal').modal('toggle');
                        $().toastmessage('showSuccessToast', data.message);
                    }else{
                        $('#passError').html(data.message);
                        $('#passError').removeClass('d-none');
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
                                url: "{{ url('/') }}/admincp/customers/delMultiUser",
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


        function clearFormCreate(){
            $('#userName_Ins').val('')
            $('#email_Ins').val('')
            $('#password_Ins').val('')
            $('#confirmpassword_Ins').val('')
            $('select[name=role_id]').val(1)
            $('.alert-danger').addClass("d-none")
        }
    
    });
</script>

@endsection