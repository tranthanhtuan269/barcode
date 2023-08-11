<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<link rel="canonical" href="@yield('canonical', url()->current())" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="@yield('description', '')"/>
	<meta name="keywords" content="@yield('keywords', '')">
	<meta name="p:domain_verify" content="586a43c60ec89b5317c8fb476dcaf514"/>
	
	@if(isset($_GET['page']))
  <meta name="robots" content="@yield('robots', 'noindex,follow')">
  @else
  <meta name="robots" content="@yield('robots', 'index,follow')">
  @endif
	
	<meta name="google-site-verification" content="lBrafYhpBGZlRBaiBGKdVLN5vRrtkx3ZENlUPqFJd0o" />
	@if(Request::is('/'))
	<link rel="preload" href="{{ asset('frontend/min/bootstrap.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="{{ asset('frontend/min/bootstrap.min.css') }}"></noscript>

	<link rel="preload" href="{{ asset('frontend/min/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="{{ asset('frontend/min/style.css') }}"></noscript>
	
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/min/style-home.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/min/reponsive.css') }}">
	@else
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/min/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/min/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/min/reponsive.css') }}">
	@endif

	@if(Request::is('/barcode/add'))
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
	@endif
	<link rel="shortcut icon" href="{{{ asset('frontend/images/favion.png') }}}">

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PD4KZZZ');</script>
	<!-- End Google Tag Manager -->

	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1192197198135394');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1192197198135394&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->

	@yield('facebook_share')
	<script src="{{ asset('frontend/min/jquery.min.js') }}"></script>
	<?php
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async defer src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5697888399614839" crossorigin="anonymous"></script>
	
	<script defer src="https://www.googletagmanager.com/gtag/js?id=G-M6WJKPMDR1"></script>
	<script defer>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-M6WJKPMDR1');
	</script>
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PD4KZZZ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" >
      <div class="container">
        <div class="navbar-header" id="header-scroll">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/') }}" style="margin-top:4px">
          	<img src="{{ asset('frontend/images/logo.svg') }}" alt="Barcode Logo" width="65" height="65">
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
		  <li class="default {{ Request::is('/')? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
			<li class="default {{ Request::is('add-barcode') || Request::is('barcode/add')? 'active' : '' }}"><a href="{{ route('getAddBarcodePage')}}">Add barcode</a></li>
			<li class="default tips {{ Request::is('tips')? 'active' : '' }}"><a href="{{ url('/') }}/tips">Tips</a></li>
			<li class="default blog {{ Request::is('blog')? 'active' : '' }}"><a href="{{ url('/') }}/blog">Blog</a></li>
			<li class="default news {{ Request::is('news')? 'active' : '' }}"><a href="{{ url('/') }}/news">News</a></li>
			<li class="default {{ Request::is('app')? 'active' : '' }}"><a href="{{ route('getAppPage')}}">App</a></li>
			<li class="default {{ Request::is('about')? 'active' : '' }}"><a href="{{ route('getAboutPage')}}" rel="nofollow">About</a></li>
          </ul>
        </div>
      </div>
    </nav>
	@yield('content')
	<div class="scroll-top">
		<img src="{{ asset('frontend/images/up-arrow.svg') }}" alt="up arrow" width="21" height="21">
    </div>
	<!-- new-footer -->
	<footer>
		<div class="container">
			<div class="content">
				<div class="">
					<a href="{{ url('/') }}"><img src="{{ asset('frontend/images/logo_footer.svg') }}" alt="logo" class="lazy logo-toh" width="80" height="75"></a>
					<div class="description pt-2  color-text">Barcodelive is one of the leading barcode lookup tools. This tool allows users to barcode lookup for thousands of global products. Also, sellers can add a new product or edit an existing barcode on Barcodelive. This increases business trust and effectiveness. Barcodelive - the best choice for both consumers and sellers. </div>
				</div>
				<div class="">
					<div class="title">BARCODELIVE</div>
					<div class="list-ul">
						<ul class="list-cate">
							{!! $cate_root !!} 
							<li>
								<a href="{{ url('/') }}/faqs">Faqs</a>
							</li>
							<li>
								<a href="{{ url('/') }}/terms-and-conditions" rel="nofollow">Terms and Conditions</a>
							</li>
							<li>
								<a href="{{ url('/') }}/rss/article.xml" rel="nofollow">RSS</a>
							</li>
						</ul>
						<ul class="list-cate">
							{!! $cate_child !!}
						</ul>
					</div>
				</div>
	
				<div class="">
					<div class="title">FOLLOW US</div>
					@if($socials)
						<div class="list-social">
							@foreach ($socials as $social)
								@if(strlen($social->value) > 0)
								<a href="{{ $social->value }}" rel="nofollow" target="_blank" class="fanpage" title="{{ $social->key }}" data-social="1">
									<img src="{{ asset('frontend/images/ic_' . $social->key . '.svg') }}" alt="{{ $social->key }}">
								</a>
								@endif
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="footer-copyright text-center py-2 color-text">© 2017 - {{ date('Y') }} BarcodeLive. All rights reserved.</div>
	</footer>
	<div class="ajax_waiting"></div>
	<script src="{{ asset('frontend/min/bootstrap.min.js') }}"></script>
	@if(Request::is('/barcode/add'))
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	@endif
	@if(!Request::is('/'))
	<script src="{{ asset('frontend/min/sweetalert.min.js') }}"></script>
	<script src="{{ asset('js/general.js') }}"></script>
	<script src="{{ asset('frontend/min/function.js') }}"></script>
	@endif
	<script>
    	var baseURL="<?php echo URL::to('/'); ?>";

		window.onscroll = function(e) {
			//"false" if direction is down and "true" if up
			if(this.oldScroll > this.scrollY && this.scrollY >= 300) {
				$('.scroll-top').fadeIn();
			}else {
				$('.scroll-top').fadeOut();
			}
			this.oldScroll = this.scrollY;
		}

		$(".scroll-top").click(function(o) {
			o.preventDefault(), $("html, body").animate({
				scrollTop: $("body").offset().top - 80
			}, 400)
		});

		$.each($('a'), function (key, val) {
			let link = $(val).attr('href');
			let social = $(val).attr('data-social');
			if(link && link.indexOf("{{ url('/') }}") == -1 && social != 1) {
				$(val).attr('rel','nofollow')
			}
		});
    </script>
</body>
</html>