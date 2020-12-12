@extends('layouts.Layout')

@section('content')
<section class="contact-section" style="background-color: #ffffe6;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3 contact-info" >
                <h3 class="text-center">REGISTRATION FORM</h3>
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
                <form class="contact-form" method="POST" action ={{ route('register') }}>
                    @csrf
                    <input type="text" autocomplete="off" name="fname" placeholder="First Name">
                    <input type="text" autocomplete="off" name="lname" placeholder="Last Name">
                    <input type="text" autocomplete="off" name="phoneNo" placeholder="Phone number">
                    <input type="text" autocomplete="off" name="location" placeholder="Location">
                    <select id='select' name="role" onchange="changeValue()">
                        <option selected disabled>Patient or Pharmacist?</option>
                        <option value="Patient">Patient</option>
                        <option value="Pharmacist">Pharmacist</option>
                    </select>
                    <input id="Code" autocomplete="off" name="pharmacyCode" style="display:none" type="text" placeholder="Pharmacy Code">
                    <input type="password" name="password" placeholder="Password">
                    <input type="password" name="password_confirmation" placeholder="Repeat Password">
                    <br>
                    <button class="site-btn btn-block">REGISTER</button>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
    // let select = document.getElementById('select').value;
      // // let optionSelected = select.options[select.selectedIndex];
      // console.log(select);
      function changeValue()
      {
        let select = document.getElementById('select').value;
          if(select == 'Pharmacist'){
              document.getElementById('Code').style.display='block';
          }
          else {
              document.getElementById('Code').style.display='none';
          }
      }
  </script>
