@extends('layouts_frontend.master')

@section('title', $data->seo_title)

@section('description',$data->seo_description)

@section('keywords', isset($data->keywords) ? $data->keywords : "Barcodelive")

@section('content')

<div class="special"></div>
<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>{{ $data->title }}</h1>
				<div class="content">
					{!! $data->content !!}
				</div>
			</div>	
		</div>
	</div>
</div>

@endsection