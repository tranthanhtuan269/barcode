@extends('layouts_frontend.master')

@section('title', isset($page->seo_title) ? $page->seo_title : "Barcodelive Mobile App Available For iOS and Android devices")

@section('description',isset($page->seo_description) ? $page->seo_description : "Barcode app - Barcodelive is available on iOS & Android OS. Installing this phone barcode scanner helps you find a product by barcode easily (features, origin).")

@section('keywords', isset($page->keywords) ? $page->keywords : "App Barcode")

@section('content')
<div class="special"></div>
<div class="page_app">
    <div class="top">
        <div class="container">
            <div class="content">
                <div class="left">
                    <h1 class="title">Barcodelive App is Available For iOS and Android</h1>
                    <h2 class="title">Why should use the Barcodelive app?</h2>
                    <div class="des text-left">
                        Installing this phone Barcodelive app helps you find a product by barcode easily: features, origin,...
                    </div>
                    <div class="list-app">
                        <a href="{!! Cache::get('google_play_link') !!}"  target="_blank">
                            <img src="{{ asset('frontend/images/ggplay.png') }}" alt="Android App on Google play">
                        </a>
                        <a href="{!! Cache::get('apple_store_link') !!}"  target="_blank">
                            <img src="{{ asset('frontend/images/app store.png') }}" alt="Ios app on Apple Store">
                        </a>
                    </div>
                </div>
                <div class="right">
                    <img src="{{ asset('frontend/images/app.svg') }}" alt="App Barcode">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="bottom">
            <div class="part left">
                <div class="item mt">
                    <h3 class="title text-right">BARCODE LOOKUP</h3>
                    <p class="des text-right">
                    The barcode scanner app returns all product data from images, descriptions, reviews and the shop address in seconds after reading the barcode.
                    </p>
                </div>
                <div class="item mt">
                    <h3 class="title text-right">EDIT BARCODE</h3>
                    <p class="des text-right">Users can delete or edite customized QR code quickly and easily.</p>
                </div>
            </div>
            <div class="center">
                <img src="{{ asset('frontend/images/ic_app.svg') }}" alt="App Barcode">
            </div>
            <div class="part right">
                <div class="item">
                    <h3 class="title text-left">SCAN BARCODE</h3>
                    <p class="des text-left">It's so convenient to do a barcode lookup. You just open your phone and scan barcode. </p>
                </div>
                <div class="item mt">
                    <h3 class="title text-left">CREATE VARIOUS QR CODE</h3>
                    <p class="des text-left">The barcode scanner app returns all product data from images, descriptions, reviews and the shop address in seconds after reading the barcode.</p>
                </div>
                <div class="item mt">
                    <h3 class="title text-left">REVIEW HISTORY</h3>
                    <p class="des text-left">Users can review barcode history to reuse or edit existing barcode. </p>
                </div>
            </div>
        </div>

        <div class="bottom-mb">
            <div class="item">
                <div class="box-img">
                    <img src="{{ asset('frontend/images/app_1.svg') }}" alt="SCAN BARCODE">
                </div>
                <div class="content">
                    <h3 class="title">SCAN BARCODE</h3>
                    <p class="des text-left">It's so convenient to do a barcode lookup. You just open your phone and scan barcode. </p>
                </div>
            </div>
            <div class="item">
                <div class="box-img">
                    <img src="{{ asset('frontend/images/app_2.svg') }}" alt="BARCODE LOOKUP">
                </div>
                <div class="content">
                    <h3 class="title">BARCODE LOOKUP</h3>
                    <p class="des text-left">
                    The barcode scanner app returns all product data from images, descriptions, reviews and the shop address in seconds after reading the barcode.
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="box-img">
                    <img src="{{ asset('frontend/images/app_3.svg') }}" alt="CREATE VARIOUS QR CODE">
                </div>
                <div class="content">
                    <h3 class="title">CREATE VARIOUS QR CODE</h3>
                    <p class="des text-left">The barcode scanner app returns all product data from images, descriptions, reviews and the shop address in seconds after reading the barcode.</p>
                </div>
            </div>
            <div class="item">
                <div class="box-img">
                    <img src="{{ asset('frontend/images/app_4.svg') }}" alt="EDIT BARCODE">
                </div>
                <div class="content">
                    <h3 class="title">EDIT BARCODE</h3>
                    <p class="des text-left">Users can delete or edite customized QR code quickly and easily.</p>
                </div>
            </div>
            <div class="item">
                <div class="box-img">
                    <img src="{{ asset('frontend/images/app_5.svg') }}" alt="REVIEW HISTORY">
                </div>
                <div class="content">
                    <h3 class="title">REVIEW HISTORY</h3>
                    <p class="des text-left">Users can review barcode history to reuse or edit existing barcode. </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection