<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\Patient\APIMedecineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('mobile/login', [APIAuthController::class, 'mobileLogin']);
Route::post('mobile/register', [APIAuthController::class, 'mobileRegister']);
Route::post('mobile/logout', [APIAuthController::class, 'logout']);



Route::get('viewAllMedecines', [APIMedecineController::class, 'viewAllMedecines']);
Route::post('myCart', [APIMedecineController::class, 'myCart']);
//Route::get('viewSingleMedecine/{id}', [APIMedecineController::class, 'viewSingleMedecine']);
Route::post('searchMedecine', [APIMedecineController::class, 'searchMedecine']);
Route::post('addThisMedecineToCart', [APIMedecineController::class, 'addThisMedecineToCart']);
Route::post('removeThisMedecineFromCart', [APIMedecineController::class, 'removeThisMedecineFromCart']);
Route::post('calculateTotal', [APIMedecineController::class, 'calculateTotal']);
Route::get('myTotal', [APIMedecineController::class, 'myOrder']);
