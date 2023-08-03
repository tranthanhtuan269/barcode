@extends('backend.master')

@section('content')
<script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
<section class="content-header">
    <h1 class="text-center font-weight-600">Tuỳ chọn giao diện</h1>
</section>
<section class="content setting-ganenal">
    <div class="row">
        <div class="col-sm-10"></div>
        <div class="col-sm-2">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <label>
                                Ngôn ngữ:
                            </label>
                            <div class="translation-column">
                                <select name="language_id" class="form-control">
                                        <option value="en" selected>English</option>
                                        <option value="vi">Vietnamese</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-3">
            <ul class="nav nav-tabs tab-in-left">
                <li class="nav-item active">
                    <a href="#tab-home" class="nav-link" data-toggle="tab"><i class="fa fa-home"></i>  Chung</a>
                </li>
                <li class="nav-item">
                    <a href="#tab-seo" class="nav-link " data-toggle="tab"><i class="fa fa-star"></i> SEO</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="tab-content tab-content-in-right">
                <div class="tab-pane active" id="tab-home">
                    <div class="form-group">
                        <label class="font-weight-bold">Logo</label>
                        <div class="text-center">
                            <img id="filemanager-image" src="{{ asset('filemanager/data-images/'.$data_general['logo']) }}">
                            <p class="alert-logo alert-errors"></p>
                            <button type="button" class="btn btn-xs btn-primary text-center" data-toggle="modal" href="javascript:;" data-target="#myModalFilemanager">Chọn ảnh</button>
                            <script>
                                function responsive_filemanager_callback(field_id){
                                    var url=jQuery('#'+field_id).val();
                                    $('#'+field_id).attr('src', url);
                                    // $('#filemanager-image').attr('src', url);
                                }
                            </script>
                            <div class="modal fade" id="myModalFilemanager">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Thư viện media</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe width="100%" height="450px" src="{{asset('filemanager/dialog.php')}}?type=22&field_id=filemanager-image" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <input name="email" type="text" class="form-control" value="{{ isset($data_general['email']) ? $data_general['email'] : '' }}"> 
                        <p class="alert-email alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email Comment ( Thêm nhiều email cách nhau bởi dấu phẩy )</label>
                        <input name="email_comment" type="text" class="form-control" value="{{ isset($data_general['email_comment']) ? $data_general['email_comment'] : '' }}"> 
                        <p class="alert-email alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Từ Tục tĩu ( Thêm nhiều Từ Tục tĩu cách nhau bởi dấu phẩy )</label>
                        <textarea name="keywords_not_good" class="form-control" rows="3" cols="40" placeholder="Từ Tục tĩu">{{ isset($data_general['keywords_not_good']) ? $data_general['keywords_not_good'] : '' }}</textarea>
                        <p class="alert-keywords_not_good alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="{{ isset($data_general['facebook']) ? $data_general['facebook'] : '' }}">
                        <p class="alert-facebook alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="{{ isset($data_general['twitter']) ? $data_general['twitter'] : '' }}">
                        <p class="alert-twitter alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Youtube</label>
                        <input type="text" class="form-control" name="youtube" value="{{ isset($data_general['youtube']) ? $data_general['youtube'] : '' }}">
                        <p class="alert-youtube alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="{{ isset($data_general['instagram']) ? $data_general['instagram'] : '' }}">
                        <p class="alert-instagram alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">LinkedIn</label>
                        <input type="text" class="form-control" name="linkedIn" value="{{ isset($data_general['linkedIn']) ? $data_general['linkedIn'] : '' }}">
                        <p class="alert-linkedIn alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Pinterest</label>
                        <input type="text" class="form-control" name="pinterest" value="{{ isset($data_general['pinterest']) ? $data_general['pinterest'] : '' }}">
                        <p class="alert-pinterest alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Copyright text</label>
                        <input rows="4" cols="50" type="text" class="form-control" name="copyright_text" value="{{ isset($data_general['copyright_text']) ? $data_general['copyright_text'] : '' }}">
                        <p class="alert-copyright_text alert-errors"></p>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">App ios</label>
                        <input rows="4" cols="50" type="text" class="form-control" name="apple_store_link" value="{{ isset($data_general['apple_store_link']) ? $data_general['apple_store_link'] : '' }}">
                        <p class="alert-apple_store_link alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">App androids</label>
                        <input rows="4" cols="50" type="text" class="form-control" name="google_play_link" value="{{ isset($data_general['google_play_link']) ? $data_general['google_play_link'] : '' }}">
                        <p class="alert-google_play_link alert-errors"></p>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <div id="save-btn-tab-home" class="btn btn-primary">Lưu lại</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-seo">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="font-weight-bold">Từ khóa (SEO)</label>
                            <textarea name="keywords" class="form-control" rows="3" cols="40" placeholder="Từ khóa (SEO)">{{ isset($data['keywords']) ? $data['keywords'] : '' }}</textarea>
                            <p class="alert-keywords alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề web (SEO)</label>
                            <textarea name="seo_title" class="form-control" rows="3" cols="40"  placeholder="Từ khóa (SEO)">{{ isset($data['seo_title']) ? $data['seo_title'] : '' }}</textarea>
                            <p class="alert-seo_title alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Mô tả web (SEO)</label>
                            <textarea name="seo_description" class="form-control" rows="3" cols="40" placeholder="Từ khóa (SEO)">{{ isset($data['seo_description']) ? $data['seo_description'] : '' }}</textarea>
                            <p class="alert-seo_description alert-errors"></p>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <div id="save-btn-tab-seo" class="btn btn-primary">Lưu lại</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){

        $('select[name=language_id]').change(function(){
            var language_id = this.value;
            var data    = {
                _method           : "GET",
                language_id : language_id,
            };

            $.ajax({
                type: "POST",
                url: "{{ route('config.info-config-by-lang') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function(response) {
                    $(".ajax_waiting").removeClass("loading");
                    var data = response.responseJSON.data;
                    var data_general = response.responseJSON.data_general;
                    
                    if (!jQuery.isEmptyObject(data)) {
                        $('textarea[name=keywords]').val(data.keywords);
                        $('textarea[name=seo_title]').val(data.seo_title);
                        $('textarea[name=seo_description]').val(data.seo_description);
                    } else {
                        $('input[type="text"]').val('');
                        $('textarea').val('');
                    }

                    if (!jQuery.isEmptyObject(data_general)) {
                        $('input[name=email]').val(data_general.email);
                        $('input[name=email_comment]').val(data_general.email_comment);
                        $('textarea[name=keywords_not_good]').val(data_general.keywords_not_good);
                        $('textarea[name=facebook]').val(data_general.facebook);
                        $('input[name=youtube]').val(data_general.youtube);
                        $('input[name=instagram]').val(data_general.instagram);
                        $('input[name=twitter]').val(data_general.twitter);
                        $('input[name=pinterest]').val(data_general.pinterest);
                        $('input[name=linkedIn]').val(data_general.linkedIn);
                        $('input[name=copyright_text]').val(data_general.copyright_text);
                        $('input[name=apple_store_link]').val(data_general.apple_store_link);
                    }
    
                }
            });
        });

        $('#save-btn-tab-home').click(function(){
            var data    = {
                _method           : "PUT",
                language_id       : $('select[name=language_id]').val(),
                logo : $('#filemanager-image').attr('src'),
                email           : $('input[name=email]').val().trim(),
                email_comment           : $('input[name=email_comment]').val().trim(),
                keywords_not_good           : $('textarea[name=keywords_not_good]').val().trim(),
                facebook           : $('input[name=facebook]').val().trim(),
                youtube           : $('input[name=youtube]').val().trim(),
                instagram           : $('input[name=instagram]').val().trim(),
                twitter           : $('input[name=twitter]').val().trim(),
                pinterest           : $('input[name=pinterest]').val().trim(),
                linkedIn           : $('input[name=linkedIn]').val().trim(),
                copyright_text           : $('input[name=copyright_text]').val().trim(),
                apple_store_link           : $('input[name=apple_store_link]').val().trim(),
                google_play_link           : $('input[name=google_play_link]').val().trim(),
            };

            $.ajax({
                type: "POST",
                url: "{{ route('config.update-config-home') }}",
                data: data,
                dataType:'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function(r, a){
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (response) {
                    $().toastmessage('showSuccessToast', response.message);
                },
                error: function (data) {
                    $().toastmessage('showErrorToast', "Có lỗi xảy ra với dữ liệu. Vui lòng xem lại.");
                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
                    });
                }
            });
        });

        $('#save-btn-tab-seo').click(function(){
            // console.log(image_base_64)
            var data    = {
                _method           : "PUT",
                language_id       : $('select[name=language_id]').val(),
                keywords          : $('textarea[name=keywords]').val(),
                seo_title         : $('textarea[name=seo_title]').val(),
                seo_description   : $('textarea[name=seo_description]').val(),
            };

            $.ajax({
                type: "POST",
                url: "{{ route('config.update-config-seo') }}",
                data: data,
                dataType:'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function(r, a){
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (response) {
                    $().toastmessage('showSuccessToast', response.message);
                },
                error: function (data) {
                    $().toastmessage('showErrorToast', "Có lỗi xảy ra với dữ liệu. Vui lòng xem lại.");
                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
                    });
                }
            });
        });
    });
</script>
@endsection