<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Patient\CartController;
use App\Http\Controllers\Patient\PatientMedecineController;
use App\Http\Controllers\Pharmacist\MedecineController;
use App\Http\Controllers\Pharmacist\OrderController;
use App\Http\Controllers\Pharmacist\InstitutionController;
use App\Http\Controllers\SuperAdmin\PharmacyController;
use App\Http\Controllers\Patient\viewPharmacyController;
use App\Http\Controllers\Pharmacist\InstructionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Before Authentication
Route::get('/', [HomeController::class, 'welcomePage']);
Route::get('/about', [HomeController::class, 'AboutPage']);
Route::get('redirects', [AuthController::class, 'redirects']);
Route::post('/register', [AuthController::class, 'register'])->name('registration');
Route::post('/login', [AuthController::class, 'login'])->name('authentication');

//Super Admin
Route::resource('pharmacies', PharmacyController::class);
// Route::get('/pharmacies', [PharmacyController::class, 'index'])->name('pharmacies.index');

//Pharmacist
Route::resource('medecines', MedecineController::class);
Route::resource('institutions', InstitutionController::class);
Route::resource('instructions', InstructionController::class);
Route::get('myOrders', [OrderController::class, 'myOrders'])->name('myOrders');

//Patient
Route::resource('/patientMedecines', PatientMedecineController::class);
Route::get('/searchByName', [PatientMedecineController::class, 'searchByName'])->name('searchByName');
Route::get('/searchByLocation', [PatientMedecineController::class, 'searchByLocation'])->name('searchByLocation');
Route::get('/myCart', [CartController::class, 'myCart'])->name('myCart');
Route::post('/addMedecineToCart', [CartController::class, 'addMedecineToCart'])->name('addMedecineToCart');
Route::delete('/removeMedecineFromCart/{id}', [CartController::class, 'removeMedecineFromCart'])->name('removeMedecineFromCart');
Route::get('/pharmacy/{id}', [viewPharmacyController::class, 'viewThisPharmacy'])->name('viewThisPharmacy');
Route::post('/calculateTotal', [CartController::class, 'calculateTotal'])->name('calculateTotal');
Route::get('/myTotal', [CartController::class, 'myTotal'])->name('myTotal');
Route::get('/printInstructions/{id}', [HomeController::class, 'printInstructions'])->name('printInstructions');
