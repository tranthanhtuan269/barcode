@extends('backend.master')

@section('content')
    <section class="content-header">
        <h1 class="text-center font-weight-600">Quản lý danh mục</h1>
        <div class="add-item text-center">
            <a href="{{ url('/') }}/admincp/postcategories/create" class="btn btn-success btn-sm" title="Thêm mới danh mục bài viết"><i class="fa fa-plus"></i> Thêm mới</a>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="group-table">
                        <thead class="thead-custom">
                            <tr class="filters">
                                <th scope="col">Danh mục <input type="search" class="u-outline" placeholder="Tìm kiếm..." onkeyup="searchFormJs()" id="search-form-js"></th>
                                <th scope="col" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($listCategoriesAction))
                                {!! $listCategoriesAction !!}
                            @endif
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </section>
    <script>
        function deleteCategory(id) {
            $.ajsrConfirm({
                message: "Bạn có chắc chắn muốn xóa ?",
                okButton: "Đồng ý",
                onConfirm: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var data = {
                        _method:'delete',
                    };
                    
                    $.ajax({
                        type: "POST",
                        url: baseURL + "/admincp/postcategories/" + id,
                        data: data,
                        success: function (response) {
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
                            alert('error')
                        }
                    });
                }   
            });
        }
    </script>
@endsection
