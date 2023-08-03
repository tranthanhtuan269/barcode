@extends('layouts_frontend.master')

@section('title', isset($page->seo_title) ? $page->seo_title :"Add a barcode | Contribute to Growing Barcode Database")

@section('description',isset($page->seo_description) ? $page->seo_description : "Sellers add barcode numbers & details to Barcodelive, & users can barcode lookup easily. Thus, sellers can manage inventory & consumers avoid fake goods. ")
@section('keywords', isset($page->keywords) ? $page->keywords : "Add Barcode")
@section('content')
<div class="special" ></div>
<div class="addbarcode-page">
	<div class="container">
		<h1 class="text-center" style="margin-bottom:24px">ADD A BARCODE</h1>
		<div class="row">
			<div class="col-sm-7 content-text">
				<h2 class="title">INTRODUCE YOUR PRODUCTS</h2>
					<h2 class="pull-right title"> WITH THOUSANDS OF DAILY USERS!</h2>
					<div class="clearfix"></div>
				<div class="sub-content">
				We have thousands of daily Internet users, giving you the opportunity to market your products worldwide as well as steadily and gradually expand your sales. Why haven't your products been included on our website yet? Add it right now!
				</div>
			</div>
			<div class="col-sm-4">
				<img src="{{ url('/') }}/frontend/images/tuan.png" width="100%" alt="Introduce Your Products">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<img src="{{ url('/') }}/frontend/images/mobile_app.png" width="100%" alt="Introduce Your Products on Mobile Apps">
			</div>
			<div class="col-sm-7 content-text">
				<h2 class="title">INTRODUCE YOUR PRODUCTS ON MOBILE APPS</h2>
				<div class="sub-content">
				In addition to this website, we also have top-rated mobile apps with millions of active users, so you will have a chance to advertise your products on multi-channels. Isn't it fantastic?
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<span class="addbarcode-btn" onclick="addBarcodeNow()">ADD BARCODE NOW</span>
			</div>	
		</div>

		<section class="popular-article" style="padding-top:100px">
			<h2 class="text-center title">
				MOST VIEWED
			</h2>
			<div class="content">
				@include('layouts_frontend.components.most-view-article', ['articles' => $mostViewArticles])
			</div>
		</section>
	</div>
</div>

@endsection