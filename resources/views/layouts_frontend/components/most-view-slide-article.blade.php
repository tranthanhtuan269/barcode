<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<div class="content slide" style="position:relative">
    <div class="swiper slide-related w-100">
        <div class="swiper-wrapper">
            @foreach($articles as $value)
            <div class="swiper-slide item">
                <div class="w-100">
                    <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default w-100">
                        <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
                    </a>
                </div>
                <div class="content pt-2">
                    <h3 class="pt-2 pt-md-0 title-article">
                        <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">{{ $value->title }}
                        </a>
                    </h2>
                    @include('layouts_frontend.components.information-article', ['data' => $value])
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="btn-prev-related"></div>
    <div class="btn-next-related"></div>
</div>
<script type="text/javascript">
    var swiper = new Swiper('.slide-related', {
        slidesPerView: 4,
        spaceBetween: 24,
        loop: true,
        autoplay: false,
        navigation: {
            nextEl: ".btn-next-related",
            prevEl: ".btn-prev-related"
        },
        breakpoints: {
            0: {
                slidesPerView: 1.5,
                spaceBetween: 8,
                centeredSlides: true,
            },
            575: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 16
            },
            1200: {
                spaceBetween: 24
            }
        }
    });
</script>
<style type="text/css">
    .see-all-related {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }
    .btn-prev-related {
        background-image: url(/frontend/images/ic_prev_new.png) ;
        background-position:center;
        background-size:cover;
        width:30px;
        height:30px;
        position:absolute;
        left:-36px;
        top:25%;
        cursor:pointer
    }
    .btn-next-related {
        background-image: url(/frontend/images/ic_next_new.png) ;
        background-position:center;
        background-size:cover;
        width:30px;
        height:30px;
        position:absolute;
        right:-36px;
        top:25%;
        cursor:pointer
    }

    @media (max-width:768px) {
        .btn-prev-related, .btn-next-related {
            display:none;
        }
    }
</style>