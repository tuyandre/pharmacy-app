<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medecine;
use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('Pharmacist.auth');
    }
    public function myOrders()
    {
        $AuthenticatedPharmacist = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $AuthenticatedPharmacist)->value('id');
        $myOrders = Order::with('medecines')->get();
        $myMedecines = Medecine::where('pharmacy_id', $pharmacyId)->get();
        $pharmacyName = Pharmacy::where('user_id', $AuthenticatedPharmacist)->value('name');
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Orders.order')->with('orders', $myOrders)->with('myMedecines', $myMedecines)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions)
            ->with('pharmacyName', $pharmacyName);
    }
    public function changeOrder($id)
    {
        $order = Order::where('id', $id)->value('status');
        if ($order == 1) {

            $userUpdate = Order::where('id', $id)
                ->update([
                    'status' => 0
                ]);
            if ($userUpdate) {
                return back()->with('success', 'order successfully changed to completed');
            }
            return back()->withInput()->with('danger', 'Please Try again');
        } else {
            $userUpdate = Order::where('id', $id)
                ->update([
                    'status' => 1
                ]);
            if ($userUpdate) {
                return back()->with('success', 'order successfully changed to Pending');
            }
            return back()->withInput()->with('danger', 'Please Try again');
        }
    }
}
