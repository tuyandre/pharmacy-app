<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\Patient\APIMedecineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//
Route::group([
    'middleware' => 'api'

], function ($router) {
    Route::post('login', [APIAuthController::class, 'login']);
    Route::post('register', [APIAuthController::class, 'register']);
    Route::post('logout', [APIAuthController::class, 'logout']);
});
//Patient

Route::get('viewAllMedecines', [APIMedecineController::class, 'viewAllMedecines']);
Route::get('viewSingleMedecine/{id}', [APIMedecineController::class, 'viewSingleMedecine']);
Route::post('searchMedecine', [APIMedecineController::class, 'searchMedecine']);
