@extends('layouts_frontend.master')

@section('title', isset($data->seo_title) ? $data->seo_title : $data->title)

@section('description',$data->seo_description)

@section('keywords', $data->keywords)
@section('facebook_share')
<meta property="og:url"           content="{{ url()->full() }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{ $data->seo_title }}" />
<meta property="og:description"   content="{{ $data->seo_description }}" />
<meta property="og:image"         content="{{ asset('filemanager/data-images/' . $data->image) }}" />
@endsection

@section('content')
<div class="special"></div>
<!-- --share-- -->
<div id="cal1">&nbsp;</div>
<div id="cal2">&nbsp;</div>
<div id="tooltip" class="arrow_box share-text">
    <span class="share font-size--16 font-weight--600">Share</span>
    <button type="button" class="mt-1 btn-sm btn-twitter copy-noted" onclick="shareSocial('twitter')">
        <img src="{{ asset('frontend/images/twitter_share.svg') }}" width="20" height="20" alt="twitter share">
    </button>
    <button type="button" class=" mt-2 btn-sm btn-facebook save-noted" onclick="shareSocial('facebook')">
        <img src="{{ asset('frontend/images/fb_share.svg') }}" width="19" height="22" alt="fb share">
    </button>
    <button type="button" class="mt-2 btn-facebook social-network" onclick="loadModalShare()">
        <img src="{{ asset('frontend/images/share_yellow.svg') }}" alt="Share" width="19" height="19">
    </button>
</div>
<!-- end -->

