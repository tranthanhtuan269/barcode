<div class="container-article">
    @foreach($articles as $value)
    <div class="item column-article">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pb-2 pb-md-0">
                <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">
                    <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
                </a>
            </div>
            <div class="col-xs-12 col-sm-6">
                <h3 class="pt-md-0 title-article">
                    <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">{{ $value->title }}
                    </a>
                </h3>
                <div>
                    <span class="sub-text" style="font-style:italic; font-size:16px">
                        {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $value->post_public_time, 'M d, Y')}}
                    </span>
                </div>
                @include('layouts_frontend.components.information-article', ['data' => $value])
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .container-article {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .column-article {
        flex: 1 1 calc(50% - 10px);
        margin: 0;
        flex-shrink: 0;
    }


    @media (max-width: 575px) {
        .column-article{
            flex-basis: 100%;
        }
    }
</style>