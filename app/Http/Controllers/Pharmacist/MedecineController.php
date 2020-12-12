<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\Medecine;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use Image;
use Storage;
use Illuminate\Support\Facades\File;

class MedecineController extends Controller
{
    public function __construct()
    {
        $this->middleware('Pharmacist.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $pharmacyName = Pharmacy::where('user_id', $loggedInAdmin)->value('name');
        $medecines = Medecine::where('pharmacy_id', $pharmacyId)->get();
        $orders = Order::with('medecines')->get();

        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Medecines.Index')->with('medecines', $medecines)->with('pharmacyName', $pharmacyName)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions)
            ->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $pharmacyName = Pharmacy::where('user_id', $loggedInAdmin)->value('name');
        $medecines = Medecine::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        return view('Pharmacist.Medecines.Create')->with('medecines', $medecines)->with('pharmacyName', $pharmacyName)->with('pharmacyId', $pharmacyId)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $MedecineName = $request->input('Mname');
        $MedecineItems = $request->input('Mitems');
        $MedecinePrice = $request->input('Mprice');
        $MedecineImage = $request->file('Mimage');
        $MedecineDescription = $request->input('Mdescription');
        $pharmacyId = $request->input('Pid');
        if (empty($MedecineName) || empty($MedecinePrice) || empty($MedecineItems) || empty($MedecineDescription)) {
            return back()->with('danger', 'please fill all fields');
        }
        if (!is_numeric($MedecineItems)) {
            return back()->with('danger', 'please enter a valid number of medecines available');
        }
        if (!is_numeric($MedecinePrice)) {
            return back()->with('danger', 'please enter a valid Price of the medecine');
        }
        if (empty($MedecineImage)) {
            return back()->with('danger', 'provide an Image for the medecine');
        }
        if ($request->hasFile('Mimage')) {
            $file = $request->file('Mimage');
            $filename = $file->getClientOriginalName();
            Image::make($file->getRealPath())->resize(600, 600)->save(public_path('/storage/MedecineImages/' . $filename));
            $newMedecine = Medecine::create([
                'image' => $filename,
                'pharmacy_id' => $pharmacyId,
                'name' => $MedecineName,
                'numberOf' => $MedecineItems,
                'price' => $MedecinePrice,
                'description' => $MedecineDescription
            ]);
            if ($newMedecine) {
                return redirect()->route('medecines.index')->with('success', 'new Medecine registered successful');
            }
            return back()->with('danger', 'an error occured..please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loggedInAdmin = Auth::user()->id;
        $pharmacyId = Pharmacy::where('user_id', $loggedInAdmin)->value('id');
        $pharmacyName = Pharmacy::where('user_id', $loggedInAdmin)->value('name');
        $medecines = Medecine::where('pharmacy_id', $pharmacyId)->get();
        $numberOfMedecines = Medecine::where('pharmacy_id', $pharmacyId)->count();
        $numberOfInstitutions = Institution::where('pharmacy_id', $pharmacyId)->count();
        $medecineToEdit = Medecine::find($id);
        return view('Pharmacist.Medecines.Edit')->with('medecineToEdit', $medecineToEdit)->with('medecines', $medecines)->with('pharmacyName', $pharmacyName)->with('pharmacyId', $pharmacyId)
            ->with('numberOfMedecines', $numberOfMedecines)->with('numberOfInstitutions', $numberOfInstitutions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $MedecineName = $request->input('Mname');
        $MedecineItems = $request->input('Mitems');
        $MedecinePrice = $request->input('Mprice');
        $MedecineDescription = $request->input('Mdescription');
        if (empty($MedecineName) || empty($MedecinePrice) || empty($MedecineItems) || empty($MedecineDescription)) {
            return back()->with('danger', 'please fill all fields');
        }
        if (!is_numeric($MedecineItems)) {
            return back()->with('danger', 'please enter a valid number of medecines available');
        }
        if (!is_numeric($MedecinePrice)) {
            return back()->with('danger', 'please enter a valid Price of the medecine');
        }
        $updateMedecine = Medecine::find($id)->update([
            'name' => $MedecineName,
            'numberOf' => $MedecineItems,
            'price' => $MedecinePrice,
            'description' => $MedecineDescription
        ]);
        if ($updateMedecine) {
            return redirect()->route('medecines.index')->with('success', 'Medecine updated successful');
        }
        return back()->with('danger', 'an error occured..please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medecine $medecine, Request $request)
    {
        $Id = $request->input('Id');
        $medecineToDelete = Medecine::where('id', $Id)->value('id');
        $order = Order::whereHas('medecines', function ($q) use ($medecineToDelete) {
            $q->where('medecine_id', $medecineToDelete);
        })->count();

        if ($order > 0) {
            return back()->with('danger', 'there are patients who booked this medecine');
        }
        $cart = Cart::whereHas('medecines', function ($q) use ($medecineToDelete) {
            $q->where('medecine_id', $medecineToDelete);
        })->count();

        if ($cart > 0) {
            return back()->withInput()->with('danger', 'Several Users have put this medecine in their cart');
        }
        $medecine_delete = Medecine::where('id', $medecine->id)->delete();
        if ($medecine_delete) {
            return redirect()->route('medecines.index')->with('success', 'medecine deleted successfully');
        }
        return back()->withInput()->with('danger', 'medecine could not be deleted');
    }
}
