@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách liên hệ</h1>
<!--     <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Charts</a></li>
        <li class="active">Inline Charts</li>
    </ol> -->
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="contact-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            {{-- <th scope="col">Phone</th> --}}
                            <th scope="col">Nội dung</th>
                            <th scope="col">Ngày gửi</th>
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
                data: "username",
                class: "username-field"
            },
            { 
                data: "email",
                class: "email-field"
            },
            // { 
            //     data: "phone",
            //     class: "phone-field"
            // },
            { 
                data: "comment",
                class: "comment-field"
            },
            { 
                data: "created_at",
                class: "created_at text-center"
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    return '<span class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></span>';
                },
                orderable: false
            },
        ];

        dataTable = $('#contact-table').DataTable( {
                        serverSide: true,
                        aaSorting: [],
                        stateSave: false,
                        ajax: "{{ url('/') }}/admincp/contacts/getDataAjax",
                        columns: dataObject,
                        order: [[ 4, "desc" ]],
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
                        createdRow: function(row, data, dataIndex) {
                            var $dateCell_created_at = $(row).find('td.created_at');
                            var dateOrder_created_at = $dateCell_created_at.text(); 
                            $dateCell_created_at.data('order', dateOrder_created_at).text(moment(dateOrder_created_at).format('DD/MM/Y')); 
                        },
                        fnServerParams: function ( aoData ) {
                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            checkCheckboxChecked();
                        }
                    });

        // $('#contact-table').on( 'page.dt', function () {
        //     $('html,body').animate({
        //         scrollTop: $("#contact-table").offset().top},
        //         'slow');
        // } );
        
        $('#contact-table').css('width', '100%');

        dataTable.search('').draw();

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#contact-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '#contact-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#contact-table tbody input[type="checkbox"]:checked').length == $('#contact-table tbody input[type="checkbox"]').length ){
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
                            url: baseURL+"/admincp/contacts/" + id,
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
            if ($('#contact-table').DataTable().data().count() <= 1 && current_page > 0) {
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
                                url: "{{ url('/') }}/admincp/contacts/delMulti",
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