<div class="main-content detail-article page" id="min-height-3" data-article-id="{{$data->id}}">
    <link rel="stylesheet" href="/frontend/min/article.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<input type="hidden" id="keywords_not_good" name="keywords_not_good" value="{{ isset($keywords_not_good) ? $keywords_not_good : '' }}">
	<input type="hidden" id="type-comment" name="type-comment" value="{{ config('batv_config.TYPE_COMMENT_ARTICLE') }}">
    <div class="container">
    <?php
        $id_child = \App\Helpers\Helper::arrCategoriesParent($data->cat_id, 'article_categories');
        $arr_cat_id = \App\Helpers\Helper::array_keys_multi($id_child);
        $ids_ordered = implode(',', array_reverse($arr_cat_id));

        if (!empty($ids_ordered)) {
            $data_breadcrumb = \App\Models\ArticleCategory::select('id', 'slug', 'title')->whereIn('id', $arr_cat_id)->orderByRaw("FIELD(id, $ids_ordered)")->get();
            $breadcrumb = [];

            foreach ($data_breadcrumb as $value) {
                $breadcrumb[] = ["link" => route('client.show-cat-article', ['slug' => $value->slug]), "name"=> $value->title];
            }
        }

        $breadcrumb[] = ["link"=>"#", "name"=> $data->title];
    ?>
    @include('layouts_frontend.breadcrumb', $breadcrumb)
    </div>
    <div class="container container-article">
        <div class="clearfix">
            <h1 class="text-center">{{ $data->title }}</h1>
            <p class="text-center view mb-0">{{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->post_public_time, 'M d, Y')}} - Views: {{ $data->count_view }}
                <span class="share top"> Share </span>
                <a class="social-twitter"><img src="{{ asset('frontend/images/twitter_share.svg') }}" alt="twitter_share" class="mb-1"  width="20" height="20"></a>
                <a class="social-facebook"><img class="mb-1" src="{{ asset('frontend/images/fb_share.svg') }}" alt="fb_share" width="19" height="22"></a> 
                <a href="javascript:void(0)" class="social-network" onclick="loadModalShare()"><img class="mb-1" src="{{ asset('frontend/images/share_yellow.svg') }}" alt="share" width="19" height="19"></a>
            </p>
            <div class="mt-2 box-rate d-flex align-items-center justify-content-center">
                <div class="p-0 rateYo"></div>
                <div class="d-flex content ml-3">
                    <span>Rating: <span class="detail-rate ml-1">{{number_format($data->rate,1)}} </span></span>
                    <span class="mx-1"> - </span>
                    <span><span class="detail-vote mr-1"> {{$data->number_rate}}</span>Votes</span>
                </div>
            </div>
        </div>
        <div class="content pt-3" id="content-find">
            {!! $data->intro !!}
            @include('layouts_frontend/contentoftable', ['article' => $data])

            {!! $data->content !!}
        </div>

        @if(!empty($data->list_ask))
        <?php $list_ask = json_decode($data->list_ask); ?>
        <div class="fqa py-4">
            <div class="title_faq" >Frequently Asked Questions (FAQs)</div>
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
            $('.toplist-fqa').click(function(){
                $(this).parent().children('.botlist-fqa').slideToggle(300);
                $(this).children().children('.glyphicon').toggleClass('glyphicon-menu-down glyphicon-menu-up')
            });
        </script>
        @endif
        @if (!empty($data->ending))
            {!! $data->ending !!}
        @endif
        <!-- chan trang -->
        <div class="align-items-center justify-content-between d-md-flex ">
            <div class="box-rate d-flex align-items-center">
                <div class="p-0 rateYo"></div>
                <div class="d-flex content ml-3">
                    <span>Rating: <span class="detail-rate ml-1">{{number_format($data->rate,1)}}</span></span>
                    <span class="mx-1">-</span>
                    <span><span class="detail-vote mr-1">{{$data->number_rate}}</span>Votes</span>
                </div>
            </div>
            <div class="d-flex">
                <span class="share"> Share </span>
                <a class="social-twitter"><img src="{{ asset('frontend/images/twitter_share.svg') }}" alt="twitter" class="mb-1"  width="20" height="20"></a>
                <a class="social-facebook mx-1"><img class="mb-1" src="{{ asset('frontend/images/fb_share.svg') }}" alt="facebook" width="19" height="22"></a> 
                <a href="javascript:void(0)" onclick="loadModalShare()" class="social-network" ><img class="mb-1" src="{{ asset('frontend/images/share_yellow.svg') }}" alt="share" width="19" height="19"></a>
            </div>
            <script>
                $(document).ready(function() {
                    var flag_check_social_network = 0;
                    loadModalShare = function() {
                        if (flag_check_social_network == 0) {
                            $.ajax({
                                url: "{{ url('/') }}/ajax/templateShareSocial",
                                method: "GET",
                                dataType:'html',
                                beforeSend: function() {
                                    $(".ajax_waiting").addClass("loading");
                                },
                                complete: function() {
                                    $(".ajax_waiting").removeClass("loading");
                                },
                                success: function (response) {
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
                    $('.social-facebook').click(function(){
                        window.open(`https://www.facebook.com/sharer.php?u=${postUrl}`, "", "width=500,height=600"); 
                    })
                    $('.social-twitter').click(function(){
                        window.open(`https://twitter.com/share?url=${postUrl}&text={{ $data->title }}`, "", "width=500,height=600"); 
                    })
    
                    var ele = document.getElementById('tooltip');
                    var sel = window.getSelection();
                    var rel1= document.createRange();
                    rel1.selectNode(document.getElementById('cal1'));
                    var rel2= document.createRange();
                    rel2.selectNode(document.getElementById('cal2'));
    
                    if( window.innerWidth < 768) {
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
                        $("#content-find input[type=image], #content-find img").mouseover(function(){
                            $(".arrow_box").removeClass('show')
                            if ($(this).parent().find('.arrow_box').length === 0) {
                                $(this).parent().css("position", "relative")
                                const html = `<div id="tooltip" class="arrow_box show tooltip_img">
                                                <span class="share font-size--16 font-weight--600">Share</span>
                                                <button type="button" class="mt-1 btn-sm btn-twitter copy-noted" onclick="shareSocialImg('twitter')">
                                                    <img src="{{ asset('frontend/images/twitter_share.svg') }}" width="20" height="20" alt="twitter share">
                                                </button>
                                                <button type="button" class=" mt-2 btn-sm btn-facebook save-noted" onclick="shareSocialImg('facebook')">
                                                    <img src="{{ asset('frontend/images/fb_share.svg') }}" width="19" height="22" alt="fb share">
                                                </button>
                                                <button type="button" class="mt-2 btn-facebook social-network" onclick="loadModalShare()">
                                                    <img src="{{ asset('frontend/images/share_yellow.svg') }}" alt="Share" width="19" height="19">
                                                </button>
                                            </div>`
                                $(this).parent().append(html)
                            }else{
                                $(this).parent().find('.arrow_box').addClass('show')
                            } 
                        });
    
                        $('#content-find').click(function(e) {
                            e.stopPropagation();
                        });
    
                        $('body').click(function() { 
                            $(".arrow_box").removeClass('show');
                        });
    
                        $('#content-find').bind('mouseup', function(e){
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
                                    ele.style.top = (r.bottom - rb2.top)*100/(rb1.top-rb2.top) - 90 + 'px';
                                    ele.style.right = (window.innerWidth - 728)/2 - 90 + 'px';
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
                                content_noted = '{{ $data->title }}';
                            }
                            window.open('https://twitter.com/share?url='+ url_share +'&text=' + content_noted, '_blank', "width=500,height=600");
                        }
                    }
    
                    shareSocial = function(social) {
                        if (social == 'facebook') {
                            if (content_noted.indexOf('<img ') !== -1) {
                                var elem= document.createElement("body");
                                elem.innerHTML = content_noted;
                                var images = elem.getElementsByTagName("img");
    
                                for(var i=0; i < images.length; i++){
                                    url_share = images[i].src;
                                }
                                content_noted = '';
                            }
                    
                            if (content_noted.indexOf('type="image"') !== -1) {
                                var elem= document.createElement("body");
                                elem.innerHTML = content_noted;
                                var images = elem.getElementsByTagName("input");
                                for(var i=0; i < images.length; i++){
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
                                content_noted = '{{ $data->title }}';
                            }
    
                            window.open('https://twitter.com/share?url='+ url_share +'&text=' + content_noted, '_blank', "width=500,height=600");
                            
                        }
                    }
    
                    var scrollDistance = 300;
                    var initialScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    window.addEventListener("scroll", function() {
                        var currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                        var scrolledDistance = Math.abs(currentScrollPosition - initialScrollPosition);
                        if (scrolledDistance >= scrollDistance) {
                            const elements = document.querySelectorAll('.arrow_box');
                            elements.forEach((element)=>{
                                element.classList.remove('show');
                            })
                            initialScrollPosition = currentScrollPosition;
                        }
                    });
                })
            </script>
        </div>
        <!-- end -->

        @include('layouts_frontend.components.related-article', ['articles' => $relateds, 'link_all_posts' => (url('/') .'/'.$data->cat_slug)])

        <!-- comment -->
        <section class="comment-section mt-4">
            <div class="title d-flex align-items-center justify-content-between">
                <p class="mb-0" ><span id="total-comment">{{$totalComments}}</span> Comments</p>
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
                        <input id="author-0" type="text" name="author" placeholder="Name*" class="form-control author author-0" >
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
        <script src="{{ url('frontend/min/comment.js') }}"></script>
        <!-- end -->
    </div>
</div>

<!-- rate -->
<script>
    var rateSave = {{$data->rate}};
    var id = {{$data->id}};
    var list_rate = [];
    var rate_before = 0;
    $(".rateYo").rateYo({
        starWidth: "20px",
        spacing: "6px",
        numStars:5,
        fullStar: true,
        rating: rateSave,
        maxValue:5,
        precision: 5,
        normalFill: "#626f97",
        ratedFill: "#ffca70"
    })
    $(".rateYo").rateYo().on("rateyo.set", function (e, data) {
        if(localStorage.getItem("Rate")!=null) {
            list_rate = JSON.parse(localStorage.getItem("Rate"));
            for(let i = 0; i<list_rate.length; i++) {
                if(list_rate[i].id==id) {
                    rate_before = list_rate[i].rate
                    list_rate.splice(i,1)
                }
            }
        }
        let rate = data.rating;
        let rate_item = {id:id, rate:rate}
        list_rate.push(rate_item)
        let JsonRate = JSON.stringify(list_rate)
        localStorage.setItem('Rate',JsonRate)
        $.ajax({
            data: {
                "id": id,
                "rate" : rate,
                "rate_before": rate_before
            },
            url:'/ajax/rate',
            success:function(res) {
                Swal.fire({
                    title: 'success',
                    text: "Thank you!",
                    icon: 'success',
				})
                $('.detail-rate').html(res.rate);
                $('.detail-vote').html(res.vote);
            }

        })
    })
</script>
<!-- end -->

<!-- modal-share -->
<script>
    //active blog
    var cat_id = {{$data->cat_id}}
    var arr_cat_id = JSON.parse("{{json_encode($arr_cat_id)}}")
    if(cat_id == 16) {
        $('.default.news').addClass('active')
    }else if(arr_cat_id.includes(32)){
        $('.default.tips').addClass('active')
    }else {
        $('.default.blog').addClass('active')
    }

    // add target_blank
    $.each($('#content-find').find('a'), function (key, val) {
        $(val).attr('target','_blank')
    });
</script>
<!-- end -->

@endsection