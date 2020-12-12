<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Pharmacy;
use Validator;

class APIAuthController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }
    public function register(Request $request)
    {
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $location = $request->input('location');
        $phoneNo = $request->input('phone_no');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        if (empty($fname)  || empty($lname) || empty($location) || empty($phoneNo) || empty($password) || empty($password_confirmation)) {
            return response()->json(['message' => 'please fill all fields'], 400);
        }
        if (!$this->validatePhoneNumber($phoneNo)) {
            return response()->json(['message' => 'invalid Phone number'], 400);
        }
        if (strlen($password) < 8) {
            return response()->json(['message' => 'password must be at least 8 characters'], 400);
        }
        if ($password !== $password_confirmation) {
            return response()->json(['message' => 'password confirmation does not match'], 400);
        }
        $checkPhone = User::where('phone_no', $phoneNo)->exists();
        if ($checkPhone) {
            return response()->json(['message' => 'the telephone number provided has been already taken'], 400);
        }

        //save a patient
        $user = User::create([
            'fname' => $fname,
            'lname' => $lname,
            'phone_no' => $phoneNo,
            'role' => 'Patient',
            'password' => Hash::make($password)
        ]);
        if ($user) {
            return response()->json([
                'message' => 'Patient successfully registered',
                'user' => $user,
            ], 201);
        }
    }
    function validatePhoneNumber($telNo)
    {
        $number = filter_var($telNo, FILTER_SANITIZE_NUMBER_INT);
        if (strlen($number) !== 12) {
            return false;
        } else {
            return true;
        }
    }
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'User successfully signed out']);
    }
    protected function createNewToken($token)
    {
        //return $token;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
