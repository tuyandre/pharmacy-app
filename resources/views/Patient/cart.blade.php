@extends('layouts.layout')

@section('content')
<style>
    .btn-btn-submit {
        display: inline-block;
        border: none;
        font-size: 12px;
        font-weight: 800;
        min-width: 30px;
        padding: 12px;
        border-radius: 50px;
        text-transform: uppercase;
        background: #f51167;
        color: #fff;
        line-height: normal;
        cursor: pointer;
        text-align: center;
    }
    .site-btn{
        /* display: inline-block;
        border: none;
        font-size: 12px;
        font-weight: 800;
        min-width: 30px;
        padding: 12px;
        border-radius: 50px;
        text-transform: uppercase;
        background: #f51167;
        color: #fff;
        line-height: normal;
        cursor: pointer;
        text-align: center; */
    }

    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .form-submit {
        font-size: 30px;

    }
</style>
<!-- Page info -->

<div class="page-top-info">
    <div class="container">
        <h4>Your cart</h4>
        <div class="site-pagination">
            <a href="/">Home</a> /
            <a href="#">Your cart</a>

        </div>
    </div>
</div>
<!-- Page info end -->
<!-- cart section end -->

<section class="cart-section spad" style="background-color: #ffffe6;">
    <div class="container">
        <h3 class="text-center">All Requested Medecines</h3>
        <br>
        <div class="row">
            <div class="col-lg-8">

                <div class="cart-table">

                    <div class="cart-table-warp">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-th">Medecine</th>
                                    <th class="total-th">Pharmacy Name</th>
                                    <th class="total-th">Pharmacy Location</th>
                                    <th class="quy-th">Action</th>
                                </tr>
                            </thead>


                            <tbody class="cart-Items">
                                @foreach($cart ->medecines as $medecine)

                                <tr class="cart-row">
                                    <input type="hidden" name="Id" value="{{$medecine->id}}">
                                    <td class="product-col">
                                        <img src="{{asset('/storage/MedecineImages/'.$medecine->image)}}" alt="">
                                        <div class="pc-title">
                                            <h4>{{$medecine->name}}</h4>
                                        </div>
                                    </td>


                                    <td class="total-col">
                                        <h4 class="cart-price" name="unitPrice">{{$medecine->pharmacy->name}}</h4>
                                    </td>
                                    <td class="total-col">
                                        <h4 class="cart-price" name="unitPrice">{{$medecine->pharmacy->location}}</h4>
                                    </td>
                                    <td class="total-col total">

                                        <form action="{{ route('removeMedecineFromCart',$medecine->id) }}" class="form-delete" method="POST">
                                            <input type="hidden" name="medecineId" value="{{$medecine->id}}">
                                            <input type="hidden" name="_method" value="delete">

                                            {{csrf_field()}}
                                            <button class="btn-btn-submit" type="submit">Remove from Cart</button>
                                        </form>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                @endforeach
                                <br>
                            </tbody>

                        </table>

                    </div>


                </div>
                <br>



            </div>
            <div class="col-lg-4 card-right cart-section ">
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
                <div class="cart-table">


                    <form action="{{ route('calculateTotal') }}" class="promo-code-form" method="POST">
                        <div class="row">

                            {{csrf_field()}}

                            @foreach($cart->medecines as $medecine)


                            <div class="col-md-12">
                                Number of Items for <b><span style="color: #f51167;">{{$medecine->name}}</span></b> Drug:
                                <input type="number" name="NberOfMedecines[]" min="1" placeholder="number of medecines">
                                <h2 style="visibility: hidden;">Hello</h2>
                                <input type="hidden" name="Id[]" value="{{$medecine->id}}">
                            </div>

                            @endforeach
                            <button class="site-btn" type="submit">Medecines booking</button>
                        </div>

                    </form>


                    <br>

                </div>
            </div>

        </div>

    </div>
    </div>
    </div>
</section>
<script src="{{asset('js/jquery-3.2.1.min.js')}}">
</script>
<script>

</script>
<!-- cart section end -->


@endsection
