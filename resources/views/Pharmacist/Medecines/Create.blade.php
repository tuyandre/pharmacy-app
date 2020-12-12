@extends('Pharmacist.Layouts.Layout')

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
              <h4 class="card-title"><b>Register new Medecine</b></h4>
            </div>
            <div class="card-body">
              <form action={{ route('medecines.store')}} method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="Pid" value = {{ $pharmacyId }}>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Medecine Name</label>
                      <input type="text" name="Mname" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Medecine Price</label>
                      <input type="text" name="Mprice" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Items Available</label>
                        <input type="text" name="Mitems" autocomplete="off" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label class="bmd-label-floating">Medecine Image</label>
                        <input type="file" name="Mimage">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        {{-- <label class="bmd-label-floating">Pharmacy Description</label> --}}
                        <textarea placeholder="medecine description" autocomplete="off" name="Mdescription" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>

                <button type="submit" class="btn btn-primary pull-right">Register Medecine</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
