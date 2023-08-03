@extends('layouts_frontend.master')

@section('title', isset($page->seo_title) ? $page->seo_title : "Barcodelive - Look up millions of products details globally")

@section('description',isset($page->seo_description) ? $page->seo_description : "Is the product that you've purchased real or fake? It's easy to barcode check with barcodelive. Take a barcode lookup & you see details: origin, feature, model... ")
@section('keywords', isset($page->keywords) ? $page->keywords : "Barcodelive")
@section('content')

<div style="height:70px"></div>
@include('layouts_frontend.box_search')
<section class="box_1">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="item_left">
					<h2 class="size-h2">SEARCH INFORMATION OF ANY PRODUCTS - INSTANTLY!</h2>
					<p class="description">
						By simply typing in the item's barcode number at Barcode Live, you can get information about millions of products worldwide, including: photos, name, model, manufacturer, and product reviews. We will use our huge database of barcodes, product data, as well as data from retailers and e-commerce sites to provide you with the most useful and accurate information on any product you are interested in.
					</p>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<img src="{{ asset('frontend/images/product_search.jpg') }}" alt="Search Infomation Of Any Products">
			</div>
		</div>
	</div>
</section>
<section class="box_2">
	<div class="container">
		<div class="content">
			<div class="list-left">
				<div class="item">
					<img src="{{ asset('frontend/images/upc.svg') }}" alt="Universal Product Codes">
					<div class="des">
						<h3>UPC – UNIVERSAL PRODUCT CODES</h3>
						<p class="description">UPC consists of 12 numeric digits, which are uniquely assigned to each trade item. They are used in many countries to track trade items in stores, such as the United States, Canada, United Kingdom, Australia, New Zealand, etc.</p>
					</div>
				</div>
				<div class="item">
					<img src="{{ asset('frontend/images/EAN.svg') }}" alt="International (European) Article Number">
					<div class="des">
						<h3>EAN – INTERNATIONAL (EUROPEAN) ARTICLE NUMBER</h3>
						<p class="description">EAN is a standard describing a barcode symbology and numbering system. It is often used in global trade to identify a specific retail product type, in a specific packaging configuration, from a specific manufacturer. The most commonly used EAN standard is the thirteen-digit EAN-13.</p>
					</div>
				</div>
				<div class="item">
					<img src="{{ asset('frontend/images/ISBN.svg') }}" alt="International Standard Book Number">
					<div class="des">
						<h3>ISBN – INTERNATIONAL STANDARD BOOK NUMBER</h3>
						<p class="description">ISBN is a unique numeric commerical book identifier, which is assigned to each edition and variation (except reprintings) of a book. Publishers purchase ISBNs from an affiliate of the International ISBN Agency.</p>
					</div>
				</div>
			</div>
			<div class="triangle"></div>
			<div class="list-right">
				<h2>BARCODE INTRODUCTION</h2>
				<p>A barcode is an optical, machine-readable, representation of data; the data usually describes something about the object that carries the barcode. Traditional barcodes systematically represented data by varying the widths and spacings of parallel lines, and may be referred to as linear or one-dimensional (1D). At that time, they were only scanned by special optical scanners called barcode readers.</p>
				<p>Later, two-dimensional (2D) variations were developed using rectangles, dots, hexagons and other geometric patterns. They are also called matrix codes or 2D barcodes, although they do not use bars as such. Nowadays, specialized application software became available for devices that could read images, such as smartphones with in-built cameras.</p>					
			</div>
		</div>
	</div>
</section>


<section class="feature-box">
	<div class="container">
		<div class="feature">
			<h2 class="title">
				BARCODELIVE'S KEY FEATURES
			</h2>
			<div class="content">
				<div class="item item-1">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							100% FREE
						</h3>
						<p class="des">
							Barcodelive is totally free. You can use it freely without registering or paying a fee.
						</p>
					</div>
				</div>
				<div class="item item-2">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							NO REGISTRATION
						</h3>
						<p class="des">
							Users just visit barcodelive.org and look for a barcode number without registering an account.
						</p>
					</div>
				</div>
				<div class="item item-3">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							SUPERFAST
						</h3>
						<p class="des">
						Our massive barcode database allows you to barcode lookup and get product data in seconds.
						</p>
					</div>
				</div>
				<div class="item item-4">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							DETAILED
						</h3>
						<p class="des">
							After just a click, you can get full product data such as images, origin, specification, and features.
						</p>
					</div>
				</div>
				<div class="item item-5">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							BENEFICIAL
						</h3>
						<p class="des">
							Barcodelive saves money and times of consumers and sellers.
						</p>
					</div>
				</div>
				<div class="item item-6">
					<div class="top">
					</div>
					<div class="bottom">
						<h3 class="title">
							AVAILABILITY
						</h3>
						<p class="des">
							Users can do a barcode lookup anytime, anywhere with any devices connected to the Internet.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="most-view-article-box">
	<div class="container">
		<div class="most-view-article">
			<h2 class="title pt-3">
				MOST VIEWED
			</h2>
			<div class="content">
				@include('layouts_frontend.components.most-view-article', ['articles' => $mostViewArticles])
			</div>
		</div>
	</div>
</section>
<section class="latest-article-box">
	<div class="container">
		<div class="latest-article">
			<h2 class="title">
				LATEST POSTS
			</h2>
			<div class="content pt-3">
				@include('layouts_frontend.components.latest-article-home', ['articles' => $latestArticles])
			</div>
			<div class="d-flex align-items-center justify-content-center">
				<a class="btn-see-more-home" href="{{ url('/') }}/tips">See more</a>
			</div>
		</div>
	</div>
</section>

<section class="people-say-box">
	<div class="container">
		<div class="people-say">
			<h2 class="title">
				WHAT PEOPLE SAY ABOUT US
			</h2>
			<div class="content">
				<div class="item">
					<div class="box-img">
						<img src="{{ asset('frontend/images/logan_miller.webp') }}" alt="Logan Miller">
					</div>
					<div class="star">
					</div>
					<h3 class="name">
						Logan Miller
					</h3>
					<p class="des">
						Great tool. I looked up lots of products and avoided fake good before buying them.
					</p>
				</div>
				<div class="item">
					<div class="box-img">
						<img src="{{ asset('frontend/images/marcus_patel.webp') }}" alt="Marcus Patel">
					</div>
					<div class="star">
					</div>
					<h3 class="name">
						Marcus Patel
					</h3>
					<p class="des">
						A superfast barcode lookup tool. It doesn't take me too much time as other tools. 
					</p>
				</div>
				<div class="item">
					<div class="box-img">
						<img src="{{ asset('frontend/images/madeleine.webp') }}" alt="Madeleine Hughes">
					</div>
					<div class="star">
					</div>
					<h3 class="name">
						Madeleine Hughes
					</h3>
					<p class="des">
						Excellent tool. Highly recommend using it.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
