<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function AboutPage()
    {
        return view('about');
    }
    public function pay()
    {
        return 123;
    }
}
