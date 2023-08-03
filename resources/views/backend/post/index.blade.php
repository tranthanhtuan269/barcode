@extends('backend.master')
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
        Danh sách bài viết
        <a href="{{ url('/admincp/posts/create') }}" class="btn btn-success btn-sm" title="Thêm mới bài viết">
        Thêm mới
        </a>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-2 form-group">
                    <label>Từ ngày: </label>
                    <input class="form-control" type="text" id="datepicker_from" autocomplete="off"/>
                </div>
                <div class="col-sm-2 form-group">
                    <label>Đến ngày: </label>
                    <input class="form-control" type="text" id="datepicker_to" autocomplete="off"/>
                </div>
                <div class="col-sm-3 form-group">
                    <label>Danh mục: </label>
                    <select name="cat_id" class="form-control select2 wrap">
                        <option value="" class="font-weight-600">--Tất cả--</option>
                        @if ($categories)
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-3 form-group">
                    <label>Từ khóa: </label>
                    <input class="form-control" type="text" name="keyword">
                </div>
                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-primary btn-sm" style="margin-top:26px" id="search">Tìm kiếm</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="post-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th>Danh mục</th>
                            <th>Tiêu đề</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th width="8%">Thao tác</th>
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
    var $select2 = $('.select2').select2({
        containerCssClass: "wrap",
        width: '100%',
    })
    
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";
    
    $(document).ready(function(){
    
        var dataObject = [
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-post" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "cat_name",
                name: "post_categories.title",
            },
            { 
                data: "title",
            },

            { 
                data: "created_at",
                class: "created_at text-center"
            },
            { 
                data: "updated_at",
                class: "updated_at text-center"
            },
            { 
                data: "action", 
                class: "text-center",
                render: function(data, type, row){
                    var html = '';
                    html += '<a href="' + baseURL + '/admincp/posts/'+ data +'/edit" class="btn-edit mr-2" title="Sửa"><i class="fa fa-edit"></i></a>';
                    html += '<a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return html;
                },
                orderable: false
            },
        ];
    
        dataTable = $('#post-table').DataTable( {
                        serverSide: true,
                        responsive: true,
                        aaSorting: [],
                        stateSave: false,
                        searching: false,
                        ajax:{
                            url: "{{ url('/') }}/admincp/posts/getDataAjax",
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            },
                            complete: function() {
                                $(".ajax_waiting").removeClass("loading");
                            }
                        }, 

                        columns: dataObject,
                        order: [[ 3, "desc" ]],
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
    
                        createdRow: function(row, data, dataIndex) {
                            var $dateCell = $(row).find('td.created_at');
                            var dateOrder = $dateCell.text(); 
                            $dateCell.data('order', dateOrder).text(moment(dateOrder).format('DD/MM/Y')); 

                            var $dateCell = $(row).find('td.updated_at');
                            var dateOrder = $dateCell.text(); 
                            $dateCell.data('order', dateOrder).text(moment(dateOrder).format('DD/MM/Y')); 
                        },
    
                        initComplete: function () {
                        },
    
                        fnServerParams: function ( aoData ) {
                            aoData.cat_id = $('select[name=cat_id]').val();
                            aoData.keyword = $('input[name=keyword]').val();
                            aoData.datepicker_from = $('#datepicker_from').val();
                            aoData.datepicker_to = $('#datepicker_to').val();
                        },
    
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            checkCheckboxChecked();
                        },
                    });
    
        $('#post-table').css('width', '100%');
    
        $("#datepicker_from").datepicker({
            dateFormat: 'dd/mm/yy',
        })
        
        $("#datepicker_to").datepicker({
            dateFormat: 'dd/mm/yy',
        })

        $("#search").click(function(){
            var datepicker_from = $('#datepicker_from').val();
            var datepicker_to = $('#datepicker_to').val();

            if (datepicker_from != '') {
                if (!validationDate(datepicker_from)) {
                    Swal.fire({
                        type: 'warning',
                        text: 'Xin vui lòng nhập thời gian hợp lệ! ?',
                    });
                    return;
                }
            }

            if (datepicker_to != '') {
                if (!validationDate(datepicker_to)) {
                    Swal.fire({
                        type: 'warning',
                        text: 'Xin vui lòng nhập thời gian hợp lệ! ?',
                    });
                    return;
                } else {
                    if (datepicker_from != '') {
                        job_start_date = datepicker_from.split('/');
                        job_end_date = datepicker_to.split('/');

                        var new_start_date = new Date(job_start_date[2],job_start_date[1],job_start_date[0]);
                        var new_end_date = new Date(job_end_date[2],job_end_date[1],job_end_date[0]);

                        if(new Date(new_start_date) > new Date(new_end_date))
                        {
                            Swal.fire({
                                type: 'warning',
                                text: 'Khoảng thời gian nhập từ ngày - đến ngày không hợp lệ!',
                            });

                            return;
                        }
                    }
                }
            }

            dataTable.draw();
        });

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#post-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });
    
        $('body').on('click', '#post-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#post-table tbody input[type="checkbox"]:checked').length == $('#post-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }
    
            // save localstore
            setCheckboxChecked();
        });
    
        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-post'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }
    
        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-post');
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
            if ($('#post-table').DataTable().data().count() <= 1 && current_page > 0) {
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
                    $.each($('.check-post'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });
    
                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-post'), function (key, value){
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
                                url: "{{ url('/') }}/admincp/posts/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-post'), function (key, value){
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
                            url: baseURL+"/admincp/posts/" + id,
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
                                  $().toastmessage('showSuccessToast', response.message);
                                }else{
                                  $().toastmessage('showErrorToast', response.message);
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
    
        $("form#data").submit(function(e) {
            e.preventDefault();    
            var ext = $('input[type=file]').val().split('.').pop().toLowerCase();
    
            if(jQuery.inArray(ext, ['xls', 'xlsx', 'csv']) === -1) {
                Swal.fire({
                    type: 'warning',
                    html: 'Xin vui lòng nhập file hợp lệ!',
                })
               return;
            }
    
            var formData = new FormData(this);
    
            $.ajaxSetup(
            {
                headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                url: "{{ route('posts.import') }}",
                type: 'POST',
                data: formData,
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: response.message,
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function (data) {
                    var tmp = 0;
    
                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
    
                        if (tmp == 0) {
                            $('.alert-' + index).attr("tabindex",-1).focus();
                        }
    
                        tmp++;
                    });
                        
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>
@endsection