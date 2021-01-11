<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class HomeController extends Controller
{
    public function welcomePage()
    {
        $medecines = Medecine::with('pharmacy')->get();
        $MinimumMedecinePrice = Medecine::get()->min('price');
        $MedecinesCarousel =  DB::table('medecines')->limit(4)->latest()->get();
        return view('welcome')->with('medecines', $medecines)
            ->with('MinPrice', $MinimumMedecinePrice)->with('medecinesCarousel', $MedecinesCarousel);
    }
    public function maps(){
        return view('googleMap');
    }
    public function AboutPage()
    {
        return view('about');
    }
    public function contactPage()
    {
        return view('contact');
    }
    public function printInstructions($id)
    {
        $medecine = Medecine::find($id);
        $data = ['medecine' => $medecine];
        $pdf = PDF::loadView('Patient.Instructions', compact('medecine'));
        $pdf->save(storage_path() . '_resultsPrint.pdf');
        return $pdf->download('resultsPrint.pdf');
    }
    public function adminRegisterPage(Request $request){
        return view('auth.adminRegister');
    }
}
