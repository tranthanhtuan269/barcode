@extends('backend.master')

@section('content')
<style type="text/css">
    /* End SEO box */
.toggle-switch {
    background: #383838;
    float: right;
    border-radius: 6px;
    padding: 5px 6px;
    color: #fff;
    position: relative;
    top: -5px;
}
.toggle-switch span{
    cursor: pointer;
}
.toggle-switch span.active {
    background: #F05822;
    padding: 0px 8px;
    text-align: center;
    border-radius: 6px;
}
</style>
<section class="content-header">
    <h1 class="text-center font-weight-600">ADS</h1>
</section>
<div class="container-fluid main-content" style="margin-top:20px">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6" style="margin: 0px auto;">
                <div class="form-group clearfix banner_to_status">
                    <div class="col-md-12">
                        <label class="font-weight-bold">Banner Ads top</label>
                        <input type="hidden" name="switch-banner_to_status" value="{{ $banner_top_status }}">
                        <div class="toggle-switch time">
                            <span data-id="1" class="@if($banner_top_status == 1) active @endif">ON</span>
                            <span data-id="0" class="@if($banner_top_status == 0) active @endif">OFF</span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix banner_mid_status">
                    <div class="col-md-12">
                        <label class="font-weight-bold">Banner Ads mid</label>
                        <input type="hidden" name="switch-banner_mid_status" value="{{ $banner_mid_status }}">
                        <div class="toggle-switch time">
                            <span data-id="1" class="@if($banner_mid_status == 1) active @endif">ON</span>
                            <span data-id="0" class="@if($banner_mid_status == 0) active @endif">OFF</span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix banner_bottom_status">
                    <div class="col-md-12">
                        <label class="font-weight-bold">Banner Ads bottom</label>
                        <input type="hidden" name="switch-banner_bottom_status" value="{{ $banner_bottom_status }}">
                        <div class="toggle-switch time">
                            <span data-id="1" class="@if($banner_bottom_status == 1) active @endif">ON</span>
                            <span data-id="0" class="@if($banner_bottom_status == 0) active @endif">OFF</span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix banner_fixed_right_status">
                    <div class="col-md-12">
                        <label class="font-weight-bold">Banner Ads fixed right</label>
                        <input type="hidden" name="switch-banner_fixed_right_status" value="{{ $banner_fixed_right_status }}">
                        <div class="toggle-switch time">
                            <span data-id="1" class="@if($banner_fixed_right_status == 1) active @endif">ON</span>
                            <span data-id="0" class="@if($banner_fixed_right_status == 0) active @endif">OFF</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save-change">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ajax_waiting"></div>
<script>
    var errorConnect = 'Errors network';
    $(".banner_to_status" ).on( "click",".toggle-switch.time span", function() {
        $('.banner_to_status .toggle-switch.time span').removeClass('active');
        $(this).addClass('active');
        $('input[name=switch-banner_to_status]').val($(this).attr('data-id'));
    });

    $(".banner_mid_status" ).on( "click",".toggle-switch.time span", function() {
        $('.banner_mid_status .toggle-switch.time span').removeClass('active');
        $(this).addClass('active');
        $('input[name=switch-banner_mid_status]').val($(this).attr('data-id'));
    });

    $(".banner_bottom_status" ).on( "click",".toggle-switch.time span", function() {
        $('.banner_bottom_status .toggle-switch.time span').removeClass('active');
        $(this).addClass('active');
        $('input[name=switch-banner_bottom_status]').val($(this).attr('data-id'));
    });

    $(".banner_fixed_right_status" ).on( "click",".toggle-switch.time span", function() {
        $('.banner_fixed_right_status .toggle-switch.time span').removeClass('active');
        $(this).addClass('active');
        $('input[name=switch-banner_fixed_right_status]').val($(this).attr('data-id'));
    });
    $(document).ready(function(){
        $('#save-change').click(function(){
            url = baseURL + '/admincp/config/ads';
            var data    = {
                _method           : "POST",
                banner_top_status:$('input[name=switch-banner_to_status]').val(),
                banner_mid_status:$('input[name=switch-banner_mid_status]').val(),
                banner_bottom_status:$('input[name=switch-banner_bottom_status]').val(),
                banner_fixed_right_status:$('input[name=switch-banner_fixed_right_status]').val(),
            };

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                beforeSend: function(r, a){
                    $('.alert-errors').hide();
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function(r, a){
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(data) {
                    if(data.status == 200){
                        $().toastmessage('showSuccessToast', data.Message);
                    }else{
                        if(data.status == 422){
                            $.each(data.responseJSON.errors, function( index, value ) {

                                $('#' + index + '-error').show();
                                $('#' + index + '-error').html(value);
                            });
                            $().toastmessage('showErrorToast', 'Errors');
                        }else{
                            if(data.status == 401){
                              window.location.replace(baseURL);
                            }else{
                             $().toastmessage('showErrorToast', errorConnect);
                            }
                        }
                    }
                },
                error: function (data) {
                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('#' + index + '-error').show();
                        $('#' + index + '-error').html(value);
                    });
                    $().toastmessage('showErrorToast', 'Errors');
                }
            });
        });

    });
</script>
@endsection
