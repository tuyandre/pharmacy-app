<?php

namespace App\Http\Controllers\API\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class APIMedecineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function viewAllMedecines()
    {
        $medecines = Medecine::with('pharmacy')->get();
        return response()->json(['medecines' => $medecines], 200);
    }
    public function viewSingleMedecine($id)
    {
        $medecine = Medecine::with('pharmacy')->find($id);
        if (!$medecine) {
            return response()->json(['message' => 'No such medecine in the DB'], 404);
        }
        return response()->json(['medecine' => $medecine], 200);
    }
    public function searchMedecine(Request $request)
    {
        $medecineToSearch = $request->input('medecineToSearch');
        if (empty($medecineToSearch)) {
            return response()->json(['message' => 'Please enter something to search'], 400);
        }
        $filteredMedecines = Medecine::where('name', 'LIKE', '%' . $medecineToSearch . '%');
        if (count($filteredMedecines->get()) == 0) {
            return response()->json(['message' => 'your search did not match any medicine..please try again'], 404);
        }
        return response()->json(['search results' => $filteredMedecines->get()], 200);
    }
    public function addThisMedecineToCart($id)
    {
        $user = Auth::user()->id;
        $Medecine = Medecine::find($id);
        $checkIfUserHasCart = Cart::where('user_id', $user)->first();
        $checkIfUserHasOrder = Order::where('user_id', $user)->first();
        if ($checkIfUserHasOrder) {
            return response()->json(['message' => 'there are other medecines that you didn t go to pick'], 500);
        } else {
            if (!$checkIfUserHasCart) {
                $newCart = Cart::create([
                    'user_id' => $user
                ]);
                if ($newCart) {
                    $newCart->medecines()->attach($Medecine);
                }
                return response()->json(['message' => 'medecine added to your cart successful'], 200);
            } else {
                if (!$checkIfUserHasCart->medecines->contains($Medecine)) {
                    $checkIfUserHasCart->medecines()->attach($Medecine);
                    return response()->json(['message' => 'medecine added to your cart successful'], 200);
                }
                return response()->json(['message' => 'medecine already in your cart']);
            }
        }
    }
    public function removeThisMedecineFromCart($id)
    {
        $user = Auth::user()->id;
        $cart = Cart::where('user_id', $user)->first();
        $Medecine = Medecine::find($id);
        if ($cart->medecines()->detach($Medecine)) {
            if ($cart->medecines()->count() == 0) {
                $cart->delete();
                return response()->json(['message' => 'Medecine removed from your cart successful'], 200);
            }
            return response()->json(['message' => 'Medecine removed from your cart successful'], 200);
        }
        return response()->json(['message' => 'an error occured..please try again'], 500);
    }
    public function myCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('medecines')->first();
        if ($cart) {

            if ($cart->medecines()->count() > 0) {
                return response()->json(['my_cart' => $cart, 'number' => $cart->medecines()->count()]);
            }
            return response()->json(['message' => 'Dear ' . Auth()->user()->fname . ' ' . Auth()->user()->lname . ' your cart is currently empty']);
        }
        return response()->json(['message' => 'Dear ' . Auth()->user()->fname . ' ' . Auth()->user()->lname . ' your cart is currently empty']);
    }
    public function calculateTotal(Request $request)
    {
        $user = Auth::user()->id;
        $existingOrder = Order::where('user_id', $user);
        if (!$existingOrder->exists()) {
            //if the user hasn 't other medecines//
            $input = $request->all();
            for ($i = 0; $i < count($input['NberOfMedecines']); $i++) {
                // if empty fields
                if (empty($input['NberOfMedecines'][$i])) {
                    return response()->json(['message' => 'Please fill all fields'], 500);
                }
                //if completed files
                for ($j = 0; $j < count($input['Id']); $j++) {
                    $medecineCheck = Medecine::where('id', $input['Id'][$j])->value('numberOf');
                    $medecineName = Medecine::where('id', $input['Id'][$j])->value('name');
                    $medecinePrice = Medecine::where('id', $input['Id'][$j])->value('price');
                    if ($input['NberOfMedecines'][$j] > $medecineCheck) {
                        return response()->json(['message' => 'the book ' . $medecineName .  ' medecine has only ' .  $medecineCheck  . ' items in the stock '], 500);
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
                return response()->json(['message' => 'Order made successful'], 200);
            }
        }
        //if Orders exists before

    }
    public function myOrder()
    {
        $user = Auth::user()->id;
        $userOrder = Order::where('user_id', $user)->with('medecines')->first();
        $checkIfOrderExists = Order::where('user_id', $user)->exists();
        if ($checkIfOrderExists && $userOrder->medecines()->count() > 0) {
            $medecinesOrdered = $userOrder->medecines()->get();
            $totalToPay = $userOrder->medecines->sum('pivot.amount');
            return response()->json(['Medecines_ordered' => $medecinesOrdered, 'total_to_pay' => $totalToPay]);
        }
    }
}
