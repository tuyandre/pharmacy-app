@extends('layouts.layout')


@section('content')
<section class="checkout-section spad" style="background-color: #ffffe6">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3 order-1 order-lg-2">
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
                <div class="checkout-cart">
                    <h3 class="text-center">Ordered Medecines</h3>
                    <ul class="product-list">
                      @foreach ($userOrder->medecines as $medecine)
                      <li>
                        <div class="pl-thumb"><img src="{{$medecine->file_url}}" height="90" alt=""></div>
                        <h6>Name: {{ $medecine->name }}</h6>
                        <p>Pharmacy: <a href="{{ route('viewThisPharmacy',$medecine->pharmacy->id) }}">{{ $medecine->pharmacy->name }}</a></p>
                        <p>Location: {{ $medecine->pharmacy->location }}</p>
                        <p>Price: Rwf{{ $medecine->price }}</p>
                        <p>Ordered items: {{ $medecine->pivot->items }}</p>
                        <p>Total:{{$medecine->price * $medecine->pivot->items}} frws</p>
                    </li>
                      @endforeach
                    </ul>
                    <ul class="price-list">
                        <li class="total">Total<span style="margin-right: 60px";>{{ $userOrder->medecines->sum('pivot.amount') }} Rwf</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
