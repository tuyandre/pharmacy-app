@extends('layouts.Layout')

@section('content')
<section class="contact-section" style="background-color: #ffffe6;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3 contact-info" >
                <h3 class="text-center">LOGIN FORM</h3>
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                <div class="text text-{{ $msg }} text-center" id="alert">
                    <b>{{ Session::get($msg) }}</b>
                    <button type="button" class="close text-danger" aria-label="Close"
                    onclick="document.getElementById('alert').style.display='none'">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @endforeach
                <br>
                <form class="contact-form" method="POST" action ={{ route('authentication') }}>
                    @csrf
                    <input type="text" autocomplete="off" name="phoneNo" value="{{ old('phoneNo') }}" placeholder="Phone number">
                    <input type="password" name="password" placeholder="Password">
                    <br>
                    <button class="site-btn btn-block">LOGIN</button>
                </form>
                <br>
                <br>
                <br>
                <br>
                <br>

            </div>
        </div>
    </div>
@endsection

