<!DOCTYPE html>
<html lang="en">
<head>
	<title>Smart Pharmacy</title>
	<meta charset="UTF-8">
	<meta name="description" content=" Divisima | eCommerce Template">
	<meta name="keywords" content="divisima, eCommerce, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-locationpicker/0.1.12/locationpicker.jquery.min.js" integrity="sha512-KGE6gRUEc5VBc9weo5zMSOAvKAuSAfXN0I/djLFKgomlIUjDCz3b7Q+QDGDUhicHVLaGPX/zwHfDaVXS9Dt4YA==" crossorigin="anonymous"></script>
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
    <script type="text/Javascripts" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzFFGKTLODEd4uZH3vce8U-PL4c5zq-UQ&callback=initMap"></script>

	<link rel="stylesheet" href="/Pharmacy/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/flaticon.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/slicknav.min.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/jquery-ui.min.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/animate.css"/>
	<link rel="stylesheet" href="/Pharmacy/css/style.css"/>
	<style>
    /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */

    #map_wrapper {
    height: 400px;
	}

	#map_canvas {
	    width: 100%;
	    height: 100%;
	}
</style>



</head>
<body >
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section -->
	<header class="header-section" >
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 text-center text-lg-left">
						<!-- logo -->
						<a href="" class="site-logo">
							<h5 style="margin-top:15px">SMART PHARMACY</h5>
						</a>
					</div>
                    {{-- @if(\Request::is('patientMedecines'))

                    @else
                    @endif --}}
                    <div class="col-xl-6 col-lg-5">

                    </div>
                    @if(Auth()->check())
                    <div class="col-xl-4 col-lg-5">
						<div class="user-panel">
							<div class="up-item">
                                @if(!Auth()->user()->cart()->exists())
                                <div class="shopping-card">
									<i class="flaticon-bag"></i>
                                        <span>0</span>
                                </div>
                                <a href="" style="pointer-events: none;cursor: default;">No available requested medecines</a>
                                @else
                                <div class="shopping-card">
									<i class="flaticon-bag"></i>
                                        <span>
                                            {{Auth()->user()->cart->medecines->count()}}
                                        </span>

                                </div>
                                <a href="{{ route('myCart') }}">Requested Medecines</a>
                                @endif
							</div>
						</div>
					</div>
                    @else
                    <div class="col-xl-4 col-lg-5">
						<div class="user-panel">
							<div class="up-item">
								<i class="flaticon-profile"></i>
								<a href="{{ route('login') }}">Sign In </a> or <a href="{{ route('register') }}">Create Account</a>
							</div>
						</div>
					</div>
                   @endif
				</div>
			</div>
		</div>
		<nav class="main-navbar">
			<div class="container">
				<!-- menu -->
				<ul class="main-menu">
					<li><a href="/">Home</a></li>
					<li><a href="/about">About us</a></li>
					<li><a href="{{ route('patientMedecines.index') }}">Medecines</a></li>
					<li><a href="/contact">Contact us</a></li>
					<!-- <li style="float: right">
						<a href="#">Contact us</a>
					</li> -->
                    @if(Auth()->check())
                    <li style="float: right"><a href="#">My Account</a>
						<ul class="sub-menu">
							<li><a href="{{ route('myTotal') }}">My Medecines</a></li>
                            <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
						</ul>
					</li>
                    @endif
				</ul>
			</div>
		</nav>
	</header>
	<!-- Header section end -->
          @yield('content')
    <!-- Footer section -->
	<section class="footer-section">
<p class="text-white text-center">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>

{{--			</div>--}}
		</div>
    </section>
	<!-- Footer section end -->



	<!--====== Javascripts & Jquery ======-->
	<script src="/Pharmacy/js/jquery-3.2.1.min.js"></script>
	<script src="/Pharmacy/js/bootstrap.min.js"></script>
	<script src="/Pharmacy/js/jquery.slicknav.min.js"></script>
	<script src="/Pharmacy/js/owl.carousel.min.js"></script>
	<script src="/Pharmacy/js/jquery.nicescroll.min.js"></script>
	<script src="/Pharmacy/js/jquery.zoom.min.js"></script>
	<script src="/Pharmacy/js/jquery-ui.min.js"></script>
	<script src="/Pharmacy/js/main.js"></script>
	@yield("location")
	</body>
</html>
