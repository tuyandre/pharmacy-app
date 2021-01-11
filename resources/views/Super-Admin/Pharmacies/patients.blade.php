@extends('Super-Admin.Layouts.Layout')

@section('content')

    <div class="row">
        <div class="col-lg-6 offset-md-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-user-circle-o"></i>
                    </div>
                    <p class="card-category">Total Number of Patients </p>
                    <h3 class="card-title">{{ $patients->count() }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <p>Registered Patients</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

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
            <br>
            <div class="card">
                <div class="card-header card-header-primary">
                    <h3 class="card-title "><b>Patients Registered</b></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                            <th>No</th>
                            <th>
                                First  Name
                            </th>
                            <th>
                                Last  Name
                            </th>
                            <th>
                                Telephone
                            </th>
                            </thead>
                            <tbody>
                            <?php $counter = 1 ?>
                            @foreach ($patients as $patient)
                                <tr>
                                    <th scope="row">
                                        {{$counter}}
                                    </th>
                                    <?php $counter++ ?>
                                    <td>{{ $patient->fname }}</td>
                                    <td>{{ $patient->lname }}</td>
                                    <td>{{ $patient->phone_no }}</td>
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
