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
        $location = $request->input('location');
        if (empty($name) && empty($location)) {
            return back()->with('danger', 'please enter a medecine to search or a location to search');
        }
        if (!empty($name) && empty($location)) {
            $filteredMedecines = Medecine::where('name', 'LIKE', '%' . $name . '%');
            if (count($filteredMedecines->get()) == 0) {
                return back()->with('danger', 'your search did not match any medicine..please try again');
            }
            return view('Patient.searchByName')->with('filteredmedecines', $filteredMedecines->simplePaginate(4))
                ->with('search', $name);
        }
        if (empty($name) && !empty($location)) {
            $filteredpharmacies = Pharmacy::where('location', 'LIKE', '%' . $location . '%')->with('medecines');
            if (count($filteredpharmacies->get()) == 0) {
                return back()->with('danger', 'your search did not match any medicine..please try again');
            }
            return view('Patient.searchByLocation')->with('filteredpharmacies', $filteredpharmacies->simplePaginate(4))
                ->with('search', $location);
        }
        if (!empty($name) && !empty($location)) {
            $filteredMedecines = DB::table('medecines')
                ->select('medecines.*')
                ->join('pharmacies', 'pharmacies.id', '=', 'medecines.pharmacy_id')
                ->where('pharmacies.location', 'LIKE', '%' . $location . '%')
                ->where('medecines.name', 'LIKE', '%' . $name . '%');
            if (count($filteredMedecines->get()) == 0) {
                return back()->with('danger', 'your search did not match any medicine..please try again');
            }
            return view('Patient.searchByAll')->with('filteredmedecines', $filteredMedecines->simplePaginate(4))
                ->with('name', $name)->with('location', $location);
        }
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
