@extends('Super-Admin.Layouts.Layout')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                 @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                 @if(Session::has($msg))
                 <div class="alert alert-{{ $msg }} text-center" id="alert">
                     <b>{{ Session::get($msg) }}</b>
                     <button type="button" class="close text-danger" aria-label="Close"
                     onclick="document.getElementById('alert').style.display='none'">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 @endif
                 @endforeach
                </div>
            </div>
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"><b>Register new Pharmacy</b></h4>
            </div>
            <div class="card-body">
              <form action={{ route('pharmacies.store')}} method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Pharmacy Name</label>
                      <input type="text" name="Pname" autocomplete="off" class="form-control" required autofocus>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Pharmacy Location</label>
                      <input type="text" name="Plocation" autocomplete="off" class="form-control" required>
                    </div>
                  </div>
                </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="bmd-label-floating">Pharmacy Latitude</label>
                              <input type="text" name="Platitude" autocomplete="off" class="form-control" required>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="bmd-label-floating">Pharmacy Longitude</label>
                              <input type="text" name="Plongitude" autocomplete="off" class="form-control" required>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              {{-- <label class="bmd-label-floating">Pharmacy Description</label> --}}
                              <textarea placeholder=" pharmacy description" autocomplete="off" name="Pdescription" class="form-control"></textarea>
                          </div>
                      </div>
                  </div>
                <button type="submit" class="btn btn-primary pull-right">Create Pharmacy</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

