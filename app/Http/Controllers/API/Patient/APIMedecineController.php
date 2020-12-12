<?php

namespace App\Http\Controllers\API\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Medecine;

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
        $medecineToSearch = $request->input('medecine');
        if (empty($medecineToSearch)) {
            return response()->json(['message' => 'Please enter something to search'], 400);
        }
        $filteredMedecines = Medecine::where('name', 'LIKE', '%' . $medecineToSearch . '%');
        if (count($filteredMedecines->get()) == 0) {
            return response()->json(['message' => 'your search did not match any medicine..please try again'], 404);
        }
        return response()->json(['search results' => $filteredMedecines->get()], 200);
    }
}
