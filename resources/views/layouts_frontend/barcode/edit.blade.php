@extends('layouts_frontend.master')
@section('title', 'Barcode Live')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/combobox.css') }}">
<script src="https://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
<script src="{{ asset('frontend/js/jquery.combobox.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js"></script>
<div class="special"></div>
<div class="container">
    <div class="row">
        <div class="add-barcode account clearfix">
            <h3>Edit Product</h3>
            <!-- Thông báo -->
            @include('layouts_frontend.notification')
            @if(!empty($data))
            <form enctype="multipart/form-data" method="post" action="{{ route('putBarCodeEditbyUser',['id'=>$data->id]) }}">
                <input type="hidden" name="_method" value="PUT">
                <div class="col-xs-offset-2 col-sm-8">
                    <div class="item_detail">
                      <div class="product-image">
                          <span class="btn btn-success fileinput-button">
                              <span>Upload product image</span>
                              <input type="file"  id="avatar" multiple accept="image/*"><br />
                          </span>
                          <output id="Filelist">
                            <ul class="thumb-Images" id="imgList">
                              <?php $list_file = explode(',', $data->image);  ?>
                              @if(isset($data->image) && strlen($data->image) > 0)
                                <?php 
                                    $check_link_http = false;

                                    if (count($list_file) == 1 && strpos($data->image, "http") !== false) {
                                        $check_link_http = true;
                                    }
                                ?>

                                @if ($check_link_http)
                                    <li>
                                        <div class="img-wrap"> 
                                            <span class="close" old_name="{{ $image }}" new_name="{{ $data->image }}">×</span>
                                            <img src="{{ $data->image }}" class="thumb">
                                        </div>
                                        {{-- <div class="FileNameCaptionStyle">{{ $data->image  }}</div> --}}
                                    </li>
                                @else
                                    @foreach ($list_file as $key => $image)
                                    <li>
                                        <div class="img-wrap"> 
                                            <span class="close" old_name="{{ $image }}" new_name="{{ $image }}">×</span>
                                            <img src="{{ asset('uploads/barcode/'.$image) }}" class="thumb">
                                        </div>
                                        {{-- <div class="FileNameCaptionStyle">{{ $image }}</div> --}}
                                    </li>
                                    @endforeach
                                @endif

                              @endif
                            </ul>
                          </output>
                      </div>
                      <div class="text-warning"><b>Note: </b>The maximum file size for uploads should not exceed 2MB.</div>
                    </div>
                    <div class="item_detail">
                        <!--     <label class="control-label"> BarCode <span class="required">*</span> <span class="character-barcode"></span></span>/50</label> -->
                        <div class="name-field clearfix">
                            <div class="pull-left">
                                BarCode <span class="required">*</span>
                            </div>
                            <div class="pull-right">
                                <span class="character-barcode"></span></span>/12-13
                            </div>
                        </div>
                        <input type="text" class="form-control" id="barcodetxt" name="barcode" value="{{ $data->barcode }}" pattern="\d*">
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
                        <input type="text" class="form-control" name="name" id="name-barcode" value="{{ old('name',isset($data->name) ? $data->name : null)}}">
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
                        <input type="text" class="form-control" name="model" value="{{ old('model',isset($data->model) ? $data->model : null)}}">
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
                        <input type="text" class="form-control" name="manufacturer" value="{{ old('manufacturer',isset($data->manufacturer) ? $data->manufacturer : null)}}">
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
                                <input type="text" id="numFormatResult" class="form-control" name="avg_price_tmp" value="{{ old('avg_price_tmp',isset($data->avg_price) ? $data->avg_price : null)}}" maxlength="133" size="133">
                                <input type="hidden" name="avg_price" id="result" value="{{ isset($data->avg_price) ? $data->avg_price : null}}">
                            </div>
                            <div class="col-sm-6">
                                <div class="name-field clearfix">
                                    Currency Unit
                                </div>
                                <?php $currency_list =  config('batv_config.currency_list') ?>
                                <select class="form-control select2 wrap" name="currency_unit">
                                @foreach($currency_list as $key=>$value)
                                  <option value="{{ $key }}" {{ strtoupper(old('currency_unit', $data->currency_unit)) == strtoupper($key) ? 'selected' : '' }}>{{ $key }}</option>
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
                        <textarea rows="4" onkeydown="expandtext(this);" name="spec" class="form-control" >{{ old('spec',isset($data->spec) ? $data->spec : null)}}</textarea>
                    </div>
                    <div class="item_detail">
                        <div class="name-field clearfix">
                            Feature
                        </div>
                        <textarea rows="4" onkeydown="expandtext(this);" name="feature" class="form-control" >{{ old('feature',isset($data->feature) ? $data->feature : null)}}</textarea>
                    </div>
                    <div class="item_detail">
                        <div class="name-field clearfix">
                            Description
                        </div>
                        <textarea rows="4" onkeydown="expandtext(this);" name="description_field" class="form-control" >{{ old('description',isset($data->description) ? $data->description : null)}}</textarea>
                    </div>
                    <div class="item_detail">
                        <div class="seo-title-field clearfix">
                            Seo Title
                        </div>
                        <textarea rows="4" onkeydown="expandtext(this);" name="seo_title" class="form-control" >{{ old('seo_title',isset($data->seo_title) ? $data->seo_title : null)}}</textarea>
                    </div>
                    <div class="item_detail">
                        <div class="seo-description-field clearfix">
                            Seo Description
                        </div>
                        <textarea rows="4" onkeydown="expandtext(this);" name="seo_description" class="form-control" >{{ old('seo_description',isset($data->seo_description) ? $data->seo_description : null)}}</textarea>
                    </div>
                    <div id="pre_ajax_loading_barcode" style="display: none;text-align: center;margin: 0px 0px 15px 0px;"><img src="{{ asset('images/general/bx_loader.gif') }}"></div>
                    <div class="button text-center">
                        <button class="register" id="add-edit-barcode">Submit</button>
                        <a class="cancel" href="javascript:void(0);" onclick="alertMessage('Are you sure you want to cancel?');">Cancel</a>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            @endif
        </div>
    </div>
