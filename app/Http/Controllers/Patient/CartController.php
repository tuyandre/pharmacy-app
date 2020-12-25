<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Medecine;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('Patient.auth');
    }
    public function myCart()
    {
        $user = Auth::user()->id;
        $cart = Cart::where('user_id', $user)->with('medecines')->first();
        if ($cart->medecines()->count() > 0) {
            return view('Patient.cart')->with('cart', $cart);
        }
        return redirect()->route('patientMedecines.index')->with('danger', 'your cart is empty');
    }
    public function myTotal()
    {
        $user = Auth::user()->id;
        $userOrder = Order::where('user_id', $user)->with('medecines')->first();
        $checkIfOrderExists = Order::where('user_id', $user)->exists();
        if ($checkIfOrderExists && $userOrder->medecines()->count() > 0) {
            return view('Patient.total')->with('userOrder', $userOrder);
        }
        return redirect()->route('patientMedecines.index')->with('danger', 'you have no medecines ordered');
    }
    public function addMedecineToCart(Request $request)
    {
        $user = Auth::user()->id;
        $MedecineId = $request->input('MId');
        $checkIfUserHasCart = Cart::where('user_id', $user)->first();

        //if there is no cart
        if (!$checkIfUserHasCart) {
            $newCart = Cart::create([
                'user_id' => $user
            ]);
            if ($newCart) {
                $newCart->medecines()->attach($MedecineId);
            }
            return redirect()->route('patientMedecines.index')->with('success', 'medecine added to your cart');
        }
        //if there is cart
        else {
            if (!$checkIfUserHasCart->medecines->contains($MedecineId)) {
                $checkIfUserHasCart->medecines()->attach($MedecineId);
                return redirect()->route('patientMedecines.index')->with('success', 'medecine added to your cart');
            }
            return back()->with('danger', 'medecine already in your cart');
        }
    }
    public function removeMedecineFromCart(Medecine $medecine, Request $request)
    {
        $user = Auth::user()->id;
        $cart = Cart::where('user_id', $user)->first();
        $medecine_id = $request->input('medecineId');
        $medecine = Medecine::find($medecine_id);
        if ($cart->medecines()->detach($medecine_id)) {
            if ($cart->medecines()->count() == 0) {
                $cart->delete();
                return redirect()->route('patientMedecines.index')->with('success', 'medecine removed from your cart..your cart is now empty');
            }
            return back()->with('success', 'medecine removed from your cart');
        }
        return back()->with('danger', 'please try again');
    }
    public function calculateTotal(Request $request)
    {
        $user = Auth::user()->id;
        $input = $request->all();
        for ($i = 0; $i < count($input['NberOfMedecines']); $i++) {
            // if empty fields
            if (empty($input['NberOfMedecines'][$i])) {
                return back()->with('danger', 'Please fill all fields');
            }
            // if completed fields
            for ($j = 0; $j < count($input['Id']); $j++) {
                $medecineCheck = Medecine::where('id', $input['Id'][$j])->value('numberOf');
                $medecineName = Medecine::where('id', $input['Id'][$j])->value('name');
                $medecinePrice = Medecine::where('id', $input['Id'][$j])->value('price');
                if ($input['NberOfMedecines'][$j] > $medecineCheck) {
                    return back()->with('danger', 'the ' . $medecineName .  ' medecine has only ' .  $medecineCheck  . ' items in the stock ');
                }
                $data = [
                    'user_id' => Auth::user()->id
                ];
            }
        }
        $makeOrder = Order::create($data);
        if ($makeOrder) {
            $Order_Medecine = Order::where('user_id', $user)->first();
            $Cart = Cart::where('user_id', $user)->first();
            for ($i = 0; $i < count($input['Id']); $i++) {
                $medecinePrice = Medecine::where('id', $input['Id'][$i])->value('price');
                $items = $input['NberOfMedecines'][$i];
                $Order_Medecine->medecines()->attach(
                    $input['Id'][$i],
                    array('items' => $items, 'amount' => $medecinePrice * $items)
                );
            }
            $Cart = Cart::where('user_id', $user)->first();
            $CartDeletion = Cart::where('user_id', $user);
            if ($Cart->medecines()->detach()) {
                $CartDeletion->delete();
            }
            return redirect()->route('myTotal')->with('success', "here are the medecines you requested..you have to pass by each medecine's pharmacy to take them");
        }
        //if the user requested other medecines
    }
}
