@extends('layouts.Layout')

@section('content')
<div class="page-top-info" >
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Medecine Page</h4>
                    <div class="site-pagination">
                      <a href="">Home</a> /
                         <a href="">Medecines</a> /
                     </div>
            </div>
        </div>
    </div>
</div>

<section class="category-section spad" style="background-color: #ffffe6">
    <div class="container">
        <div class="row">
            <div class="col-lg-12  order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="alert alert-success  alert-dismissible fade show" role="alert">
                    @if($filteredpharmacies->count() > 1)
                    <p class="lead text-center"><b>Your search of {{ $search }} matches {{ $filteredpharmacies->count() }} pharmacies with the following medecines</b></p>
                    @else
                    <p class="lead text-center"><b>Your search of {{ $search }} matches only {{ $filteredpharmacies->count() }} pharmacy with the following medecines</b></p>
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  <div class="row">
                    @foreach ($filteredpharmacies as $pharmacy)
                        @if(count($pharmacy->medecines) > 0)
                        @foreach ($pharmacy->medecines as $medecine)
                        <div class="col-lg-3 col-sm-6">
                        <div class="product-item">
                           <div class="pi-pic">
                               <img src="{{$medecine->file_url}}"
                               style="border:0px solid #4d4d4d;
                               box-shadow: 5px 2px 5px 5px grey;
                                 border-radius: 2%;" alt=""  height="250">
                               <div class="pi-links">
                                   <a href="{{ route('patientMedecines.show',$medecine->id) }}" class="add-card"><i class="flaticon-bag"></i><span>VIEW DRUG</span></a>
                               </div>
                           </div>
                           <div class="pi-text">
                               <h6>Rwf {{ $medecine->price }}</h6>
                               <p>{{ $medecine->name }}</p>
                               <p>Found in <b><a href="{{ route('viewThisPharmacy',$medecine->pharmacy->id) }}">{{ $medecine->pharmacy->name }}</a></b> pharmacy</p>
                               <p>Located at <b>{{ $medecine->pharmacy->location }}</b></p>
                           </div>
                       </div>
                       </div>
                        @endforeach
                        @else
                        @endif
                    @endforeach
                  </div>

                </div>
            </div>
        </div>
        <div class="text-center">
            {{ $filteredpharmacies->render() }}
        </div>
    </div>

</section>
@endsection
