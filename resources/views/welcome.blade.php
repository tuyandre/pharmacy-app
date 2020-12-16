@extends('layouts.Layout')

@section('content')
    	<!-- Hero section -->
	<section class="hero-section">

        <div class="hero-slider owl-carousel">
           @if(count($medecinesCarousel) > 0)
           @foreach ($medecinesCarousel as $medecine)
           <div class="hs-item set-bg" data-setbg="/Pharmacy/img/bg.jpg">
               <div class="container">
                   <div class="row">
                       <div class="col-xl-6 col-lg-7 text-black">
                           <h2><b>{{ $medecine->name }}</b></h2>
                           <p style="color:#000"><b>{{ $medecine->description }}</b></p>
                           <a href="{{ route('patientMedecines.index') }}" class="site-btn sb-white">VIEW ALL MEDECINES</a>
                       </div>
                   </div>
                   <div class="offer-card text-white">
                       <span>from</span>
                       <h3>Rwf {{ $MinPrice }}</h3>
                       <p>Minimum price</p>
                   </div>
               </div>
           </div>

       @endforeach
           @else
           <div class="hs-item set-bg" data-setbg="/Pharmacy/img/bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-7 text-black">
                        <p style="color:#000;font-size:26px;font-weight:700;text-align:center"><b>No medecines available now...</b></p>
                    </div>
                </div>
            </div>
        </div>
           @endif
    </div>
		<div class="container">
			<div class="slide-num-holder" id="snh-1"></div>
		</div>
	</section>
	<!-- Hero section end -->

	<section class="features-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="/Pharmacy/img/icons/1.png" alt="#">
						</div>
						<h2>Search Medecine Wherever</h2>
					</div>
				</div>
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="/Pharmacy/img/icons/2.png" alt="#">
						</div>
						<h2>Medecines Near You</h2>
					</div>
				</div>
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="/Pharmacy/img/icons/3.png" alt="#">
						</div>
						<h2>Pharmacies Near You</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- letest product section -->
	<section class="top-letest-product-section" style="background-color: #ffffe6">
		<div class="container">
			<div class="section-title">
				<h2>LATEST MEDECINES</h2>
			</div>
            @if(count($medecinesCarousel) == 0)
            <div class="alert alert-danger">
                <h3 class="text-center"><b>No medecines available</b></h3>
            </div>
            @else
            <div class="product-slider owl-carousel">
@foreach ($medecinesCarousel as $item)
<div class="product-item">
    <div class="pi-pic">
        <img src="{{$item->file_url}}" width="80" height="250"  style="border:0px solid #4d4d4d;
        box-shadow: 5px 2px 5px 5px grey;
          border-radius: 2%;"
          alt="">

    </div>
    <div class="pi-text">
        <h6>{{ $item->name }}</h6>
        <p>Rwf {{ $item->price }}</p>
    </div>
</div>

@endforeach
</div>
@endif

		</div>
	</section>
	<!-- letest product section end -->
@endsection
