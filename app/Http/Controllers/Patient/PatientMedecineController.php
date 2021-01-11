<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Medecine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientMedecineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'searchByName', 'searchByLocation']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medecines = Medecine::with('pharmacy')->simplePaginate(4);
        return view('Patient.medecines')->with('medecines', $medecines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medecine = Medecine::with('pharmacy')->find($id);
        return view('Patient.singleMedecine')->with('medecine', $medecine);
    }

    public function searchByName(Request $request)
    {
        $name = $request->input('name');
        // $location = $request->input('location');
        $circle_radius = 3959;
        $max_distance = 20;
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        if (empty($lat) || empty($lng) || empty($name)) {
            return back()->with('danger', 'please enter a medecine Name and make sure you have internet for location');
        }
        $nearest = DB::table('medecines')
            ->join('pharmacies', 'pharmacies.id', '=', 'medecines.pharmacy_id')
            ->select(
                    DB::raw(" medecines.*, pharmacies.name, pharmacies.location AS location, pharmacies.latitude, pharmacies.longitude,
                              ( 3959 * acos( cos( radians($lat) ) *
                                cos( radians( pharmacies.latitude ) )
                                * cos( radians( pharmacies.longitude ) - radians($lng)
                                ) + sin( radians($lat) ) *
                                sin( radians( pharmacies.latitude ) ) )
                              ) AS distance
                              "))
            ->where(function($query) use ($name){
                $query->where('medecines.name', '=', $name);//->orWhere('expiry_at','=', NULL);
            })
                    ->having("distance", "<=", $max_distance)
                    ->orderBy("distance")
                    ->groupBy("medecines.id")
                    ->get();

$data=Medecine::with(['Pharmacy'])
    ->where('name','=',$name)

    ->get();





            // $try = json_encode($nearest);
            return view('Patient.searchByAll',['filteredmedecines'=>$nearest,'name'=>$name,'tests'=>$data]);//->with('nearest', $try);;
        // }
        // if (empty($name)) {
        //     return back()->with('danger', 'please enter a medecine to search or a location to search');
        // }
        // if (!empty($name)) {
        //     $filteredMedecines = Medecine::where('name', 'LIKE', '%' . $name . '%');
        //     if (count($filteredMedecines->get()) == 0) {
        //         return back()->with('danger', 'your search did not match any medicine..please try again');
        //     }
        //     return view('Patient.searchByName')->with('filteredmedecines', $filteredMedecines->simplePaginate(4))
        //         ->with('search', $name)->with('nearest', $nearest);
        // }
        // if (empty($name)) {
        //     $filteredpharmacies = Pharmacy::where('location', 'LIKE', '%' . $location . '%')->with('medecines');
        //     if (count($filteredpharmacies->get()) == 0) {
        //         return back()->with('danger', 'your search did not match any medicine..please try again');
        //     }
        //     return view('Patient.searchByLocation')->with('filteredpharmacies', $filteredpharmacies->simplePaginate(4))
        //         ->with('search', $location)->with('nearest', $nearest);;
        // }
        // if (!empty($name)) {
        //     $filteredMedecines = DB::table('medecines')
        //         ->select('medecines.*')
        //         ->join('pharmacies', 'pharmacies.id', '=', 'medecines.pharmacy_id')
        //         ->where('pharmacies.location', 'LIKE', '%' . $location . '%')
        //         ->where('medecines.name', 'LIKE', '%' . $name . '%');
        //     if (count($filteredMedecines->get()) == 0) {
        //         return back()->with('danger', 'your search did not match any medicine..please try again');
        //     }
        //     return view('Patient.searchByAll')->with('filteredmedecines', $filteredMedecines->simplePaginate(4))
        //         ->with('name', $name)->with('location', $location)->with('nearest', $nearest);;
        // }
    }
     public function searchByGeo(Request $request)
    {
        $nearest = "hello";
        return json_encode($nearest);

    }
    // public function searchByLocation(Request $request)
    // {
    //     $locationToSearch = $request->input('locationToSearch');
    //     if (empty($locationToSearch)) {
    //         return back()->with('danger', 'please enter a location');
    //     }
    //     $filteredpharmacies = Pharmacy::where('location', 'LIKE', '%' . $locationToSearch . '%')->with('medecines');

    //     if (count($filteredpharmacies->get()) == 0) {
    //         return back()->with('danger', 'your search did not match any medicine..please try again');
    //     }
    //     return view('Patient.searchByLocation')->with('filteredpharmacies', $filteredpharmacies->simplePaginate(4))
    //         ->with('search', $locationToSearch);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
