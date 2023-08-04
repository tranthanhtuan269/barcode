@extends('layouts_frontend.master')
@section('title', 'Barcode Live')
@section('content')
<?php 
    if( ( Session::get('check_in')=='add_normal' ) ){
        $class_import = '';
        $class_normal = 'in';
    }else{
        $class_normal = '';
        $class_import = 'in';
    }
?>
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/combobox.css') }}">
<script src="https://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
<script src="{{ asset('frontend/js/jquery.combobox.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>

<div id="special-field" class="special" data-barcode="{{ (\Auth::check()) ? \Auth::user()->number_barcode : 0 }}"></div>
<div class="container">
    <div class="row">
        <div class="add-barcode account clearfix">
            <h3>Add new product</h3>
            @include('layouts_frontend.notification')
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="accordion-toggle">
                           Choose 1: Import Excel</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse {{ $class_import }}">
                        <div class="panel-body">
                            <form enctype="multipart/form-data" method="post" id="form-upload-excel">
                                <div class="col-sm-4">
                                    <i style="font-weight: 600;">File example : </i> <a href="{{ asset('uploads/example.xlsx') }}" style="color: #00a651 !important;">Download</a>
                                </div>
                                <div class="col-sm-4">
                                    <span class="file-wrapper" >
                                      <input id="file-excel" type="file" name="file_excel" accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                                      <span class="button">Choose File</span>
                                    </span>
                                    <span class="name_file_tmp"></span>
                                    <script type="text/javascript">
                                        $('input[type="file"]').change(function() {
                                          $('.name_file_tmp').html( this.value.replace(/.*[\/\\]/, '') );
                                        });
                                    </script>
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="register importBtn hide" value="Import" name="excel">
                                </div>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="accordion-toggle  collapsed">
                            Choose 2: Add Manually</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse {{ $class_normal }}">
                        <div class="panel-body">
                            <!-- Thông báo -->
                            <form action="{{ route('addBarCodeNormalByUserAjax') }}" method="post" enctype="multipart/form-data">
                                <div class="col-xs-offset-2 col-sm-8">
                                    <div class="item_detail">
                                        <div class="product-image">
                                            <span class="btn btn-success fileinput-button">
                                                <span>Upload product image</span>
                                                <input type="file" name="files[]" id="avatar" multiple accept="image/*"><br />
                                            </span>
                                            <output id="Filelist">
                                                <ul class="thumb-Images" id="imgList"></ul>
                                            </output>
                                        </div>
                                        <div class="text-warning"><b>Note: </b>The maximum file size for uploads should not exceed 2MB.</div>
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            <div class="pull-left">
                                                BarCode <span class="required">*</span>
                                            </div>
                                            <div class="pull-right">
                                                <span class="character-barcode"></span></span>/12-13
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" id="barcodetxt" name="barcode">
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            <div class="pull-left">
                                                Name <span class="required">*</span>
                                            </div>
                                            <div class="pull-right">
                                                <span class="character-name"></span></span>/200
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="name" id="name-barcode">
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            <div class="pull-left">
                                                Model <span class="required">*</span>
                                            </div>
                                            <div class="pull-right">
                                                <span class="character-model"></span></span>/50
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="model">
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            <div class="pull-left">
                                                Manufacturer <span class="required">*</span>
                                            </div>
                                            <div class="pull-right">
                                                <span class="character-manufacturer"></span></span>/200
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="manufacturer">
                                    </div>
                                    <div class="item_detail">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="name-field clearfix">
                                                    <div class="pull-left">
                                                        Avg Price <span class="required">*</span>
                                                    </div>
                                                    <div class="pull-right">
                                                        <span class="character-avg_price"></span></span>/100
                                                    </div>
                                                </div>
                                                <input type="text" id="numFormatResult" class="form-control" name="avg_price_tmp" maxlength="133" size="133">
                                                <input type="hidden" name="avg_price" id="result" value="{{ \App\Helpers\BatvHelper::parse_number(old('avg_price_tmp')) }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="name-field clearfix">
                                                    Currency Unit
                                                </div>
                                                <?php $currency_list =  config('batv_config.currency_list') ?>
                                                <select class="form-control select2 wrap" name="currency_unit">
                                                    @foreach($currency_list as $key=>$value)
                                                        <option value="{{ $key }}">{{ $key }}</option>
                                                    @endforeach
                                                </select>
                                                <script type="text/javascript">
                                                    var $select2 = $('.select2').select2({
                                                        containerCssClass: "wrap"
                                                    })
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            Spec
                                        </div>
                                        <textarea rows="4" onkeydown="expandtext(this);" name="spec" class="form-control" ></textarea>
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            Feature
                                        </div>
                                        <textarea rows="4" onkeydown="expandtext(this);" name="feature" class="form-control" ></textarea>
                                    </div>
                                    <div class="item_detail">
                                        <div class="name-field clearfix">
                                            Description
                                        </div>
                                        <textarea rows="4" onkeydown="expandtext(this);" name="description_field" class="form-control" ></textarea>
                                    </div>
                                    <div id="pre_ajax_loading_barcode" style="display: none;text-align: center;margin: 0px 0px 15px 0px;"><img src="{{ asset('images/general/bx_loader.gif') }}"></div>
                                    <div class="button text-center">
                                        <button class="register" id="add-edit-barcode">Submit</button>
                                        <a class="cancel" href="javascript:void(0);" onclick="alertMessage('Are you sure?');">Cancel</a>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v0.9.12/css/jquery.Jcrop.min.css" type="text/css" /> --}}
