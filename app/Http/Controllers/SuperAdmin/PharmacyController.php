<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
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
        $Pname = $request->input('Pname');
        $Plocation = $request->input('Plocation');
        $Pdescription = $request->input('Pdescription');
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
            'code' => $code
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
