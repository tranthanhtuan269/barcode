@extends('layouts_frontend.master')
@if(isset($data))
@section('title', isset($data->seo_title) ? $data->seo_title : $data->name . ' - ' . $data->barcode)
@section('description',isset($data->seo_description) ? $data->seo_description : $data->name . ' - ' . $data->barcode)
@section('keywords', isset($data->keywords) ? $data->keywords : $data->name . ' - ' . $data->barcode)
@section('robots', $data->seo_indexed == 1 ? 'index,follow' : 'noindex,nofollow')
@section('canonical')
@if (!empty($data->name) && !empty($data->barcode))
{{ route('seo-barcode', ['slug' => Illuminate\Support\Str::of($data->name)->slug('-')]) }}
@endif
@stop

@section('facebook_share')
<meta property="og:url" content="{{ url()->full() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ isset($data->name) ? $data->name . '-' . $data->barcode : '' }}" />
<meta property="og:description" content="{{ isset($data->seo_description) ? $data->seo_description : ''}}" />
<meta property="og:image" content="{{ isset($data->image) ? asset('uploads/barcode/'.$data->image) : asset('frontend/images/image_barrcode_df.png')}}" />
@endsection
@endif



@section('content')
<input type="hidden" id="barcode-id" name="barcode-id" value="{{ isset($data->id) ? $data->id : '' }}">
<div style="height:70px"></div>
<!-- box-search -->
@include('layouts_frontend.box_search')
<!-- end -->
<div id="fb-root"></div>
<script defer>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=948925588474904&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@if(isset($data))
<div class="container">
    <div class="row">
        <div class="box_search pb-0 clearfix" style="padding-bottom: 0px">
            @if( !empty($data->barcode) )
            <div class="col-sm-5" style="padding-right: 0px;">
                <div class="image">
                    @if(strlen($data->image) > 0)
                    <?php
                    $list_file = explode(',', $data->image);
                    $check_link_http = false;

                    if (count($list_file) == 1 && strpos($data->image, "http") !== false) {
                        $check_link_http = true;
                    }
                    ?>
                    @if (count($list_file) > 1)
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($list_file as $key => $image)
                            <li data-target="#myCarousel" data-slide-to="{{ $key }}" class="@if ($key == 0) active @endif"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @if ($check_link_http)
                            <div class="item active">
                                <img src="{{ $data->image }}">
                            </div>
                            @else
                            @foreach ($list_file as $key => $image)
                            <div class="item @if ($key == 0) active @endif">
                                <img src="{{ asset('uploads/barcode/'.$image) }}" alt="{{ $image }}">
                            </div>
                            @endforeach
                            @endif
                        </div>

                        @if (count($list_file) > 1)
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        @endif
                    </div>
                    <style>
                        .carousel-inner>.item.active {
                            display: block;
                        }
                    </style>
                    @else
                    <img src="{{ asset('uploads/barcode/' . $data->image) }}" alt="{{$data->barcode}}" width="200" height="200">
                    @endif
                    @else
                    <img src="{{ asset('frontend/images/image_barrcode_df.png') }}" alt="{{$data->barcode}}" width="200" height="200">
                    @endif
                </div>
            </div>
            <div class="col-sm-7">
                <h1>EAN {!! $data->barcode !!}</h1>
                <div class="title">
                    {{ $data->name }}
                </div>
                <div class="info">
                    <p>Model: <b>{!! !empty($data->model) ? $data->model : 'n/a' !!}</b></p>
                </div>
                <div class="info">
                    <p>Manufacturer: <b>{{ !empty($data->manufacturer) ? $data->manufacturer : 'n/a' }}</b></p>
                </div>
                <div class="info">
                    <p>Price: <b id="numFormatResult">{!! !empty($data->avg_price) ? $data->avg_price : 'n/a' !!}</b> <b> {!! !empty($data->currency_unit) ? $data->currency_unit : 'n/a' !!}</b></p>
                </div>
                <p>Share</p>
                <div class="d-flex align-items-center share-box">
                    <div class="fb-like" data-href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fbarcodelive.org%2F?barcode={{ $data->barcode }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                    <div class="fb-share-button" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fbarcodelive.org%2F?barcode={{ $data->barcode }}" class="fb-xfbml-parse-ignore">Share</a></div>
                </div>
                <style>
                    .share-box div:first-child,
                    .share-box div:nth-child(2) {
                        height: 24px !important;
                        line-height: 1.42857143;
                        font-size: 14px;
                    }
                </style>
            </div>

            <div class="col-sm-12">
                <div class="special_search">
                    <div class="detail">
                        <div class="inner clearfix">
                            <div class="label"><img src="{{ asset('frontend/images/product.png') }}" alt="Descriptions"></div>
                            <h2 class="title">Descriptions</h2>
                        </div>
                        <div class="show_content">{!! !empty($data->description) ? $data->description : 'n/a' !!}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="detail special_hold">
                    <div class="inner clearfix">
                        <div class="label"><img src="{{ asset('frontend/images/product.png') }}" alt="Specification"></div>
                        <h2 class="title">Specification</h2>
                    </div>
                    <div class="show_content">{!! !empty($data->spec) ? $data->spec : 'n/a' !!}</div>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="detail feature_hold">
                    <div class="inner clearfix">
                        <div class="label"><img src="{{ asset('frontend/images/product.png') }}" alt="Feature"></div>
                        <h2 class="title">Feature</h2>
                    </div>
                    <div class="show_content">{!! !empty($data->feature) ? $data->feature : 'n/a' !!}</div>
                </div>
            </div>
            @else
            <div class="alert-danger" style="text-align: center;">No data available</div>
            @endif
        </div>
    </div>
</div>
@if(strlen($data->content) > 0)
<div class="container" style="border-top: 2px solid #ddd">
</div>
<!-- --share-- -->
<div id="cal1">&nbsp;</div>
<div id="cal2">&nbsp;</div>
<div id="tooltip" class="arrow_box share-text">
    <span class="share font-size--16 font-weight--600">Share</span>
    <button type="button" class="mt-1 btn-sm btn-twitter copy-noted" onclick="shareSocial('twitter')">
        <img src="{{ asset('frontend/images/twitter_share.svg') }}" width="20" height="20">
    </button>
    <button type="button" class=" mt-2 btn-sm btn-facebook save-noted" onclick="shareSocial('facebook')">
        <img src="{{ asset('frontend/images/fb_share.svg') }}" width="19" height="22">
    </button>
    <button type="button" class="mt-2 btn-facebook social-network" onclick="loadModalShare()">
        <img src="{{ asset('frontend/images/share_yellow.svg') }}" alt="Share" width="19" height="19">
    </button>
</div>
<!-- end -->
<link rel="stylesheet" href="/frontend/css/article.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<input type="hidden" id="keywords_not_good" name="keywords_not_good" value="{{ isset($keywords_not_good) ? $keywords_not_good : '' }}">
<input type="hidden" id="type-comment" name="type-comment" value="{{ config('batv_config.TYPE_COMMENT_BARCODE') }}">
<div class="container  container-article mb-4 page detail-article" style="padding-top:0px">
    <div class="content py-4" id="content-find" style="padding-top:0px">
        @if(strlen($data->title_content) > 0)
        <p class="title_content text-center h1 text-bold">{{ $data->title_content }}</p>
        @endif
        @include('layouts_frontend/contentoftable', ['article' => $data])
        <div id="content-find" class="content">
            {!! $data->content !!}
        </div>
    </div>
    @if(!empty($data->list_ask))
    <?php $list_ask = json_decode($data->list_ask); ?>
    <div class="fqa py-4">
        <div class="title_faq">Customer questions and answers</div>
        <div class="intro-faqs pb-3">
            {!! $data->intro_faq !!}
        </div>
        <div class="list-fqa">
            @foreach($list_ask as $value)
            <div class="item-fqa">
                <div class="toplist-fqa">
                    <div class="title-fqa">
                        {!! $value->question !!}
                    </div>
                    <div class="caret-fqa">
                        <span class="glyphicon" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="botlist-fqa">{!! $value->answer !!}</div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        $('.item-fqa:not(:first-child) .caret-fqa span').addClass('glyphicon-menu-down');
        $('.item-fqa:first-child .caret-fqa span').addClass('glyphicon-menu-up');
        $('.toplist-fqa').click(function() {
            $(this).parent().children('.botlist-fqa').slideToggle(300);
            $(this).children().children('.glyphicon').toggleClass('glyphicon-menu-down glyphicon-menu-up')
        });
    </script>
    @endif

    @include('layouts_frontend.components.related-article', ['articles' => $related_articles])

    <!-- comment -->
    <section class="comment-section mt-4">
        <div class="title d-flex align-items-center justify-content-between">
            <p class="mb-0"><span id="total-comment">{{$data->totalComment()}}</span> Comments</p>
            <div class="d-flex align-items-center">
                <span class="mr-2">Filter</span>
                <select class="comment-select">
                    <option value="1">Newest</option>
                    <option value="2">Oldest</option>
                </select>
            </div>
        </div>
        <div class="content">
            <ol class="list-comment list-comment-0">
                @foreach($data->commentsRoot as $com)
                @include('layouts_frontend.comment', ['com' => $com])
                @endforeach
            </ol>
        </div>
        <div class="repond repond-0 mt-4">
            <p class="title mb-0">
                Leave a Comment
            </p>
            <small>
                Your email address will not be published. Required fields are marked *
            </small>
            <form class="comment-form">
                <div class="fill-comment fill-comment-0">
                    <textarea id="comment-0" rows="5" cols="80" maxlength="65525" class="form-control comment-0" placeholder="Comment*"></textarea>
                </div>
                <div class="fill-author fill-author-0">
                    <input id="author-0" type="text" name="author" placeholder="Name*" class="form-control author author-0">
                </div>
                <div class="fill-email fill-email-0">
                    <input id="email-0" type="email" name="email" placeholder="Email*" class="form-control email email-0">
                </div>
                <div class="submit-form">
                    <div class="btn btn-submit-comment" data-id="0">
                        Submit Comment
                    </div>
                </div>
            </form>
        </div>
        <style type="text/css">

        </style>
    </section>
    <script src="{{ url('frontend/js/comment.js') }}"></script>
    <!-- end -->
</div>
<script>
    $(document).ready(function() {
        var flag_check_social_network = 0;
        loadModalShare = function() {
            if (flag_check_social_network == 0) {
                $.ajax({
                    url: "{{ url('/') }}/ajax/templateShareSocial",
                    method: "GET",
                    dataType: 'html',
                    beforeSend: function() {
                        $(".ajax_waiting").addClass("loading");
                    },
                    complete: function() {
                        $(".ajax_waiting").removeClass("loading");
                    },
                    success: function(response) {
                        flag_check_social_network++;
                        $('body').append(response)
                        $('#socialModal').modal('show');
                    },
                });
            } else {
                $('#socialModal').modal('show');
            }
        }
        let postUrl = encodeURI(document.location.href);
        $('.social-facebook').click(function() {
            window.open(`https://www.facebook.com/sharer.php?u=${postUrl}`, "", "width=500,height=600");
        })
        $('.social-twitter').click(function() {
            window.open(`https://twitter.com/share?url=${postUrl}&text={{ $data->name }}`, "", "width=500,height=600");
        })

        var ele = document.getElementById('tooltip');
        var sel = window.getSelection();
        var rel1 = document.createRange();
        rel1.selectNode(document.getElementById('cal1'));
        var rel2 = document.createRange();
        rel2.selectNode(document.getElementById('cal2'));

        if (window.innerWidth < 768) {
            document.addEventListener("selectionchange", function(event) {
                setTimeout(function() {
                    if (window.getSelection) {
                        content_noted = window.getSelection();
                        if (content_noted.rangeCount) {
                            var container = document.createElement("div.c-content");
                            for (var i = 0, len = content_noted.rangeCount; i < len; ++i) {
                                container.appendChild(content_noted.getRangeAt(i).cloneContents());
                            }
                            content_noted = container.innerHTML;
                        }

                        if (content_noted != '') {
                            var r = sel.getRangeAt(0).getBoundingClientRect();
                            var rb1 = rel1.getBoundingClientRect();
                            var rb2 = rel2.getBoundingClientRect();
                            ele.style.top = (r.bottom - rb2.top) * 100 / (rb1.top - rb2.top) + 'px';
                            ele.style.left = (r.left - rb2.left) * 100 / (rb1.left - rb2.left) + 'px';
                            $('#tooltip').addClass('show')
                        } else {
                            $('#tooltip').removeClass('show')
                        }
                    } else if (document.content_noted) {
                        content_noted.selection = document.content_noted.createRange();
                    }
                }, 100);

            });
        } else {
            $("#content-find input[type=image], #content-find img").mouseover(function() {
                $(".arrow_box").removeClass('show')
                if ($(this).parent().find('.arrow_box').length === 0) {
                    $(this).parent().css("position", "relative")
                    const html = `<div id="tooltip" class="arrow_box show tooltip_img">
                                                <span class="share font-size--16 font-weight--600">Share</span>
                                                <button type="button" class="mt-1 btn-sm btn-twitter copy-noted" onclick="shareSocialImg('twitter')">
                                                    <img src="{{ asset('frontend/images/twitter_share.svg') }}" width="20" height="20">
                                                </button>
                                                <button type="button" class=" mt-2 btn-sm btn-facebook save-noted" onclick="shareSocialImg('facebook')">
                                                    <img src="{{ asset('frontend/images/fb_share.svg') }}" width="19" height="22">
                                                </button>
                                                <button type="button" class="mt-2 btn-facebook social-network" onclick="loadModalShare()">
                                                    <img src="{{ asset('frontend/images/share_yellow.svg') }}" alt="Share" width="19" height="19">
                                                </button>
                                            </div>`
                    $(this).parent().append(html)
                } else {
                    $(this).parent().find('.arrow_box').addClass('show')
                }
            });

            $('#content-find').click(function(e) {
                e.stopPropagation();
            });

            $('body').click(function() {
                $(".arrow_box").removeClass('show');
            });

            $('#content-find').bind('mouseup', function(e) {
                e.stopPropagation();
                if (window.getSelection) {
                    content_noted = window.getSelection();
                    if (content_noted.rangeCount) {
                        var container = document.createElement("div.c-content");
                        for (var i = 0, len = content_noted.rangeCount; i < len; ++i) {
                            container.appendChild(content_noted.getRangeAt(i).cloneContents());
                        }
                        content_noted = container.innerHTML;
                    }
                    if (content_noted != '') {
                        var r = sel.getRangeAt(0).getBoundingClientRect();
                        var rb1 = rel1.getBoundingClientRect();
                        var rb2 = rel2.getBoundingClientRect();
                        ele.style.top = (r.bottom - rb2.top) * 100 / (rb1.top - rb2.top) - 90 + 'px';
                        ele.style.right = (window.innerWidth - 728) / 2 - 90 + 'px';
                        $('.arrow_box').removeClass('show');
                        $('.arrow_box.share-text').addClass('show')
                    } else {
                        $('arrow_box.share-text').removeClass('show')
                    }
                } else if (document.content_noted) {
                    content_noted.selection = document.content_noted.createRange();
                }
                return false;
            });
        }

        url_share = '{{ url()->current() }}';
        shareSocialImg = function(social) {
            if (social == 'facebook') {
                window.open('https://www.facebook.com/sharer.php?u=' + url_share, '_blank', "width=500,height=600");
            } else {
                if (content_noted.length > 280) {
                    content_noted = content_noted.substring(0, 280);
                }
                if (content_noted == '') {
                    content_noted = '{{ $data->name }}';
                }
                window.open('https://twitter.com/share?url=' + url_share + '&text=' + content_noted, '_blank', "width=500,height=600");
            }
        }

        shareSocial = function(social) {
            if (social == 'facebook') {
                if (content_noted.indexOf('<img ') !== -1) {
                    var elem = document.createElement("body");
                    elem.innerHTML = content_noted;
                    var images = elem.getElementsByTagName("img");

                    for (var i = 0; i < images.length; i++) {
                        url_share = images[i].src;
                    }
                    content_noted = '';
                }

                if (content_noted.indexOf('type="image"') !== -1) {
                    var elem = document.createElement("body");
                    elem.innerHTML = content_noted;
                    var images = elem.getElementsByTagName("input");
                    for (var i = 0; i < images.length; i++) {
                        url_share = images[i].src;
                    }

                    content_noted = '';
                }
            }

            content_noted = content_noted.trim();
            content_noted = content_noted.replace('&nbsp;', ' ');
            content_noted = content_noted.replace(/<[^>]*>?/gm, '');
            content_noted = content_noted.replace(/(\r\n|\n|\r)/gm, "");

            if (social == 'facebook') {
                window.open('https://www.facebook.com/sharer.php?u=' + url_share, '_blank', "width=500,height=600");
            } else {
                if (content_noted.length > 280) {
                    content_noted = content_noted.substring(0, 280);
                }

                if (content_noted == '') {
                    content_noted = '{{ $data->name }}';
                }

                window.open('https://twitter.com/share?url=' + url_share + '&text=' + content_noted, '_blank', "width=500,height=600");

            }
        }

        var scrollDistance = 300;
        var initialScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        window.addEventListener("scroll", function() {
            var currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            var scrolledDistance = Math.abs(currentScrollPosition - initialScrollPosition);
            if (scrolledDistance >= scrollDistance) {
                const elements = document.querySelectorAll('.arrow_box');
                elements.forEach((element) => {
                    element.classList.remove('show');
                })
                initialScrollPosition = currentScrollPosition;
            }
        });
    })
</script>
@endif
@else
<div class="container container-article">
    <div class="py-3">
        <h1 class="h2 text-danger text-center">Not found</h1>
    </div>
</div>
@endif
<div style="padding-bottom: 25px"></div>
@endsection