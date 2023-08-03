@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<section class="content-header">
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tài khoản thanh toán Stripe</h1>
    <div class="row" id="stripeAccount">
        <div class="form-group col-xs-6 form-html">
            <label class="control-label">Publishable key:</label>
            <input type="text" class="form-control" id="STRIPE_KEY" placeholder="Publishable key" value="{{ $STRIPE_KEY }}">
            <p class="alert-STRIPE_KEY alert-errors"></p>
        </div>
        <div class="form-group col-xs-6 form-html">
            <label class="control-label">Secret key:</label>
            <input type="text" class="form-control" id="STRIPE_SECRET" placeholder="Secret key" value="{{ $STRIPE_SECRET }}">
            <p class="alert-STRIPE_SECRET alert-errors"></p>
        </div>
        <div class="col-xs-5"></div>
        <div class="col-xs-2">
            <p class="alert-change alert-errors" style="color: #00b8ff;text-align: center;"></p>
            <button type="submit" class=" btn btn-primary" id="submit" style="width:100%">Xác nhận</button>  
        </div> 
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#submit').click(function(){
            $('.alert-errors').html('');
            var STRIPE_KEY = $('#STRIPE_KEY').val();
            var STRIPE_SECRET = $('#STRIPE_SECRET').val();
            var data = {
                STRIPE_KEY : STRIPE_KEY,
                STRIPE_SECRET : STRIPE_SECRET
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: '{{url ("admincp/stripe-account-ajax")}}',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if(response.status == 200){
                        $('.alert-change').text('change success!');
                        // alert(1);
                    }
                },
                error: function (data) {
                    $.each(data.responseJSON.errors, function( index, value ) {
                        $('.alert-' + index).html(value);
                    });
                }
            });
        });
    });
</script>
@endsection