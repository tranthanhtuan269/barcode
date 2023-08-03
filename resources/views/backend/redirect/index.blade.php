@extends('backend.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách Link Redirect 301</h1>
    <div class="add-item text-center">
         <button data-toggle="modal" data-target="#myModalAdd"  class="btn btn-success btn-sm" title="Thêm mới"><i class="fa fa-plus"></i> Thêm mới</button>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="redirect-table">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Link cũ</th>
                            <th scope="col">Link mới</th>
                            <th style="width:10%"></th>
                            <!-- <th scope="col">Thao tác</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($redirects as $value)
                        <tr>
                            <td>{{$value->link_old}}</td>
                            <td>{{$value->link_new}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm act-edit mr-5" data-id="{{$value->id}}" data-link_old="{{$value->link_old}}" data-link_new="{{$value->link_new}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
                                <button type="button" class="btn btn-danger btn-sm act-delete" title="Xóa" data-id="{{$value->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 text-center">
            {{ $redirects->appends(Request::all())->links() }}
        </div>
    </div>
</section>
<div id="myModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Link Redirect</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Link cũ</label>
                <input name="link_old" class="form-control" placeholder="Link cũ">
                <div class="alert alert-link_old" role="alert"></div>
            </div>
            <div class="form-group">
                <label for="">Link mới</label>
                <input name="link_new" class="form-control" placeholder="Link mới">
                <div class="alert alert-link_new" role="alert"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveAdd">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
<div id="myModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Link Redirect</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Link cũ</label>
                <input name="link_old" class="form-control" placeholder="Link cũ">
                <div class="alert alert-link_old" role="alert"></div>
            </div>
            <div class="form-group">
                <label for="">Link mới</label>
                <input name="link_new" class="form-control" placeholder="Link mới">
                <div class="alert alert-link_new" role="alert"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveEdit">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
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
        $('#redirect-table').css('width', '100%');

      
        
        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#redirect-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#redirect-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#redirect-table tbody input[type="checkbox"]:checked').length == $('#redirect-table tbody input[type="checkbox"]').length ){
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
            $('.act-edit').off('click');
            $('.act-edit').click(function(){
                $('#myModalEdit').modal('show');
                redirect_id_edit         = $(this).attr('data-id');
                link_old            = $(this).attr('data-link_old');
                link_new            = $(this).attr('data-link_new');
                $('#myModalEdit input[name=link_old').val(link_old);
                $('#myModalEdit input[name=link_new').val(link_new);
            });

            $('.act-delete').off('click');
            $('.act-delete').click(function(){
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
                            url: baseURL+"/admincp/redirects/" + id,
                            data: data,
                            method: "POST",
                            dataType:'json',
                            beforeSend: function(r, a){

                            },
                            success: function (response) {
                                if(response.status == 200){
                                  $().toastmessage('showSuccessToast', 'Xóa redirect thành công!');
                                  window.location.reload()
                                }else{
                                  $().toastmessage('showErrorToast', 'Xóa redirect không thành công!');
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

        $('#myModalEdit, #myModalAdd').on('hidden.bs.modal', function () {
            $('.alert').removeClass('alert-error').html('');
        })

        $('#saveAdd').click(function(){
            var data    = {
                link_old          : $('#myModalAdd input[name=link_old]').val().trim(),
                link_new          : $('#myModalAdd input[name=link_new]').val().trim(),
                _method             : "POST",
                _token : $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                url: baseURL+"/admincp/redirects",
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    
                },
                success: function (response) {
                    if(response.status == 200){ 
                        $().toastmessage('showSuccessToast', 'Thêm mới thành công!');
                        $('#myModalAdd').modal('hide');
                        window.location.reload()
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('.alert-' + index).addClass('alert-error').html(value);
                        });
                    }
                }
            });
        });

        $('#saveEdit').click(function(){
            var data    = {
                link_old          : $('#myModalEdit input[name=link_old]').val().trim(),
                link_new          : $('#myModalEdit input[name=link_new]').val().trim(),
                _method             : "PUT",
                _token : $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                url: baseURL+"/admincp/redirects/" +redirect_id_edit,
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert').removeClass('alert-error').html('');
                },
                success: function (response) {
                    if(response.status == 200){ 
                        $().toastmessage('showSuccessToast', 'Cập nhật thành công!');
                        $('#myModalEdit').modal('hide');
                        window.location.reload()
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('.alert-' + index).addClass('alert-error').html(value);
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

        function checkEmptyTable(){
            if ($('#redirect-table').DataTable().data().count() <= 1 && current_page > 0) {
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
                                url: "{{ url('/') }}/admincp/redirects/delMulti",
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