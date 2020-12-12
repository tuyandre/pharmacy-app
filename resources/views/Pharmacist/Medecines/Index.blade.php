@extends('Pharmacist.Layouts.Layout')

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
        <a href="{{ route('medecines.create') }}" class="btn btn-primary btn-round">Register new Medecine</a>
        <br>
      <div class="card">
        <div class="card-header card-header-primary">
          <h3 class="card-title "><b>{{ $pharmacyName }} Medecines</b></h3>
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
                  Image
                </th>
                <th>
                  Price
                </th>
                <th>
                    Items available
                  </th>
                  <th>
                    Action
                  </th>
              </thead>
              <tbody>
                <?php $counter = 1 ?>
                @foreach ($medecines as $medecine)
                    <tr>
                        <th scope="row">
                            {{$counter}}
                        </th>
                        <?php $counter++ ?>
                        <td>{{ $medecine->name }}</td>
                        <td><img src="{{asset('/storage/MedecineImages/'.   $medecine->image)}}" width="60" height="auto"  alt="Image"></td>
                        <td>{{ $medecine->price }} rwf</td>
                        <td>{{ $medecine->numberOf }}</td>
                        <td class="td-actions">
                            <a href="{{ route('medecines.edit',$medecine->id) }}" rel="tooltip" title="Edit medecine" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </a>
                            <form action="{{ route('medecines.destroy',$medecine->id) }}" class="form-delete pull-right"  method="POST">
                                <input type="hidden" name="Id" value="{{$medecine->id}}">
                                <input type="hidden" name="_method" value="delete">

                                {{csrf_field()}}
                                <button type="submit" rel="tooltip" title="Remove medecine" class="btn btn-danger btn-link btn-sm">
                                    <i class="material-icons">close</i>
                                  </button>
                            </form>
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
