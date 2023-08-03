@if(isset($full))
<div class="d-flex align-items-center flex-wrap">
    <div class="d-flex align-items-center mr-3">
        <img class="mr-1" src="{{ url ('/') }}/frontend/images/ic_count_view.svg" alt="view" width="22" height="22">
        <span class="sub-text">{{$data->count_view}}</span>
    </div>
    <div class="d-flex align-items-center mr-3">
        <img src="{{ url ('/') }}/frontend/images/ic_comment.svg" alt="view" width="20" height="20">
        <span class="sub-text">{{count($data->comments)}}</span>
    </div>
    <div class="d-flex align-items-center mr-3">
        <img src="{{ url ('/') }}/frontend/images/ic_rate.svg" alt="view" width="21" height="21">
        <span class="sub-text">{{number_format($data->rate,1)}}</span>
    </div>
    <div class="d-flex align-items-center">
        <img src="{{ url ('/') }}/frontend/images/ic_time_article.svg" alt="view" width="20" height="20">
        <span class="sub-text">
            {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $value->post_public_time, 'M d, Y')}}
        </span>
    </div>
</div>
@else
<div class="d-flex align-items-center flex-wrap" >
    <div class="d-flex align-items-center mr-3">
        <img class="mr-1" src="{{ url ('/') }}/frontend/images/ic_count_view.svg" alt="view" width="22" height="22">
        <span class="sub-text">{{$data->count_view}}</span>
    </div>
    <div class="d-flex align-items-center mr-3">
        <img src="{{ url ('/') }}/frontend/images/ic_comment.svg" alt="view" width="20" height="20">
        <span class="sub-text">{{count($data->comments)}}</span>
    </div>
    <div class="d-flex align-items-center mr-3">
        <img src="{{ url ('/') }}/frontend/images/ic_rate.svg" alt="view" width="20" height="20">
        <span class="sub-text">{{number_format($data->rate,1)}}</span>
    </div>
</div>
@endif