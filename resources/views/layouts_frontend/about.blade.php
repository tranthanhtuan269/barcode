@extends('layouts_frontend.master')

@section('title', isset($page->seo_title) ? $page->seo_title : "Barcodelive - The best assistance for you")

@section('description',isset($page->seo_description) ? $page->seo_description : "Barcodelive lets users find product data by barcode to avoid fake goods. Also, sellers can create a barcode online to manage goods better and save expenses.")  
@section('keywords', isset($page->keywords) ? $page->keywords : "Barcodelive")
@section('robots',"index,nofollow")
@section('content')

<div class="special"></div>
<div class="about_page">
    <div class="top">
        <div class="container">
            <div class="content">
                <div class="left">
                    <h1>What is Barcodelive?</h1>
                    <p class="text-left">
                        Barcodelive is a free barcode tool online that allows buyers to barcode search for products and sellers to add/ edit barcode numbers. Barcodelive gives superpowers to consumers and businesses. 
                    </p>
                    <h2>
                        Barcodelive - Best choice for you!
                    </h2>
                    <p class="text-left">
                        Barcodelive is definitely a great barcode lookup tool you are finding. Thousands of users do a barcode reader everyday to check product data as well as avoid purchasing fake goods. Buyers can do barode search anytime, anywhere with just a smartphone connecting to the Internet.
                        Moreover, if you're a businessman, you can add barcode numbers or edit existing barcodes to increase trust and business effectiveness. This way is applied by many and many enterprises all over the world. 
                        With Barcodelive, everything seems easy.
                    </p>
                </div>
                <div class="right">
                    <img src="{{ asset('frontend/images/about.svg') }}" alt="About Barcodelive">
                </div>
            </div>
        </div>
    </div>

    <div class="bottom">
        <div class="container">
            <h2 class="title">Why should choose Barcodelive?</h2>
            <div class="content">
                <div class="left">
                    <img src="{{ asset('frontend/images/ic_about.svg') }}" alt="About Barcodelive">
                </div>
                <div class="right">
                    <div class="item item-1">
                        <h3 class="title">
                        Fastest response time
                        </h3>
                        <p class="des text-left">
                        All your requests are responded promptly, completely and accurately. Enter a barcode number and you will get all products data after a few seconds 
                        </p>
                    </div>
                    <div class="item item-2">
                        <h3 class="title">
                        Best solution for buyers
                        </h3>
                        <p class="des text-left">
                        Whenever you suspect a product, you can search a barcode on it and check information. This helps you to purchase the high-quality goods. 
                        </p>
                    </div>
                    <div class="item item-3">
                        <h3 class="title">
                        Best solution for sellers
                        </h3>
                        <p class="des text-left">
                        Sellers can add a new products or edit existing barcode numbers on our barcode database. That time, buyers can visit our website and search for your products. This increases your business trust and business productivity.
                        </p>
                    </div>
                    <div class="item item-4">
                        <h3 class="title">
                        100% free
                        </h3>
                        <p class="des text-left">
                        This website is so great with a lot of amazing beneficial features. However, surprisingly, it's 100% FREE. You don't need to register for an account or pay a monthly fee. 
                        </p>
                    </div><div class="item item-5">
                        <h3 class="title">
                        Good customer service
                        </h3>
                        <p class="des text-left">
                        Customer service in Barcodelive is so tolerant and enthusiastic. Customer service representatives are always willing to answer and support all your wonders and troubles 24/7. 
                        </p>
                    </div>
                </div>
            </div>

            <div class="content-mb">
                <div class="item">
                    <div class="box-img">
                        <img src="{{ asset('frontend/images/about_1.svg') }}" alt="">
                    </div>
                    <div class="content-item">
                        <h3 class="title">
                        Fastest response time
                        </h3>
                        <p class="des text-left">
                        All your requests are responded promptly, completely and accurately. Enter a barcode number and you will get all products data after a few seconds 
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-img">
                        <img src="{{ asset('frontend/images/about_2.svg') }}" alt="">
                    </div>
                    <div class="content-item">
                        <h3 class="title">
                        Best solution for buyers
                        </h3>
                        <p class="des text-left">
                        Whenever you suspect a product, you can search a barcode on it and check information. This helps you to purchase the high-quality goods. 
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-img">
                        <img src="{{ asset('frontend/images/about_3.svg') }}" alt="">
                    </div>
                    <div class="content-item">
                        <h3 class="title">
                        Best solution for sellers
                        </h3>
                        <p class="des text-left">
                        Sellers can add a new products or edit existing barcode numbers on our barcode database. That time, buyers can visit our website and search for your products. This increases your business trust and business productivity.
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-img">
                        <img src="{{ asset('frontend/images/about_4.svg') }}" alt="">
                    </div>
                    <div class="content-item">
                        <h3 class="title">
                        100% free
                        </h3>
                        <p class="des text-left">
                        This website is so great with a lot of amazing beneficial features. However, surprisingly, it's 100% FREE. You don't need to register for an account or pay a monthly fee. 
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-img">
                        <img src="{{ asset('frontend/images/about_5.svg') }}" alt="">
                    </div>
                    <div class="content-item">
                        <h3 class="title">
                        Good customer service
                        </h3>
                        <p class="des text-left">
                        Customer service in Barcodelive is so tolerant and enthusiastic. Customer service representatives are always willing to answer and support all your wonders and troubles 24/7. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact">
        <div class="container">
            <h2 class="title">get in touch</h2>
            <div class="content">
                <form class="w-100">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <p class="font-extra-1 text-color-main"><b>Your Name</b></p>
                            <input type="text" class="form-control form-control-lg username">
                            <p class="alert-username alert-errors"></p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="font-extra-1 text-color-main"><b>Your Email</b></p>
                            <input type="text" class="form-control form-control-lg email">
                            <p class="alert-email alert-errors"></p>
                        </div>
                        <div class="col-12 col-sm-12 textarea-contact">
                            <p class="font-extra-1 text-color-main"><b>Your Message</b></p>
                            <textarea class="form-control comment" rows="10"></textarea>
                            <p class="alert-comment alert-errors"></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn cv-now" id="sendContact" type="button"><b class="font-extra">Send</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function(){
        $('#sendContact').click(function(){
            var data    = {
                _method           : "POST",
                username           : $('.username').val().trim(),
                email           : $('.email').val().trim(),
                comment         :  $('.comment').val().trim(),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('ajax/contact') }}",
                data: data,
                dataType:'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                    $('.alert-errors').html('');
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: "Send contact success",
                            icon: 'success',
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    } else {
                        $.each(response.errors, function( index, value ) {
                            $('.alert-' + index).html(value);
                        });
                    }
                },
                error: function (data) {
                }
            });
        });
    });
</script>

@endsection