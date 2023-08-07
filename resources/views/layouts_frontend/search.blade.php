@extends('layouts_frontend.master')

@section('title', 'Search keyword: ' . isset($_GET['search']) ? $_GET['search'] : '')

@section('content')

<div class="special"></div>
<div class="search page list-article-new">
    <div class="container">
        <!-- breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
        </nav>
        <!-- end -->
        <div class="row">
            <!-- search -->
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="box-search w-100 mb-4">
                    @if(isset($_GET['search']))
                    <input type="text" id="search-input" class="w-100" value="{{$_GET['search']}}">
                    @else
                    <input type="text" id="search-input" class="w-100">
                    @endif
                    <img src="{{ asset('frontend/images/ic_search.svg') }}" alt="search" class="btn-search" style="width:26px;height:26px">
                    <div class="dropdown-result-search" tabindex="3">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>
        <div class="row">
            @if(count($news)>0)
            <div class="col-xs-12 content pt-3">
                @foreach ($news as $key => $value)
                <div class="item">
                    <div class="row py-2">
                        <div class="col-xs-12 col-sm-4 pb-2 pb-md-0">
                            <a href="/{{ $value->slug }}" title="{{ $value->title }}" class="link-default">
                                <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <h3 class="pt-md-0">
                                <a href="/{{ $value->slug }}" title="{{ $value->title }}" class="link-default">{{ $value->title }}
                                </a>
                            </h3>
                            <div class="cat-title pb-2 pb-md-0">
                                {!! $value->description !!}
                            </div>
                            @include('layouts_frontend.components.information-article', ['data' => $value, 'full' => 1])
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-xs-12">
                    <div class="b-page justify-content-center pt-5 d-flex">
                        {{ $news->appends(Request::all())->links() }}
                    </div>
                </div>
            </div>
            @else
                <div>
                    <h2 class="text-center text-danger mt-3 ">No Results found</h2>
                    <h2 class="text-center " style="border-bottom:1px solid #fff; padding-bottom:0.5rem">Nominate Posts</h2>
                </div>
                @foreach ($news_nominate as $key => $value)
                <div class="item col-xs-12">
                    <div class="row py-2">
                        <div class="col-xs-12 col-sm-4 pb-2 pb-md-0">
                            <a href="/{{ $value->slug }}" title="{{ $value->title }}" class="link-default">
                                <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <h3 class="pt-md-0">
                                <a href="/{{ $value->slug }}" title="{{ $value->title }}" class="link-default">{{ $value->title }}
                                </a>
                            </h3>
                            <div class="cat-title pb-2 pb-md-0">
                                {!! $value->description !!}
                            </div>
                            @include('layouts_frontend.components.information-article', ['data' => $value, 'full' => 1])
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-xs-12">
                    <div class="b-page justify-content-center pt-5 d-flex">
                        {{ $news_nominate->appends(Request::all())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ url('frontend/js/search.js') }}"></script>

@endsection