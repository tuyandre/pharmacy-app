<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;

class AuthController extends Controller
{
    protected $redirects;
    public function login(Request $request)
    {
        $phoneNo =  $request->input('phoneNo');
        $password =  $request->input('password');
        if (empty($phoneNo) || empty($password)) {
            return back()->with('danger', 'please fill all fields');
        }
        if (Auth::attempt(['phone_no' => $phoneNo, 'password' => $password])) {
            return $this->redirects();
        }
        return back()->with('danger', 'invalid phone number of password');
    }
    public static function redirects()
    {
        $role = Auth::user()->role;
        // return $role;
        if ($role == 'Super-Admin') {
            return redirect('pharmacies');
        } elseif ($role == 'Pharmacist') {
            return redirect('medecines');
        } else {
            return redirect('/');
        }
    }

    public function register(Request $request)
    {
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $location = $request->input('location');
        $phoneNo = $request->input('phoneNo');
        $role = $request->input('role');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        if (empty($fname) || empty($role) || empty($lname) || empty($location) || empty($phoneNo) || empty($password) || empty($password_confirmation)) {
            return back()->with('danger', 'please fill all fields');
        }
        if (!$this->validatePhoneNumber($phoneNo)) {
            return back()->with('danger', 'invalid phone number');
        }
        if (strlen($password) < 8) {
            return back()->with('danger', 'password must be at least 8 characters');
        }
        if ($password !== $password_confirmation) {
            return back()->with('danger', 'password confirmation does not match');
        }
        $checkPhone = User::where('phone_no', $phoneNo)->exists();
        if ($checkPhone) {
            return back()->with('danger', 'the telephone number provided has already been registered');
        }
        if ($role == "Pharmacist") {
            $code = $request->input('pharmacyCode');
            if (empty($code)) {
                return back()->with('danger', 'please provide your pharmacy code');
            }
            //Querying the pharmacist Code if it exists or not
            $codeCheck = Pharmacy::where('code', $code);
            if (!$codeCheck->exists()) {
                return back()->with('danger', 'the code provided did not match any pharmacy');
            }
            //if the code already registered
            if ($codeCheck->value('user_id') !== NULL) {
                return back()->with('danger', 'this pharmacy has its own owner');
            }

            $user = User::create([
                'fname' => $fname,
                'lname' => $lname,
                'phone_no' => $phoneNo,
                'role' => $role,
                'password' => Hash::make($password)
            ]);
            if ($user) {
                $updatePharmacy = Pharmacy::where('code', $code)->update([
                    'user_id' => $user->id
                ]);
                if ($updatePharmacy) {
                    Auth::login($user);
                    return redirect()->route('medecines.index');
                }
                Auth::login($user);
                return redirect()->route('medecines.index');
            }
        } else {
            //save a patient
            $user = User::create([
                'fname' => $fname,
                'lname' => $lname,
                'phone_no' => $phoneNo,
                'role' => $role,
                'password' => Hash::make($password)
            ]);
            if ($user) {
                Auth::login($user);

                return redirect('/');
            }
        }
    }
    function validatePhoneNumber($telNo)
    {
        $number = filter_var($telNo, FILTER_SANITIZE_NUMBER_INT);
        if (strlen($number) < 12) {
            return false;
        } else {
            return true;
        }
    }
}
