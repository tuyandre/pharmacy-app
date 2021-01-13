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
                    @if($filteredmedecines->count() > 1)
                    <p class="lead text-center"><b>Your search of {{ $name}} located at location like {{ $filteredmedecines[0]->location }} matches {{ $filteredmedecines->count() }} medicines</b></p>
                    @else
                    <p class="lead text-center"><b>Your search of {{ $name }} located at location like {{ $filteredmedecines[0]->location }} matches only {{ $filteredmedecines->count() }} medicine</b></p>
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="row">
                        @foreach ($filteredmedecines as $medecine)
                        <div class="col-lg-2 col-sm-6">
                        <div class="product-item row-lg-6">
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
                               <p>{{(number_format((float)($medecine->distance * 1.609344) , 2, '.', ''))}}Km</p>
                           </div>
                       </div>

                       </div>
                        @endforeach
                       <div class="col-lg-8 col-sm-8 col-md-8">
                       <div id="map_wrapper">
                            <div id="map_canvas" class="mapping"></div>
                        </div>
                       </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="text-center">

        </div>
{{--    </div>--}}
    <input id="medecineeees" value="{{$filteredmedecines}}" type="hidden">
    <input id="latitude" type="hidden">
    <input id="longitude"  type="hidden">

</section>
@endsection
@section('location')
    <script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzFFGKTLODEd4uZH3vce8U-PL4c5zq-UQ&callback=initMap"></script>

    <script type="text/javascript">
        // $(document).ready(function () {
        var latlon=[];
            var latlng;

            x = navigator.geolocation;
            x.getCurrentPosition(success, failure);

            function success(position) {
                var mylat1 = position.coords.latitude;
                var mylong1 = position.coords.longitude;
                $('#latitude').val(mylat1);
                $('#longitude').val(mylong1);
                console.log(mylong1)
                console.log(mylat1)
            }

            function failure() {
                $('#body').append('<p>it doesnt work</p>');
            }
        // });
    function initMap() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                initialLocation =new  google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
            });
        }

        var test = '<?php echo $filteredmedecines; ?>';
        // test = new Array(test);
        var myJSONString = test,
            myObject = JSON.parse(myJSONString);
        // console.log("VIEW TEST", myObject);

        // console.log(latlon);
        var markers=[
            <?php

            foreach ($filteredmedecines as  $each) {
                echo "['".$each->name.", ".$each->location."',".$each->latitude.",".$each->longitude."],";

            }
            ?>

        ];
        // console.log(markers);
        var infoWindowContent=[];

        var j=0;
        for(var i in myObject) {
            var iid=[];
            var dist=myObject[i].distance*1.60934;
            var  infoWind ="<div class='info_content'>"+
                "<h3>"+myObject[i].name+"</h3>"+
                "<p>"+dist.toFixed(2) +"Km</p>"+
                "</div>";
          iid[0]=infoWind;
            infoWindowContent[j]=iid;
            // infoWindowContent[0][j]=infoWind;
            j++;
        }
        // console.log(infoWindowContent);
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        // Loop through our array of markers & place each one on the map
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0]
            });

            // Allow each marker to have an info window
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
        });

    }
</script>
@endsection
