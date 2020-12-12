@extends('layouts.layout')

@section('content')
<section class="product-section"  style="background-color: #ffffe6">
    <div class="container">
        <div class="back-link">
            <a href="{{ url()->previous() }}"> &lt;&lt; Return Back </a>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-md-3 product-details">
                <h1 style="font-size: 28px" class="p-title text-center">{{ $pharmacyToView->name }}</h1>
                <div id="accordion" class="accordion-area">
                    <div class="panel">
                        <div class="panel-header" id="headingOne">
                            <button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">information</button>
                        </div>
                        <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="panel-body">
                                <p>{{ $pharmacyToView->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header" id="headingTwo">
                            <button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Institutions</button>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="footer-widget about-widget">
                    @if(count($pharmacyToView->institutions) > 0)
                    <ul>
                        @foreach ($pharmacyToView->institutions as $item)

                        <li disabled><a href="">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-danger"><b>{{ $pharmacyToView->name }} has no Institutions</b></p>
                    @endif

                </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<br><br>
@endsection
