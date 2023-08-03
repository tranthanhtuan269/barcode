<?php
$text = $article->content_json;
if (strlen($text) > 0) {
    $objects = json_decode($text);
} else {
    $objects = [];
}
$count = 0;
?>
@if (count($objects) > 0)
<div class="content-of-table pl-sm-4">
    <div class="title-table">
        Table of contents
    </div>

    <div class="content-table">
        @foreach ($objects as $k => $obj)
        <div class="item-table">
            @if ($obj->name == 'h2')
            @php $count++; @endphp
            <div class="h2-class" data-class="{{ $count }}">
                <span class="fa fa-menu-right" aria-hidden="true"></span>
                <a href="{{ url()->current() }}#{{ $obj->tag }}">
                    {{-- --}}
                    {{ $obj->value }}
                </a>
            </div>
            @elseif($obj->name == 'h3')
            <div class="space-h3 count-{{ $count }} hide">
                <a href="{{ url()->current() }}#{{ $obj->tag }}">
                    {{-- --}}
                    {{ $obj->value }}
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif
<style type="text/css">
    .hide {
        display: none;
    }

    .show {
        display: block;
    }

    .h2-class i {
        margin-right: 10px;
    }

    .space-h3 {
        padding-left: 26px;
    }

    .space-h3:before {
        margin-right: 8px;
        content: "\2022";
    }

    span.fa {
        padding-left:26px;
        position: relative;
    }

    span.fa::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center;
    }

    span.fa.fa-menu-right::before {
        background-image: url(/frontend/images/arrow_right_table_content_black.svg);
    }

    span.fa.fa-menu-down::before {
        background-image: url(/frontend/images/angle-down-black2.svg);
    }
</style>
<script>
    $(document).ready(function() {
        $('.h2-class .fa').click(function() {
            if($('.count-' + $(this).parent().attr('data-class')).length > 0) {
                if ($(this).hasClass('fa-menu-right')) {
                    $(this).removeClass('fa-menu-right').addClass('fa-menu-down')
                    $('.count-' + $(this).parent().attr('data-class')).removeClass('hide');
                } else {
                    $(this).removeClass('fa-menu-down').addClass('fa-menu-right')
                    $('.count-' + $(this).parent().attr('data-class')).addClass('hide');
                }
            }
        })

        $('.h2-class a, .space-h3 a').on('click', function() {
            $('html, body').animate({
                scrollTop: $(this.hash).offset().top - 80
            }, 200);
            return false;
        });

        $.each($('iframe'), function (key, val) {
            if($(val).attr('src').indexOf('//www.slideshare.net/') != -1) {
                $(val).wrap('<div class="iframe-slideshare-16x9"></div>');
                $(val).attr('frameborder', 0);
                $(val).attr('marginwidth', 0);
                $(val).attr('marginheight', 0);
                $(val).attr('scrolling', 'no');
                $(val).attr('allowFullScreen', '')
            }
            if($(val).attr('src').indexOf('https://www.youtube.com/') != -1) {
                $(val).addClass('video')
            }
        });

        $.each($('table'), function (key, val) {
            const element = $(val);
            if(element.hasClass('table-background')) {
                const arrClass = element.attr("class").split(" ")
                $.each(arrClass, function (key, value) {
                    if(value.indexOf("background-th-") != -1) {
                        const backgroundColor = value.replace('background-th-', '', 1)
                        element.children('thead').css('background-color', backgroundColor)
                    }
                    if(value.indexOf("color-th-") != -1) {
                        const textColor = value.replace('color-th-', '', 1)
                        element.children('thead').css('color', textColor)
                    }
                    if(value.indexOf("background-tr-") != -1) {
                        const arrColor = value.replace('background-tr-', '', 1).split('-')
                        element.children('tbody').children('tr').css('background-color', arrColor[0])
                        if(arrColor.length === 2) {
                            element.children('tbody').children('tr:nth-child(even)').css('background-color', arrColor[1])
                        }   
                    }
                    if(value.indexOf("color-tr-") != -1) {
                        const textColor = value.replace('color-tr-', '', 1)
                        element.children('tbody').children('tr').css('color', textColor)
                    }
                })
            }
        });

    })
</script>