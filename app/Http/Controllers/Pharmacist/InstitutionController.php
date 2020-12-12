<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\Institution;
use App\Models\Medecine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('Pharmacist.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $institutions = Institution::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Institutions.Index')->with('institutions', $institutions)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $institutions = Institution::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Institutions.Create')->with('institutions', $institutions)->with('pharmacyId', $pharmacyId)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $InstitutionName = $request->input('Iname');
        $pharmacyId = $request->input('Pid');
        if (empty($InstitutionName)) {
            return back()->with('danger', 'provide the Institution Name');
        }
        $newInstitution = Institution::create([
            'name' => $InstitutionName,
            'pharmacy_id' => $pharmacyId,
        ]);
        if ($newInstitution) {
            return redirect()->route('institutions.index')->with('success', 'new institution registered successful');
        }
        return back()->with('danger', 'an error occured..please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $institutions = Institution::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        $institutionToEdit = Institution::find($id);
        return view('Pharmacist.Institutions.Edit')->with('institutions', $institutions)->with('pharmacyId', $pharmacyId)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions)
            ->with('institutionToEdit', $institutionToEdit);
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
        $Id = $request->input('Iid');
        $InstName = $request->input('Iname');
        if (empty($InstName)) {
            return back()->with('danger', 'please provide the Institution name');
        }
        $institutionToEdit = Institution::where('id', $Id)->update([
            'name' => $InstName
        ]);
        if ($institutionToEdit) {
            return redirect()->route('institutions.index')->with('success', 'institution updated succssful');
        }
        return back()->with('danger', 'an error occured..please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionToDelete = Institution::find($id)->delete();
        if ($institutionToDelete) {
            return redirect()->route('institutions.index')->with('success', 'Institution deleted successful');
        }
        return back()->with('danger', 'please try again');
    }
}
