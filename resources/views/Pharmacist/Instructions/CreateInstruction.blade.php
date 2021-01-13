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
              <h4 class="card-title"><b>Register new Description</b></h4>
            </div>
            <div class="card-body">
              <form action={{ route('instructions.store')}} method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Instruction Description</label>
                      <input type="text" name="Instruction" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="bmd-label-floating">select medecine</label>
                    <select class="form-control" name="medecine">
                         <option selected disabled>select medecine..</option>
                        @foreach ($medecines as $item)
                            <option value ="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
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
