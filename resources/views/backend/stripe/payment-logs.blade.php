@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    <h1 class="text-center font-weight-600">Lịch sử giao dịch Stripe</h1>
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
                <table class="table table-bordered" id="payment-logs-table">
                    <thead class="thead-custom">
                        <tr>
                            <!-- <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th> -->
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Billing email</th>
                            <th scope="col">Discount (%)</th>
                            <th scope="col">Thao tác (discount)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <!-- <p class="action-selected-rows">
                    <span >Hành động trên các hàng đã chọn:</span>
                    <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span>
                </!-->
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
    
    $(document).ready(function() {
    
    var dataObject = [
        {
            data: "name",
        },
        {
            data: "email",
        },
        {
            data: "billing_email",
        },
        {
            data: "discount",
        },
        { 
            data: "action", 
            class: "text-center",
            render: function(data, type, row){
                var html = '';
                html += '<a href="' + baseURL + '/admincp/payment-logs/'+ data +'/edit" class="btn-edit mr-2 edit-user" title="Sửa"><i class="fa fa-edit"></i></a>';
                // html += '<a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#payment-logs-table').DataTable({
        serverSide: false,
        search: {
            smart: false
        },
        aaSorting: [],
        stateSave: true,
        ajax:{
            url: baseURL + "/admincp/payment-logs-ajax"
        }, 
        columns: dataObject,
        bLengthChange: true,
        pageLength: 10,
        order: [[ 0, "DESC" ]],
        colReorder: {
            fixedColumnsRight: 1,
            fixedColumnsLeft: 1
        },
        oLanguage: {
            sSearch: "Tìm kiếm",
            sLengthMenu: "Hiển thị _MENU_ bản ghi",
            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
            sInfoFiltered: "",
            sInfoEmpty: "",
            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
            sEmptyTable: "Chưa có phản hồi",
            oPaginate: {
                sPrevious: "Trang trước",
                sNext: "Trang sau",

            },
        },
        fnDrawCallback: function( oSettings ) {
            addEventListener();
        },
    });
    $('#payment-logs-table').css('width', '100%');

    function addEventListener(){
    }

});
</script>
@endsection