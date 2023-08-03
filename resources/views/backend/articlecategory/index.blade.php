@extends('backend.master')
@section('title', 'Danh mục')
@section('content')
    <section class="content-header">
        <h1 class="text-center font-weight-600">Quản lý danh mục bài viết <a href="{{ url('/') }}/admincp/articlecategories/create" class="btn btn-success btn-sm" title="Thêm mới danh mục bài viết">Thêm mới</a></h1>
        <div class="add-item text-center">
            
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                {{-- <div class="form-group">
                    <label>Ngôn ngữ: </label>
                    <select name="language">
                        <option value="en" @if (Request::get('language') == 'en') selected @endif>English</option>
                        <option value="vi" @if (Request::get('language') == 'vi') selected @endif>Vietnammese</option>
                    </select>
                    <script>
                        jQuery("select[name=language]").change(function () {
                            location.href = '{{ url("/admincp/articlecategories") }}?language=' + jQuery(this).val();
                        })  
                    </script>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="group-table">
                        <thead class="thead-custom">
                            <tr class="filters">
                                <th scope="col">Danh mục <input type="search" class="u-outline" placeholder="Tìm kiếm..." onkeyup="searchFormJs()" id="search-form-js"></th>
                                <th scope="col" class="text-center">Slug</th>
                                <th scope="col" class="text-center">
                                    <img src="{{ asset('backend/images/en.png') }}" title="English">
                                    <img src="{{ asset('backend/images/vi.png') }}" title="Tiếng Việt">
                                </th>
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
                        type: "post",
                        url: baseURL + "/admincp/articlecategories/" + id,
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
                            } else {
                                Swal.fire({
                                    type: 'warning',
                                    html: response.message,
                                })
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
