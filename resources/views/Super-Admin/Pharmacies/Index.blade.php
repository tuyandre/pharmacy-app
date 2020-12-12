@extends('Super-Admin.Layouts.Layout')

@section('content')
<div class="row">
    <div class="col-md-12">
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
        <a href="{{ route('pharmacies.create') }}" class="btn btn-primary btn-round">Create New Pharmacy</a>
        <br>
      <div class="card">
        <div class="card-header card-header-primary">
          <h3 class="card-title "><b>Pharmacies List</b></h3>
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
                  Code
                </th>
                <th>
                  Location
                </th>
                <th>
                  Description
                </th>
                <th>
                    Owner
                  </th>
                  <th>
                    Action
                  </th>
              </thead>
              <tbody>
                <?php $counter = 1 ?>
                @foreach ($pharmacies as $pharmacy)
                    <tr>
                        <th scope="row">
                            {{$counter}}
                        </th>
                            <?php $counter++ ?>
                            <td>{{ $pharmacy->name }}</td>
                            <td>{{ $pharmacy->code }}</td>
                            <td>{{ $pharmacy->location }}</td>
                            <td>{{ $pharmacy->description }}</td>
                            <td>
                             @if($pharmacy->user()->exists())
                             {{ $pharmacy->user->fname }} {{ $pharmacy->user->lname }}
                             @endif
                            </td>
                             <td class="td-actions">
                                <button type="button" rel="tooltip" title="Edit Pharmacy" class="btn btn-primary btn-link btn-sm">
                                  <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="Remove Pharmacy" class="btn btn-danger btn-link btn-sm">
                                  <i class="material-icons">close</i>
                                </button>
                              </td>
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
