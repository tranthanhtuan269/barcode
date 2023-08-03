@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<!-- Include the plugin's CSS and JS: -->
<script src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css"/>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    #role-table .btn-edit{
        padding: 0px 10px;
        cursor: pointer;
    }
</style>

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách vai trò</h1>
    <div class="add-item text-center">
        <a id="create_role" data-toggle="modal" data-target="#add_role_modal" class="btn btn-success btn-sm" title="Thêm vai trò"> <i class="fa fa-plus"></i> Thêm vai trò</a>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="role-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên</th>
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
        </div>
    </div>
    <div id="edit_role_modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">Chỉnh sửa vai trò</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <label for="roleName_upd" class="col-sm-4 col-form-label">Tên vai trò <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="hidden" id="roleID_upd" value="">
                    <input type="text" class="form-control" id="roleName_upd">
                    <div class="alert-errors" role="alert" id="roleNameErrorUpd"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="roleName_upd" class="col-sm-4 col-form-label">Danh sách quyền <span class="text-danger">*</span></label>
                <div class="col-sm-8" id="permistion-group">
                    <select id="permission-list" multiple="multiple">
                        <?php 
                            $UPermissions = App\Permission::where('group', 1)->get();
                        ?>
                        @foreach($UPermissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveRole">Cập nhật</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
          </div>
        </div>
      </div>
    </div>

    <div id="add_role_modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">Thêm vai trò</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <label for="roleName_ins" class="col-sm-4 col-form-label">Tên vai trò <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="roleName_ins" >
                    <div class="alert-errors" role="alert" id="nameErrorIns">
                      
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Danh sách quyền <span class="text-danger">*</span></label>
                <div class="col-sm-8" id="permistion-group">
                    <select id="permission-list-ins" multiple="multiple">
                        <?php 
                            $permissions = App\Permission::select('id', 'name', 'group')->orderby('group', 'asc')->get();
                            $group = 1;
                        ?>
                 
                        <optgroup label="Giao diện người dùng" class="group-1">
                            @foreach ($permissions as $p)
                                @if($p->group != $group)
                                    </optgroup>
                                    @if($p->group == 2)
                                    <optgroup label="dịch vụ" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 3)
                                    <optgroup label="Khách hàng" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 4)
                                    <optgroup label="Bài viết" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 5)
                                    <optgroup label="Tài khoản quản trị" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 6)
                                    <optgroup label="Liên hệ" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 7)
                                    <optgroup label="Page" class="group-{{ $p->id }}">
                                    @endif
                                    @if($p->group == 8)
                                    <optgroup label="Đơn hàng" class="group-{{ $p->id }}">
                                    @endif
                                    <?php $group = $p->group; ?>
                                @endif
                                <option value="{{ $p->id }}" class="group-{{ $p->group }}">{{ $p->name }}</option>
                            @endforeach
                        </optgroup>
                
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="create-role-btn">Thêm mới</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
          </div>
        </div>
      </div>
    </div>

    <div id="list_role_modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">List Role By </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-12 show-role"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
    var dataTable               = null;
    var roleCheckList           = [];
    var curr_role_name          = '';
    var curr_permission_list    = '';
    var current_page            = 0;
    var old_search              = '';
    var errorConnect            = "Please check your internet connection and try again.";
    
    $(document).ready(function(){

        function clearFormCreate(){
            $('#roleName_ins').val('')
            $('input[type=checkbox]').prop('checked',false); 
            $('.multiselect-selected-text').html('None selected');
            $('.alert-danger').hide();
        }

        $('#add_role_modal').on('hidden.bs.modal', function () {
            clearFormCreate();
        })

        $('#create-role-btn').click(function(){
            var name = $('#roleName_ins').val();
            name = name.replace(/\s\s+/g, ' ');
            var data    = {
                name                : name,
                permission          : $('#permission-list-ins').val().toString() + ',',
                _method             : "POST"
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL+"/admincp/roles",
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
                        $('#add_role_modal').modal('toggle');
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

        $('#permission-list-ins').multiselect({
            includeSelectAllOption: true,
            includeSelectAllIfMoreThan: 0,
            numberDisplayed: 2,
            enableClickableOptGroups: true
        });


        window.onbeforeunload = function() {
            new_permission_list    = $('#permission-list').val().toString() + ',';

            if($('#edit_role_modal').hasClass('show') && ( 
                $('#roleName_upd').val() != curr_role_name ||
                new_permission_list != curr_permission_list)
                ){
                return "Bye now!";
            }
        };

        $(document).on('click', '.info-role', function(e) {
            var _self = this;
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            $.ajax({
                method : "GET",
                url: baseURL + "/admincp/roles/"+id+"/listpermission",
                success: function(response) {
                    var obj = $.parseJSON(response);
                    if(obj.Response=='Error')
                    {
                        alert('Error');
                    }else{
                        $('#list_role_modal .modal-title').html('Tên: ' + name);
                        var text = (obj.result).length > 0 ? '<div style="margin-bottom:5px;"><b>Danh sách vai trò: </b></div> ' : 'Không tồn tại vai trò';
                        list_languages = obj.result.split(",");
                        var result_final = '';

                        if (list_languages.length > 1) {
                            result_final = '<table class="table table-bordered">'

                            $.each(list_languages, function( index, value ) {

                                  if ( index = 0 || index % 4 ==0 ) {
                                    result_final += '<tr>';
                                  }

                                  result_final += '<td>' + value + '</td>';

                                  if ( (index+1)%4 ==0 ) {
                                    result_final += '</tr>';
                                  }

                            });

                            result_final += '</table>'
                        }

                        $('#list_role_modal .modal-body .show-role').html(text + result_final);
                        $('#list_role_modal').modal('show');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
           
        });

        var dataObject = [
            // { 
            //     data: "all",
            //     class: "all-role",
            //     render: function(data, type, row){
            //         return '<input type="checkbox" name="selectCol" id="role-'+ data +'" class="check-role" value="'+ data +'" data-column="'+ data +'">';
            //     },
            //     orderable: false
            // },
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-role" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "name",
                class: "name-field"
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    return '<span class="info-role mr-2" data-id="'+data+'" data-name="'+row.name+'" title="Thông tin chi tiết"><i class="fa fa-info-circle"></i></span><span class="mr-2 btn-edit" data-id="'+data+'" data-name="'+row.name+'" title="Sửa"><i class="fa fa-edit"></i></a></span><span class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></span>';
                },
                orderable: false
            },
        ];

        dataTable = $('#role-table').DataTable( {
                        serverSide: true,
                        aaSorting: [],
                        stateSave: false,
                        ajax: "{{ url('/') }}/admincp/roles/getDataAjax",
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 25,
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

        // $('#role-table').on( 'page.dt', function () {
        //     $('html,body').animate({
        //         scrollTop: $("#role-table").offset().top},
        //         'slow');
        // } );
        
        $('#role-table').css('width', '100%');

        dataTable.search('').draw();

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#role-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#role-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#role-table tbody input[type="checkbox"]:checked').length == $('#role-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            roleCheckList = [];
            $.each($('.check-role'), function( index, value ) {
                if($(this).prop('checked')){
                    roleCheckList.push($(this).val());
                }
            });
            // console.log(roleCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(roleCheckList);
            var count_row = 0;
            var listUser = $('.check-role');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), roleCheckList)){
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

        function getRoleList($id){
            var id      = $id;
            $.ajax({
                url: baseURL+"/admincp/roles/getInfoByID/" + id,
                method: "GET",
                dataType:'html',
                success: function (response) {
                    $("#permistion-group").html('<select id="permission-list" multiple="multiple"></select>');
                    $("#permission-list").html(response);
                    $('#permission-list').multiselect({
                        includeSelectAllOption: true,
                        includeSelectAllIfMoreThan: 0,
                        numberDisplayed: 2,
                        enableClickableOptGroups: true
                    });

                    $('#edit_role_modal').modal('show');
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

        function addEventListener(){
            $('.btn-edit').off('click');
            $('.btn-edit').click(function(){
                $('.alert-danger').hide();
                var id      = $(this).attr('data-id');

                getRoleList(id);

                curr_role_name          = $(this).attr('data-name');
                curr_permission_list    = $('#permission-list').val().toString() + ',';

                $('#roleID_upd').val(id);
                $('#roleName_upd').val(curr_role_name);
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
                            url: baseURL+"/admincp/roles/" + id,
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
            if ($('#role-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#saveRole').click(function(){

            var name = $('#roleName_upd').val();
            name = name.replace(/\s\s+/g, ' ');
            var data    = {
                name                : name,
                permission          : $('#permission-list').val().toString() + ',',
                _method             : "PUT"
            };
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL+"/admincp/roles/" + $('#roleID_upd').val(),
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').hide();
                    current_page = dataTable.page.info().page;
                },
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                      dataTable.page(current_page).draw(false);
                      $('#edit_role_modal').modal('toggle');
                        $().toastmessage('showSuccessToast', response.Message);
                    }else{
                        $('#roleNameErrorUpd').html(response.Message);
                        $('#roleNameErrorUpd').show();
                      // $().toastmessage('showErrorToast', response.Message);
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#roleNameErrorUpd').html(value);
                            $('#roleNameErrorUpd').show();
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
                    $.each($('.check-role'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });

                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-role'), function (key, value){
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
                                url: "{{ url('/') }}/backend/admincp/roles/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-role'), function (key, value){
                                            if($(this).prop('checked') == true) {
                                                $(this).parent().parent().hide("slow");
                                            }
                                        });
                                        $().toastmessage('showSuccessToast', obj.Message);
                                        dataTable.ajax.reload(); 
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