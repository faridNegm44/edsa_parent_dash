<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Dashfox - Laravel Admin & Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, laravel, php framework, php laravel, laravel framework, php mvc, laravel admin panel, laravel admin panel, laravel template, laravel bootstrap, blade laravel, best php framework"/>
    <title> EduStage Academy </title>
		<link rel="icon" href="{{ url('back') }}/images/settings/fiv.png" type="image/x-icon"/>
		<link href="{{ url('back') }}/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/icons/icons.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('back') }}/assets/css-rtl/sidemenu.css">
		<link href="{{ url('back') }}/assets/css-rtl/style.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">
		<link id="theme" href="{{ url('back') }}/assets/css-rtl/colors/color.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
        <link href="{{ url('back') }}/assets/plugins/jqvmap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/animate.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/demo.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/notify/css/notifIt.css" rel="stylesheet"/>

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Changa:500|El+Messiri|Harmattan|Mada:600|Tajawal:700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
	
		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700&family=Tajawal:wght@200;300;500&display=swap" rel="stylesheet">

		<style>
          *{
			  font-family: cairo;
		  }
</style>

		@yield('header')
</head>

    <body class="main-body light-theme">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ url('back') }}/assets/img/loader-2.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- main-signin-wrapper -->

        <div class="my-auto page page-h">

        {{-- Modal Video How To Add Parent Payment --}}
		<div class="modal fade" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
			<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title2" id="exampleModalLabel">كيفية الدخول بالايميل والباسورد كعميل حالى او عميل جديد</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<iframe width="100%" height="400px" src="https://www.youtube.com/embed/ZL5-1h6fCGc" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			</div>
		</div>
		
		<!-- main-signin-wrapper -->
		<div class="my-auto page page-h">
			<div class="main-signin-wrapper error-wrapper">
				<div class="main-card-signin d-md-flex wd-100p">
				<div class="wd-md-50p login d-none d-md-block page-signin-style p-5 text-white" >
					<div class="my-auto authentication-pages">
						<div>
							<img src="{{ url('back/images/settings/logo.png') }}" class=" m-0 mb-4" alt="logo">
							<p class="mb-5 text-center"> منصة للتعلم عبر الإنترنت من خلال أفضل وسائل وطرق التعلُم الحديثة</p>
						</div>
					</div>
				</div>
				<div class="p-5 wd-md-50p">
					<div class="main-signin-header">
						<h2 style="margin-bottom: 13px;">مرحبًا
							<a class="btn btn-warning btn-icon btn-sm text-white mr-2 modal-effect" data-effect="effect-sign" data-toggle="modal" href="#modaldemo10" style="display: inline;padding: 10px 10px 5px;border-radius: 10px;"><i class="fa fa-video"></i></a>
						</h2>
						<h6>من فضلك أدخل البريد الإلكتروني والرقم السري</h6>

						<br />
						@if (Session::has('error_email_or_password'))
							<h6 style="color: red;font-weight: bold;" class="alert alert-warning">
								{{ session()->get('error_email_or_password') }}
								{{ session()->forget('error_email_or_password') }}
							</h6>
						@endif

						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form action="{{ url('dashboard/login_post') }}" method="post">
                            @csrf
							<div class="form-group">
								<label>البريد الإلكتروني</label>
								<input class="form-control" name="TheEmail" placeholder="يرجي ادخال البريد الإلكتروني" type="text" value="{{ old('TheEmail') }}" />
							</div>
							<div class="form-group">
								<label>الرقم السري</label> 
								<input class="form-control" name="ThePass" placeholder="يرجي ادخال الرقم السري" type="password" value="">
							</div>
							<button class="btn btn-main-primary btn-block">تسجيل دخول</button>
						</form>
					</div>
					<div class="main-signin-footer mt-3 mg-t-5">
						<br />
						<p class="text-center">
							<a href="{{ url('/register') }}" style="color: red;">تسجيل عضوية جديدة</a>
						</p>
						{{-- <p>
							<a href="{{ url('back') }}/#">هل نسيت كلمة السر ؟</a>
						</p> --}}
					</div>
				</div>
			</div>
			</div>
		</div>
		<!-- /main-signin-wrapper -->


        </div>

		<!-- /main-signin-wrapper -->

        <!-- JQuery min js -->
<script src="{{ url('back') }}/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap4 js-->
<script src="{{ url('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Ionicons js -->
<script src="{{ url('back') }}/assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="{{ url('back') }}/assets/plugins/moment/moment.js"></script>

<!-- eva-icons js -->
<script src="{{ url('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>
  
<!-- Rating js-->
<script src="{{ url('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

<script>
	$(document).ready(function(){
		$("#modaldemo10").modal('show');
	});
</script>
 

<!-- custom js -->
<script src="{{ url('back') }}/assets/js/custom.js"></script>
        
	</body>

<!-- Mirrored from laravel.spruko.com/dashfox/ltr/signin by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Mar 2021 20:07:50 GMT -->
</html>