</div>
<!-- Modal -->
<div id="change-image" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-image">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="form" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Select new image</h4>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            80%
                        </div>
                    </div>
                    <input id="file" type="file" class="hide" accept="image/*">
                    <div id="views"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="load-btn">Load image</button>
                    <button type="button" class="btn btn-primary hide" id="submit-btn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v0.9.12/css/jquery.Jcrop.min.css" type="text/css" />
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

      wordCounter('barcode',13, true);
      wordCounter('name',200);
      wordCounter('model',50);
      wordCounter('manufacturer',200);
      wordCounter('avg_price',100);
    
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
              $('#file').val("");
              $('#file').click();
            });
    
           $('#open-modal').click(function(){
              $('#file').val("");
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
    
           function loadImage(input) {
             if (input.files && input.files[0]) {
               var reader = new FileReader();
               canvas = null;
               reader.onload = function(e) {
                 image = new Image();
                 image.onload = validateImage;
                 image.src = e.target.result;
               }
               reader.readAsDataURL(input.files[0]);
               $('#submit-btn').removeClass('hide');
             }
           }
    
           function validateImage() {
              $('.progress').addClass('hide');
              if (canvas != null) {
                image = new Image();
                image.onload = restartJcrop;
                image.src = canvas.toDataURL('image/png');
    
                $("#form").submit();
              } else restartJcropOpen();
           }

            function restartJcropOpen() {
                if(image.width < 160 || image.height < 160 || image.width > 3000 || image.height > 3000){
                    $("#views").empty();
                    swal({
                        html: '<div class="alert-danger">Image must be between 160 x 160 — 3,000 x 3,000 pixels. Please select a different image.</div>',
                    });
                  }else{
                    $('#change-image').modal('show');
                    restartJcrop();
                  }
            }
    
           function restartJcrop() {
             if (jcrop_api != null) {
               jcrop_api.destroy();
             }
             $("#views").empty();
             $("#views").append("<canvas id=\"canvas\">");
             canvas = $("#canvas")[0];
             context = canvas.getContext("2d");
             canvas.width = image.width;
             canvas.height = image.height;
             var imageSize = (image.width > image.height)? image.height : image.width;
             imageSize = (imageSize > 800)? 800: imageSize;
             context.drawImage(image, 0, 0);
             $("#canvas").Jcrop({
               onSelect: selectcanvas,
               onRelease: clearcanvas,
               boxWidth: crop_max_width,
               boxHeight: crop_max_height,
               setSelect: [0,0,(imageSize*4/3),imageSize],
               aspectRatio: 4/3,
               bgOpacity:   .4,
               bgColor:     'black'
             }, function() {
               jcrop_api = this;
             });
             clearcanvas();
             selectcanvas({x:0,y:0,w:(imageSize*4/3),h:imageSize});
           }
    
           function clearcanvas() {
             prefsize = {
               x: 0,
               y: 0,
               w: canvas.width,
               h: canvas.height,
             };
           }
    
           function selectcanvas(coords) {
             prefsize = {
               x: Math.round(coords.x),
               y: Math.round(coords.y),
               w: Math.round(coords.w),
               h: Math.round(coords.h)
             };
           }
    
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
             //---Add file blob to the form data
             formData.append("base64", canvas.toDataURL('image/png'));
    
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
                    $('#product-image').css('width', '165px');
                    $('#product-image').css('height', '125px');
                    $('#product-image').show();
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
       });
