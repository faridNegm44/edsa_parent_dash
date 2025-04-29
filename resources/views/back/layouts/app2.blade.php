<!DOCTYPE html>
<html lang="en" dir="rtl">    
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Dashfox - Laravel Admin & Dashboard Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, laravel, php framework, php laravel, laravel framework, php mvc, laravel admin panel, laravel admin panel, laravel template, laravel bootstrap, blade laravel, best php framework"/>

	<title> 
		@yield('title')	
	</title>

		<link rel="icon" href="{{ url('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>
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

		@yield('header')

		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet">
        <link href="{{ url('back') }}/assets/css/custom.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
</head>

<body class="main-body" style="background: #fff;">
    
	<div class="">
        <div class="container-fluid mg-t-20">
            @yield('content')
        </div>
	</div>

        @include('back.layouts.footer')

	<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
	<script src="{{ url('back') }}/assets/plugins/jquery/jquery.min.js"></script>

	<!-- Bootstrap4 js-->
	<script src="{{ url('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
	<script src="{{ url('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Ionicons js-->
	<script src="{{ url('back') }}/assets/plugins/ionicons/ionicons.js"></script>

	<!-- Moment js -->
	<script src="{{ url('back') }}/assets/plugins/moment/moment.js"></script>	

	<!-- P-scroll js -->
	<script src="{{ url('back') }}/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="{{ url('back') }}/assets/plugins/perfect-scrollbar/p-scroll.js"></script>

	<!-- Sidebar js -->
	<script src="{{ url('back') }}/assets/plugins/side-menu/sidemenu.js"></script>

	<!-- Rating js-->
	<script src="{{ url('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
	<script src="{{ url('back') }}/assets/plugins/rating/jquery.barrating.js"></script>		

	<!-- Suggestion js-->
	<script src="{{ url('back') }}/assets/plugins/suggestion/jquery.input-dropdown.js"></script>
	<script src="{{ url('back') }}/assets/js/search.js"></script>

	<!-- Right-sidebar js -->
	<script src="{{ url('back') }}/assets/plugins/sidebar/sidebar.js"></script>
	<script src="{{ url('back') }}/assets/plugins/sidebar/sidebar-custom.js"></script>

	<!-- Sticky js-->
	<script src="{{ url('back') }}/assets/js/sticky.js"></script>

	<!-- eva-icons js -->
	<script src="{{ url('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>

	
	<!--Internal  Chart.bundle js -->
	<script src="{{ url('back') }}/assets/plugins/chart.js/Chart.bundle.min.js"></script>

	<!--Internal Sparkline js -->
	<script src="{{ url('back') }}/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

	<!-- Moment js -->
	<script src="{{ url('back') }}/assets/plugins/raphael/raphael.min.js"></script>

	<!--Internal  Flot js-->
	<script src="{{ url('back') }}/assets/plugins/jquery.flot/jquery.flot.js"></script>
	<script src="{{ url('back') }}/assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
	<script src="{{ url('back') }}/assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
	<script src="{{ url('back') }}/assets/plugins/jquery.flot/jquery.flot.categories.js"></script>
	<script src="{{ url('back') }}/assets/js/dashboard.sampledata.js"></script>
	<script src="{{ url('back') }}/assets/js/chart.flot.sampledata.js"></script>

	<!-- Chart-circle js -->
	<script src="{{ url('back') }}/assets/plugins/circle-progress/circle-progress.min.js"></script>
	<script src="{{ url('back') }}/assets/plugins/chart-circle/chart-circle.js"></script>

	<!-- ECharts js-->
	<script src="{{ url('back') }}/assets/plugins/echart/echart.js"></script>
	<script src="{{ url('back') }}/assets/plugins/apexcharts/apexcharts.js"></script>
	<script src="{{ url('back') }}/assets/js/index.js"></script>

	<script src="{{ url('back') }}/assets/plugins/notify/js/notifIt.js"></script>
    <script src="{{ url('back') }}/assets/plugins/notify/js/notifit-custom.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
	@yield('footer')

	<!-- custom js -->
	<script src="{{ url('back') }}/assets/js/custom.js"></script>
	<script src="{{ url('back') }}/assets/js/custom2.js"></script>
	<!-- Switcher js -->
	<script src="{{ url('back') }}/assets/switcher/js/switcher.js"></script>
</body>
</html>