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
              <h4 class="card-title"><b>Edit {{ $medecineToEdit->name }} Medecine</b></h4>
            </div>
            <div class="card-body">
              <form action="{{ route('medecines.update',$medecineToEdit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="Mid" value = "{{ $medecineToEdit->id }}">
                <input type="hidden" name="_method" value="put">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Medecine Name</label>
                      <input type="text" name="Mname" autocomplete="off" value="{{ $medecineToEdit->name }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Medecine Price</label>
                      <input type="text" name="Mprice" autocomplete="off" value="{{ $medecineToEdit->price }}" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Items Available</label>
                        <input type="text" name="Mitems" autocomplete="off" value="{{ $medecineToEdit->numberOf }}" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        {{-- <label class="bmd-label-floating">Pharmacy Description</label> --}}
                        <textarea placeholder="medecine description" autocomplete="off" name="Mdescription" class="form-control">{{ $medecineToEdit->description }}</textarea>
                      </div>
                    </div>
                  </div>

                <button type="submit" class="btn btn-primary pull-right">Update Medecine</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
