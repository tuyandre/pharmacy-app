<?php

namespace App\Http\Controllers\API\Patient;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class APIMedecineController extends Controller
{

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
    public function addThisMedecineToCart(Request $request)
    {
        $user = User::find($request->user);
        $Medecine = Medecine::find($request->medecine);
        $checkIfUserHasCart = Cart::where('user_id', $user->id)->first();
        $checkIfUserHasOrder = Order::where('user_id', $user->id)->first();
        if ($checkIfUserHasOrder) {
            return response()->json(['message' => 'there are other medecines that you didn t go to pick'], 500);
        } else {
            if (!$checkIfUserHasCart) {
                $newCart = Cart::create([
                    'user_id' => $user->id
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
    public function removeThisMedecineFromCart(Request $request)
    {
        $user = User::find($request->user);
        $cart = Cart::where('user_id', $user->id)->first();
        $Medecine = Medecine::find($request->medecine);
        if ($cart->medecines()->detach($Medecine)) {
            if ($cart->medecines()->count() == 0) {
                $cart->delete();
                return response()->json(['message' => 'Medecine removed from your cart successful'], 200);
            }
            return response()->json(['message' => 'Medecine removed from your cart successful'], 200);
        }
        return response()->json(['message' => 'an error occured..please try again'], 500);
    }
    public function myCart(Request $request)
    {
        $user = User::find($request['id']);
        $cart = Cart::where('user_id', $request->id)->with('medecines')->first();
        if ($cart) {

            if ($cart->medecines()->count() > 0) {
                return response()->json(['my_cart' => $cart, 'number' => $cart->medecines()->count()]);
            }
            return response()->json(['message' => 'Dear ' . $user->fname . ' ' . $user->lname . ' your cart is currently empty']);
        }
        return response()->json(['message' => 'Dear ' . $user->fname . ' ' . $user->lname . ' your cart is currently empty']);
    }
    public function calculateTotal(Request $request)
    {
        $user = User::find($request->user);
        $existingOrder = Order::where('user_id', $user->id);
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
                        'user_id' => $user->id
                    ];
                }
            }
            $makeOrder = Order::create($data);
            if ($makeOrder) {
                $Order_Medecine = Order::where('user_id', $user->id)->first();
                $Cart = Cart::where('user_id', $user->id)->first();
                for ($i = 0; $i < count($input['Id']); $i++) {
                    $medecinePrice = Medecine::where('id', $input['Id'][$i])->value('price');
                    $items = $input['NberOfMedecines'][$i];
                    $Order_Medecine->medecines()->attach(
                        $input['Id'][$i],
                        array('items' => $items, 'amount' => $medecinePrice * $items)
                    );
                }
                $Cart = Cart::where('user_id', $user->id)->first();
                $CartDeletion = Cart::where('user_id', $user->id);
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
