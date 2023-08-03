@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách quyền</h1>
    <div class="add-item text-center">
        <a id="create_permission" data-toggle="modal" data-target="#add_permission_modal" class="btn btn-success btn-sm" title="Thêm quyền"><i class="fa fa-plus"></i> Thêm quyền</a>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="permission-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Nhóm</th>
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
            <div id="edit_permission_modal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Chỉnh sửa quyền</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                        <label for="permissionName_upd" class="col-sm-5 col-form-label">Tên quyền <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="hidden" id="permissionID_upd" value="">
                            <input type="text" class="form-control" id="permissionName_upd">
                            <div class="alert-errors" role="alert" id="permission_nameErrorUpd"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="permissionRoute_upd" class="col-sm-5 col-form-label">Nhóm quyền <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                        {{ Form::select('permissionGroup', ['1' => 'Giao diện người dùng', '2' => 'dịch vụ', '8' => 'Đơn hàng', '3' => 'Khách hàng', '4' => 'Bài viết', '5' => 'Tài khoản quản trị', '6' => 'Page', '7' => 'Liên hệ'], null, ['id' => 'permissionGroup_upd', 'class' => 'form-control', 'placeholder' => '--Chọn nhóm--']) }}
                        <div class="alert-errors" role="alert" id="permission_groupErrorUpd"></div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="savePermission">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="add_permission_modal" class="modal fade" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Thêm mới quyền</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(['id' => 'create_permission_form']) !!}
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Tên quyền <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control permissionNameIns" placeholder="Eg: Create Permission">
                            <div class="alert-errors" role="alert" id="nameErrorIns"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Tên vai trò <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control routeNameIns" placeholder="Eg: user.create" autocomplete="off">
                            <div class="alert-errors" role="alert" id="routeErrorIns"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Nhóm quyền <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                        {{ Form::select('group', ['1' => 'Giao diện người dùng', '2' => 'dịch vụ', '8' => 'Đơn hàng', '3' => 'Khách hàng', '4' => 'Bài viết', '5' => 'Tài khoản quản trị', '6' => 'Page', '7' => 'Liên hệ'], null, ['class' => 'form-control', 'placeholder' => '--Chọn nhóm--']) }}
                            <div class="alert-errors" role="alert" id="groupErrorIns"></div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="createPermission">Thêm mới</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

