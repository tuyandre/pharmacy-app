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
      <div class="card">
        <div class="card-header card-header-primary">
          <h3 class="card-title "><b>{{ $pharmacyName }} Orders</b></h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>No</th>
                <th>
                    Customer
                  </th>
                <th>
                  Medecine
                </th>
                <th>
                  Items
                </th>
                <th>
                    Unit Price
                  </th>
                <th>
                   Total to Pay
                  </th>
              </thead>
              <tbody>
                <?php $counter = 1 ?>
                @foreach ( $myMedecines as $myMedecine)
@foreach ($orders as $order)
  @foreach($order->medecines as $medecine)
  @if ($medecine->id == $myMedecine->id)
      {{-- {{ $order }} --}}
      <tr><th scope="row">{{ $counter }}</th>
      <?php $counter++ ?>
      <td>{{ $order->user->fname }} {{ $order->user->lname }}</td>
      <td>{{ $medecine->name }}</td>
      <td>{{ $medecine->pivot->items }}</td>
      <td>{{ $medecine->price }}</td>
      <td>{{ $medecine->pivot->amount }}</td>
    </tr>
  @endif
  @endforeach
@endforeach
@endforeach


              </tbody>
              {{-- <tbody>
                <?php $counter = 1 ?>
                @foreach ($medecines as $medecine)
                    <tr>
                        <th scope="row">
                            {{$counter}}
                        </th>
                        <?php $counter++ ?>
                        <td>{{ $medecine->name }}</td>
                        <td><img src="{{$medecine->file_url}}" width="70" height="70"  alt="Image"></td>
                        <td>{{ $medecine->price }} rwf</td>
                        <td>{{ $medecine->numberOf }}</td>
                        <td><a href={{ route('instructions.show',$medecine->id) }} class ="btn btn-primary">Instructions</a></td>
                    </tr>
                @endforeach
              </tbody> --}}
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection