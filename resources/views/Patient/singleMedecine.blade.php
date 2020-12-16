@extends('layouts.Layout')

@section('content')
<section class="product-section" style="background-color: #ffffe6">
    <div class="container">
        <div class="back-link">
            <a href="{{ route('patientMedecines.index') }}"> &lt;&lt; Back to Category</a>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="product-pic-zoom">
                    <img class="product-big-img" src="{{$medecine->file_url}}"  alt="">
                </div>

            </div>
            <div class="col-lg-6 product-details">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))

                <div class="alert alert-{{ $msg }}  alert-dismissible fade show" role="alert">
                    {{ Session::get($msg) }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @endforeach
                <h2 class="p-title">{{ $medecine->name }}</h2>
                <h3 class="p-price">{{ $medecine->price }} Rwf</h3>
                <h4 class="p-stock">Available In: <a href="{{ route('viewThisPharmacy',$medecine->pharmacy->id) }}"><span>{{ $medecine->pharmacy->name }}</span></a> Located at <span>{{ $medecine->pharmacy->location }}</span></h4>
          <form action={{ route('addMedecineToCart') }} method="POST">
            @csrf
            <input type="hidden" name="MId" value={{ $medecine->id }}>
             <button type="submit" class="site-btn">ADD TO REQUESTED MEDECINES</button>
          </form>
                <div id="accordion" class="accordion-area">
                    <div class="panel">
                        <div class="panel-header" id="headingOne">
                            <button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">{{ $medecine->name }}</button>
                        </div>
                        <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="panel-body">
                                <p>{{ $medecine->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
