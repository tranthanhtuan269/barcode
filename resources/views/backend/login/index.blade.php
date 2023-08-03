<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,shrink-to-fit=no,nomaximum-scale=10.0,user-scalable=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/sb-admin.css') }}">
        <link rel="stylesheet" href="{{ asset('general/css/style.css') }}">
    </head>
	<style>
		.font-weight{
			font-weight: 600;
		}
	</style>
    <body class="fixed-nav sticky-footer bg-dark">
		<div class="container">
			<div class="card card-login mx-auto mt-5">
			  <div class="card-header text-center"><h3>Login</h3></div>
			  <div class="card-body">
			    <form action="" method="POST">
			      <div class="form-group">
					<input class="form-control" name="email" type="email" placeholder="Email" value="">
					<div class="alert-errors alert-email"></div>
			      </div>
			      <div class="form-group">
			        <input class="form-control" name="password" type="password" placeholder="Password" value="">
					<div class="alert-errors alert-password"></div>
			      </div>
			      <div class="form-group">
						<!-- <input type="checkbox" name="remember"> Lưu trạng thái đăng nhập -->
						<div class="alert-errors alert-general"></div>
			      </div>
			      <button type="button" class="btn btn-primary btn-block" onclick="loginAdmin()">Đăng nhập</button>
			    </form>

			  </div>
			</div>
		</div>
		<script>
			function loginAdmin(){
				var email = $('input[name=email]').val();
				email = email.trim();
				var password = $('input[name=password]').val();
				var remember = $('input[name=remember]').prop('checked');
				var data = {
					email:email,
					password: password,
					remember: remember,
				};
				$.ajaxSetup(
				{
					headers:
					{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				// console.log(data);
				$.ajax({
					method: "POST",
					url: '{{ route("post-login-admin") }}',
					data: data,
					dataType: 'json',
					beforeSend: function() {
					    $('.alert-errors').html('');
					},
					complete: function() {
					    // $("#pre_ajax_loading").hide();
					},
					success: function (response) {
						if(response.status == 200){
							location.reload()
						}else{
							$('.alert-general').html(response.message);
						}
					},
				});

				return false;
			} 
		</script>
        <!--  /.content-wrapper -->
        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.easing.min') }}"></script>
        <script src="{{ asset('backend/js/Chart.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('backend/js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('backend/js/sb-admin.min.js') }}"></script>
        <script src="{{ asset('backend/js/sb-admin-charts.min.js') }}"></script>
    </body>
</html>