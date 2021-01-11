<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{

    public function __construct()
    {
        $this->middleware('superAdmin.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacies = Pharmacy::with('user')->get();
        return view('Super-Admin.Pharmacies.Index')->with('pharmacies', $pharmacies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pharmacies = Pharmacy::with('user')->get();
        return view('Super-Admin.Pharmacies.Create')->with('pharmacies', $pharmacies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return response()->json(['long' => $request['Plongitude'],'lati' => $request['Platitude']], 200);
        $Pname = $request->input('Pname');
        $Plocation = $request->input('Plocation');
        $Pdescription = $request->input('Pdescription');
        $Platitude = $request['Platitude'];
        $Plongitude = $request['Plongitude'];
        if (empty($Pname) || empty($Plocation) || empty($Pdescription)) {
            return back()->with('danger', 'please fill all fields');
        }
        $checkPharmacyName = Pharmacy::where('name', $Pname);
        if ($checkPharmacyName->exists()) {
            return back()->with('danger', 'there is a pharmacy with the same name');
        }
        $prefix = substr($Pname, 0, 3);
        $random = rand(9999999, 1234567);
        $postfix = "xyz";
        $fullcode = $prefix . $random . $postfix;
        $code = strtoupper($fullcode);
        $newPharmacy = Pharmacy::create([
            'name' => $Pname,
            'location' => $Plocation,
            'description' => $Pdescription,
            'code' => $code,
            'latitude' => $Platitude,
            'longitude' => $Plongitude
        ]);
        if ($newPharmacy) {
            return redirect()->route('pharmacies.index')->with('success', 'pharmacy created successfully..pharmacy code is  ' . $code . '');
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
        $pharma=Pharmacy::find($id);
        if ($pharma){
            return view('Super-Admin.Pharmacies.edit',['pharma'=>$pharma]);
//            return redirect()->route('pharmacies.edit')->with(['pharma'=>$pharma]);
        }else{
            return back()->with('danger', 'Invalid pharmacy');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pharma=Pharmacy::find($request['id']);
        if ($pharma){
            $pharma->name=$request['Pname'];
            $pharma->location=$request['Plocation'];
            $pharma->description=$request['Pdescription'];
            $pharma->latitude=$request['Platitude'];
            $pharma->longitude=$request['Plongitude'];
            $pharma->save();
            return redirect()->route('pharmacies.index')->with('success', 'pharmacy updated successfully..');

        }else{
            return back()->with('danger', 'Invalid pharmacy');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pharm=Pharmacy::find($id);
        if ($pharm){
            $pharm->delete();
            return response()->json(['pharma' => "ok"], 200);
        }
        return response()->json(['pharma' => "not"], 500);
    }
    public function pharmacist(){
//        $pharmacist = Pharmacy::with('user')->get();
        $pharmacist = User::with(['Pharmacy'])->where('role','=','Pharmacist')->get();
        return view('Super-Admin.Pharmacies.pharmacist')->with('pharmacists', $pharmacist);
    }
    public function patients(){
        $patient = User::where('role','=','Patient')->get();
        return view('Super-Admin.Pharmacies.patients')->with('patients', $patient);
    }
}
