<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Medecine;
use Illuminate\Http\Request;

class PatientMedecineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
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

    public function search(Request $request)
    {
        $medecineToSearch = $request->input('medecineToSearch');
        if (empty($medecineToSearch)) {
            return back()->with('danger', 'please enter a medecine to search');
        }
        $filteredMedecines = Medecine::where('name', 'LIKE', '%' . $medecineToSearch . '%');
        if (count($filteredMedecines->get()) == 0) {
            return back()->with('danger', 'your seach did not match any medicine..please try again');
        }
        // return $filteredMedecines->count();
        return view('Patient.search')->with('filteredmedecines', $filteredMedecines->simplePaginate(4))
            ->with('search', $medecineToSearch);
    }

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
