@extends('Pharmacist.Layouts.Layout')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
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
        <br>
        <a href="{{ route('instructions.create') }}" class="btn btn-primary btn-round">Register new Instruction</a>
        <br>
      <div class="card">
        <div class="card-header card-header-primary">
          <h3 class="card-title "><b>My Medecines Instructions</b></h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>No</th>
                <th>
                    Name
                  </th>
                <th>
                    Medecine
                  </th>
              </thead>
              <tbody>
                <?php $counter = 1 ?>
                  @foreach ($instructions as $item)
                    <tr>
                        <th scope="row">
                            {{$counter}}
                        </th>
                        <?php $counter++ ?>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->medecine->name }}</td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
