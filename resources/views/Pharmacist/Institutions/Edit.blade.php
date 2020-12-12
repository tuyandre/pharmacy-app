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
              <h4 class="card-title"><b>Edit {{ $institutionToEdit->name }}</b></h4>
            </div>
            <div class="card-body">
              <form action="{{ route('institutions.update',$institutionToEdit->id) }}" method="POST">
                @csrf
                <input type="hidden" name="Iid" value = "{{ $institutionToEdit->id }}">
                <input type="hidden" name="_method" value="put">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Institution Name</label>
                      <input type="text" name="Iname" value="{{ $institutionToEdit->name }}" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-primary pull-right">Update Institution</button>
                  </div>
                </div>

                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