<script type="text/javascript">

    var inputEl = document.getElementById('barcodetxt');
    var goodKey = '0123456789';

    var crop_max_width = 400;
    var crop_max_height = 400;
    var jcrop_api;
    var canvas;
    var context;
    var image;

    var prefsize;

    CKEDITOR.replace('description_field');
    CKEDITOR.replace('feature');
    CKEDITOR.replace('spec');

    CKEDITOR.instances['spec'].on('contentDom', function() {
        this.document.on('click', function(event){
            var temp = $(window).scrollTop();
            $('.select2').select2("close");
            CKEDITOR.instances['spec'].focus();
            $(window).scrollTop(temp);
         });
    });

    CKEDITOR.instances['feature'].on('contentDom', function() {
        this.document.on('click', function(event){
            var temp = $(window).scrollTop();
            $('.select2').select2("close");
            CKEDITOR.instances['feature'].focus();
            $(window).scrollTop(temp);
         });
    });

    CKEDITOR.instances['description_field'].on('contentDom', function() {
        this.document.on('click', function(event){
            var temp = $(window).scrollTop();
            $('.select2').select2("close");
            CKEDITOR.instances['description_field'].focus();
            $(window).scrollTop(temp);
         });
    });

    
    $(document).ready(function(){

        $('.name_file_tmp').html('');
        $('#file-excel').val('');
        var $file = null;

        $('#change-image').on('shown.bs.modal', function (e) {
            e.preventDefault();
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray($($file).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal({
                    html: '<div class="alert-danger">Only formats are allowed : '+fileExtension.join(', ')+'</div>',
                  })
                return;
            }
            loadImage($file);
        });

        $("#form-upload-excel").submit(function (e) {
            $('input[name="excel"]').hide();
            return true;
        });

        $('input[name="file_excel"]').change(function() {
            if($(this).val().length > 0){
                $('input[name=excel]').removeClass('hide');
                var fileExtension = ['xlsx', 'xls', 'csv'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    swal({
                        html: '<div class="alert-danger">The File is not formatted correctly</div>',
                    });

                    $('.name_file_tmp').html('');
                    $(this).val('').clone(true);
                }
            }else{
                $('.importBtn').addClass('hide');
            }
        });

        var checkInputTel = function(e) {
          var key = (typeof e.which == "number") ? e.which : e.keyCode;
          var start = this.selectionStart,
            end = this.selectionEnd;

          var filtered = this.value.split('').filter(filterInput);
          this.value = filtered.join("");

          /* Prevents moving the pointer for a bad character */
          var move = (filterInput(String.fromCharCode(key)) || (key == 0 || key == 8)) ? 0 : 1;
          this.setSelectionRange(start - move, end - move);
        }

        var filterInput = function(val) {
          return (goodKey.indexOf(val) > -1);
        }

        inputEl.addEventListener('input', checkInputTel);

        $('#product-image').click(function(){
            // $('#file').val("");
            $('#file').click();
        });

        $('#open-modal').click(function(){
            // $('#file').val("");
            $('#file').click();
        });

        $("#file").change(function() {
            $file = this;
            if($(this).val().length > 0){
                $('.progress').removeClass('hide');
                // $('#change-image').modal('show');
                loadImage(this);
            }
        });

        $('#load-btn').click(function(){
            $('#file').val("");
            $('#change-image').modal('hide');
            $('#file').click();
        });


        $('#submit-btn').click(function(){
            canvas.width = prefsize.w;
            canvas.height = prefsize.h;
            context.drawImage(image, prefsize.x, prefsize.y, prefsize.w, prefsize.h, 0, 0, canvas.width, canvas.height);
            validateImage();
        });

        $("#form").submit(function(e) {
          e.preventDefault();
          $('#change-image').modal('hide');
          $('#product-image').removeClass('hide');
          formData = new FormData($(this)[0]);

          $.ajaxSetup(
          {
              headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ url('/') }}/images/uploadImageBarcode",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#image-loading").show();
            },
            success: function(data) {
                $("#pre_ajax_loading").hide();
                if(data.code == 200){
                    $('#product-image').attr('src', "{{ url('/') }}/uploads/barcode/" + data.image_url);
                    $('#image').val(data.image_url);
                    $('#change-image').modal('hide');
                    $("#views").empty();
                }else{
                    $('#product-image').addClass('hide');
                    swal({
                        html: '<div class="alert-danger">An error occurred during save process, please try again</div>',
                      })
                    return;
                }

                $('#product-image').on('load', function () {
                    $("#image-loading").hide();
                });
            },
            error: function(data) {
                alert("Error");
            },
            complete: function(data) {}
          });
        });

        list_image = [];
        list_title_file_upload = [];
        /* WHEN YOU UPLOAD ONE OR MULTIPLE FILES */
        $(document).on('change','#avatar',function(){
            form_data = new FormData(); 
            len_files = $("#avatar").prop("files").length;
            param = 1;

            for (var i = 0; i < len_files; i++) {
                flag = true;
                var file_data = $("#avatar").prop("files")[i];

                if(jQuery.inArray(file_data.name, list_title_file_upload) !== -1) {
                    flag = false;
                    swal({
                        html: '<div class="alert-danger">File already exists</div>',
                        })
                }
                // alert(list_image.length + param)
                if (list_image.length + param > 10) {
                    flag = false;
                    swal({
                        html: '<div class="alert-danger">You have added more than 10 files. According to upload conditions you can upload 10 files maximum</div>',
                        })
                }
                // alert(file_data.size)
                if (file_data.size == 0) {
                    flag = false;
                    swal({
                        html: "<div class='alert-danger'>Please select a valid image!</div>",
                        })
                }

                if (file_data.size > 2097152) {
                    flag = false;
                    swal({
                        html: "<div class='alert-danger'>The file (" + file_data.name + ") does not match the upload conditions, The maximum file size for uploads should not exceed 2MB</div>",
                        })
                }

                if (flag == true) {
                    param++;
                    list_title_file_upload.push(file_data.name); 
                    form_data.append("avatar[]", file_data);
                }

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('barcode/uploadImageAjax') }}",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, // Setting the data attribute of ajax with form_data
                type: 'post',
                success: function(result) {
                    var html = '';

                    $.each(result.data , function(index, val) { 
                        var link = '{{ asset("uploads/barcode") }}' + '/' + val.new_name;
                        html += '<li><div class="img-wrap"><span class="close" old_name="'+ val.old_name +'" new_name="'+ val.new_name +'">×</span><img class="thumb" src="' + link + '"' + '></div></li>';
                        list_image.push(val.new_name);
                    });

                    $('#Filelist ul').append(html);
                }
            })

            $('#avatar').val('')

        }); 

        $(document).on('click','.close',function(){
            var filenameOld = $(this).attr('old_name');
            var filenameNew = $(this).attr('new_name');

            list_image = jQuery.grep(list_image, function(value) {
                return value != filenameNew;
            });
            
            list_title_file_upload = jQuery.grep(list_title_file_upload, function(value) {
                return value != filenameOld;
            });

            $(this).closest("li").remove();
            $('#avatar').val('')
        });


    });
</script>

@endsection