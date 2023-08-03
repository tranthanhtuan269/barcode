<div class="container-most-view-article">
    @foreach($articles as $value)
    <div class="item mb-3">
        <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">
            <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
        </a>
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
<style>
    .container-most-view-article {
        display: grid;
        grid-gap:0px 20px;
        grid-template-columns: repeat(4, 1fr);
    }

    @media (max-width: 992px) {
        .container-most-view-article {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .container-most-view-article {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 575px) {
        .container-most-view-article {
            grid-template-columns: 1fr;
        }
    }
</style>