<li class="li-comment-{{$com->id}}">
	<article>
		<div class="author-info">
			@if($com->author == "Barcodelive" && $com->email == "barcodelive@gmail.com")
				<img src="{{ url ('/') }}/frontend/images/favion.png" alt="{{$com->author}}" class="logo">
			@else
				<img src="{{ url ('/') }}/frontend/images/user_avatar.png" alt="{{$com->author}}">
			@endif
			<h3 class="name">{{ $com->author }}</h3>
		</div>
		<div class="comment-content">
			<p>
				{!! $com->content !!}
			</p>
		</div>
		<div class="reply">
			<button class="btn-reply" data-id="{{$com->id}}" style="font-weight:500" data-parent-id="{{ $com->id }}">
				REPLY
			</button>
			@if(\Auth::check())
			<button class="btn-delete-comment" style="color:#a94442;font-weight:500;margin-left:30px" data-id="{{$com->id}}">
				DELETE
			</button>
			@endif
		</div>
	</article>
	<div class="repond repond-{{$com->id}} d-none">
		<h3 class=title>
			Leave a Comment
		</h3>
		<small>
			Your email address will not be published. Required fields are marked *
		</small>
		<form class="comment-form">
			<div class="fill-comment fill-comment-{{$com->id}}">
				<textarea id="comment-{{$com->id}} "class="form-control comment-{{$com->id}}" rows="5" cols="80" maxlength="65525" placeholder="Comment*"></textarea>
			</div>
			<div class="fill-author fill-author-{{$com->id}}">
				@if(\Auth::check())
				<input id="author-{{$com->id}}" type="text" name="author" class="form-control author author-{{$com->id}}" value="Barcodelive">
				@else
				<input id="author-{{$com->id}}" type="text" name="author" class="form-control author author-{{$com->id}}" placeholder="Name*">
				@endif
			</div>
			<div class="fill-email fill-email-{{$com->id}}">
				@if(\Auth::check())
				<input id="email-{{$com->id}}" type="email" name="email" class="form-control email email-{{$com->id}}" value="barcodelive@gmail.com">
				@else
				<input id="email-{{$com->id}}" type="email" name="email" class="form-control email email-{{$com->id}}" placeholder="Email*">
				@endif
			</div>
			<div class="submit-form">
				<div class="btn btn-submit-comment" data-id="{{$com->id}}">
					Submit Comment
				</div>
			</div>
		</form>
	</div>
	<ol class="children list-comment-{{$com->id}}">
		@foreach($com->children as $child)
			@include('layouts_frontend.comment', ['com' => $child])
		@endforeach
	</ol>
</li>

<style>
	.comment-form textarea{
		height:unset!important;
	}
</style>
