<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Instruction;
use App\Models\Pharmacy;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
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
        $instructions = Instruction::with('medecine')->get();
        return view('Pharmacist.Instructions.Instructions')->with('instructions', $instructions)
            ->with('institutions', $institutions)->with('pharmacyId', $pharmacyId)
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
        $medecines = Medecine::where('pharmacy_id', $pharmacyId)->get();
        $institutions = Institution::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Instructions.CreateInstruction')->with('institutions', $institutions)->with('pharmacyId', $pharmacyId)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions)->with('medecines', $medecines);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Instruction = $request->input('Instruction');
        $medecine = $request->input('medecine');
        if (empty($Instruction) || empty($medecine)) {
            return back()->with('danger', 'please fill all fields');
        } else {
            $newInstruction = Instruction::create([
                'name' => $Instruction,
                'medecine_id' => $medecine,
            ]);
            if ($newInstruction) {
                return redirect()->route('instructions.index')->with('success', 'new instruction registered successful');
            }
            return back()->with('danger', 'an error occured..please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $loggedInAdmin = Auth::user()->id;
        // $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        // $institutions = Institution::where('pharmacy_id', $pharmacyId)->get();
        // $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        // $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        // $medecine = Medecine::with('instructions')->find($id);
        // return view('Pharmacist.Medecines.Instructions')->with('institutions', $institutions)->with('pharmacyId', $pharmacyId)
        //     ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions)->with('medecine', $medecine);
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
