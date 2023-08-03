@extends('layouts_frontend.master')

@section('title', $info_cat->seo_title)

@section('description', $info_cat->seo_description)

@section('content')
<div class="special"></div>
<div class='main-content page list-blog' id="min-height-3">
    <div class="container">
        <div class="">
			<?php
                $id_child = \App\Helpers\Helper::arrCategoriesParent($info_cat->parent_id, 'article_categories');
                $arr_cat_id = \App\Helpers\Helper::array_keys_multi($id_child);
                $ids_ordered = implode(',', array_reverse($arr_cat_id));
				
                if (!empty($ids_ordered)) {
					$data_breadcrumb = \App\Models\ArticleCategory::select('id', 'slug', 'title')->whereIn('id', $arr_cat_id)->orderByRaw("FIELD(id, $ids_ordered)")->get();
                    $breadcrumb = [];
					
                    foreach ($data_breadcrumb as $value) {
						$breadcrumb[] = ["link" => route('client.show-cat-article', ['slug' => $value->slug]), "name"=> $value->title];
                    }
                }

                $breadcrumb[] = ["link" => "#", "name"=> $info_cat->title];

                $arr_cat_id = \App\Helpers\Helper::arrCategoriesChild($info_cat->id, 'article_categories');
                $list_cat_child = [];
				
                if (count($arr_cat_id) > 0) {
                    $ids_ordered = implode(',', array_reverse($arr_cat_id));
                    $list_cat_child = \App\Models\ArticleCategory::select('id', 'slug', 'title', 'image')->whereIn('id', $arr_cat_id)->orderByRaw("FIELD(id, $ids_ordered)")->get();
                }
				?>
			@include('layouts_frontend.breadcrumb', $breadcrumb)
			<div class="text-center">{!! $info_cat->description !!}</div>
        </div>
        
        
        
        <div class="row list-article-new">
            <!-- search -->
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="box-search w-100 mb-3">
                    <input type="text" id="search-input" class="w-100" placeholder="Search...">
                    <img src="{{ asset('frontend/images/ic_search.svg') }}" alt="search" class="btn-search" style="width:26px;height:26px">
                    <div class="dropdown-result-search" tabindex="3">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end -->
            <div class="col-xs-12">
                <h2 class="sub-title size-h2">
                    MOST VIEWED
                </h2>
                @include('layouts_frontend.components.most-view-slide-article', ['articles' => $mostViewArticles])
            </div>

            <div class="col-xs-12">
                <h2 class="sub-title size-h2 mb-0">
                    LATEST POSTS
                </h2>
            </div>    
            @foreach ($data as $key => $value)
                <div class="col-xs-12">
                    <div class="row py-3">
                        <div class="col-xs-12 col-sm-4 pb-2 pb-md-0">
                            <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">
                                <img src="{{ asset('filemanager/data-images/' . $value->image) }}" alt="{{ $value->title }}" class="lazy img-thumbnail w-100">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <h3 class="pt-md-0">
                                <a href="{{ url('/') }}/{{$value->slug}}" title="{{ $value->title }}" class="link-default">{{ $value->title }}
                                </a>
                            </h2>
                            <div class="cat-title pb-2 pb-md-0">
                                {!! $value->description !!}
                            </div>
                            @include('layouts_frontend.components.information-article', ['data' => $value, 'full' => 1])
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xs-12">
            <div class="b-page justify-content-center pt-5 d-flex">
                {{ $data->appends(Request::all())->links() }}
            </div>
        </div>
    </div>
</div>
<style>
    h2.sub-title.size-h2 {
        margin-top: 40px;
        position: relative;
        padding-bottom: 10px;
    }
    h2.sub-title.size-h2::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0px;
        width:200px;
        border: 1px solid #E0E0E0
    }   
</style>
@push('scripts')
<script>
	var page = "{{ (isset($_GET['page']) ? ' | page ' . $_GET['page'] : '') }}"
	if (page != '') {
		$('h1').append(' ' + page);
		$('h2').append(' ' + page);
	}
</script>
@endpush
<script src="{{ url('frontend/js/search.js') }}"></script>

@endsection