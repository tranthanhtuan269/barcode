@foreach($comments as $com)
    @include('layouts_frontend.comment', ['com' => $com])
@endforeach

<style>
	.comment-form textarea{
		height:unset!important;
	}
</style>
