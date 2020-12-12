<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;

use Illuminate\Http\Request;

class viewPharmacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('Patient.auth');
    }
    public function viewThisPharmacy($id)
    {
        $pharmacyToView = Pharmacy::find($id);
        return view('Patient.Pharmacy')->with('pharmacyToView', $pharmacyToView);
    }
}