</script>

<script type="text/javascript">
    var slug = function(str) {
      str = str.replace(/^\s+|\s+$/g, ''); // trim
      str = str.toLowerCase();

      // remove accents, swap ñ for n, etc
      var from = "ãàáảạăẵắằẳặâẫầấẩậäẽèéëẻẹêễềếểệĩìíïîịõòóöọỏôốộỗồổợỡớờỡởũùúủụưứừữựửüûñç_";
      var to   = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiioooooooooooooooooouuuuuuuuuuuuunc-";
      for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
      }

      str = str.replace(/[^a-z0-9. -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

      return str;
    };

    list_image = <?php echo json_encode($list_file); ?>;
    list_title_file_upload = [];
    /* WHEN YOU UPLOAD ONE OR MULTIPLE FILES */
    $(document).on('change','#avatar',function(){
        form_data = new FormData(); 
        len_files = $("#avatar").prop("files").length;
        param = (list_image[0] != '') ? 1 : 0;

        for (var i = 0; i < len_files; i++) {
            flag = true;
            var file_data = $("#avatar").prop("files")[i];

            if(jQuery.inArray(file_data.name, list_title_file_upload) !== -1) {
                flag = false;
                swal({
                    html: '<div class="alert-danger">File already exists</div>',
                })
            }

            $.each(list_image , function(index, val) { 
                var value = val.split('z1_9a');
                var value = slug(value[0]);
                var name = (file_data.name).split('.');

                if(val != '' && val.indexOf(slug(name[0])) != -1){
                    flag = false;
                    swal({
                        html: '<div class="alert-danger">File already exists</div>',
                    })
                }

            });
            
            if (file_data.size == 0) {
                flag = false;
                swal({
                    html: "<div class='alert-danger'>Please select a valid image!</div>",
                    })
            }

            // alert(list_image.length + param)
            if (list_image.length + param > 10) {
                flag = false;
                swal({
                    html: '<div class="alert-danger">You have added more than 10 files. According to upload conditions you can upload 10 files maximum</div>',
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
</script>
@endsection