<script>
    var dataTable               = null;
    var permissionCheckList     = [];
    var curr_permission_name    = '';
    var curr_permission_group   = '';
    var current_page            = 0;
    var old_search              = '';
    var errorConnect            = "Please check your internet connection and try again.";

    $(document).ready(function(){

        $( "#search_txt" ).autocomplete({
            source: function( request, response ) {
                if(request.term.trim().length > 0){
                    $.ajax( {
                        url: "{{ url('/') }}/admincp/permissions/suggest",
                        dataType: "json",
                        data: {
                            text: request.term
                        },
                        success: function( data ) {
                            response(data);
                        }
                    });
                }
            },
            minLength: 1
        } );

        window.onbeforeunload = function() {
            if($('#edit_permission_modal').hasClass('show') && (
                $('#permissionName_upd').val() != curr_permission_name ||
                $('#permissionGroup_upd').val() != curr_permission_group
                )){
                return "Bye now!";
            }
        };

        document.onkeydown=function(evt){
          var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
          if(keyCode == 13)
          {
            $('#search-btn').click();
          }
        }
        
        var dataObject = [
            /*{ 
                data: "all",
                class: "all-permission",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" id="permission-'+ data +'" class="check-permission" value="'+ data +'" data-column="'+ data +'">';
                },
                orderable: false
            },*/
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-permission" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "name",
                class: "name-field"
            },
            { 
                data: "route",
                class: "route-field"
            },
            { 
                data: "group",
                class: "route-field",
                render: function(data, type, row){
                    if(data == 1){
                        return 'Giao diện người dùng';
                    }else if(data == 2){
                        return 'dịch vụ';
                    }else if(data == 3){
                        return 'Khách hàng';
                    }else if(data == 4){
                        return 'Bài viết';
                    }else if(data == 5){
                        return 'Tài khoản quản trị';
                    }else if(data == 6){
                        return 'Page';
                    }else if(data == 7){
                        return 'Liên hệ';
                    }else if(data == 8){
                        return 'Đơn hàng';
                    }
                    return '';
                },
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    return '<a class="btn-edit mr-2 edit-permission" data-id="'+data+'" data-name="'+row.name+'" data-route="'+row.route+'" data-group="'+row.group+'" title="Sửa"> <i class="fa fa-edit"></i></a> <a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                },
                orderable: false
            },
        ];

        dataTable = $('#permission-table').DataTable( {
                        serverSide: true,
                        aaSorting: [],
                        stateSave: false,
                        ajax: "{{ url('/') }}/admincp/permissions/getDataAjax",
                        columns: dataObject,
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
                        }
                    });

        // $('#permission-table').on( 'page.dt', function () {
        //     $('html,body').animate({
        //         scrollTop: $("#permission-table").offset().top},
        //         'slow');
        // } );

        $('#permission-table').css('width', '100%');

        dataTable.search('').draw();

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#permission-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#permission-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#permission-table tbody input[type="checkbox"]:checked').length == $('#permission-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            permissionCheckList = [];
            $.each($('.check-permission'), function( index, value ) {
                if($(this).prop('checked')){
                    permissionCheckList.push($(this).val());
                }
            });
            // console.log(permissionCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(permissionCheckList);
            var count_row = 0;
            var listUser = $('.check-permission');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), permissionCheckList)){
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
            $('.edit-permission').off('click');
            $('.edit-permission').click(function(){
                $('.alert-danger').hide();
                var id      = $(this).attr('data-id');
                curr_permission_name    = $(this).attr('data-name');
                curr_permission_group   = $(this).attr('data-group');

                $('#edit_permission_modal').modal('show');

                $('#permissionID_upd').val(id);
                $('#permissionName_upd').val(curr_permission_name);
                $('#permissionGroup_upd').val(curr_permission_group);
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
                            url: baseURL + "/admincp/permissions/" + id,
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
            if ($('#permission-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#savePermission').click(function( ) {
            var data    = {
                name                : $('#permissionName_upd').val(),
                group               : $('#permissionGroup_upd').val(),
                _method             : "PUT"
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL+"/admincp/permissions/" + $('#permissionID_upd').val(),
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-danger').hide();
                    current_page = dataTable.page.info().page;
                },
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        dataTable.page(current_page).draw(false);
                        $('#edit_permission_modal').modal('toggle');
                        $().toastmessage('showSuccessToast', response.Message);
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#permission_'+index+'ErrorUpd').html(value);
                            $('#permission_'+index+'ErrorUpd').show();
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
                    $.each($('.check-permission'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });

                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-permission'), function (key, value){
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
                                url: "{{ url('/') }}/admincp/permissions/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-permission'), function (key, value){
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

        var errorConnect = "Please check your internet connection and try again.";

        $('#createPermission').click(function(){
            var data    = {
                name             : $('.permissionNameIns').val().replace(/\s\s+/g, ' '),
                route            : $('.routeNameIns').val().replace(/\s\s+/g, ' '),
                group            : $('select[name="group"]').val()
            };

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: baseURL + "/admincp/permissions",
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-danger').hide();
                },
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        clearFormCreate();
                        $('#add_permission_modal').modal('toggle');
                        $().toastmessage('showSuccessToast', response.Message);
                        dataTable.ajax.reload(); 
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#'+index+'ErrorIns').html(value);
                            $('#'+index+'ErrorIns').show();
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

        function clearFormCreate(){
            $('.permissionNameIns').val('')
            $('.routeNameIns').val('')
            $('select[name=group]').val('')
            $('.alert-danger').hide();
        }


        $('#add_permission_modal').on('hidden.bs.modal', function () {
            clearFormCreate();
        })

    });
</script>

<style>
    input[type=checkbox]{
        cursor: pointer;
    }
    .action-field>span,
    .fa-plus-circle{
        cursor: pointer;
    }
</style>
@endsection