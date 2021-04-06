<?php

namespace App\Http\Controllers;

use App\Models\InternshipOffer;
use App\Models\Company;
use Illuminate\Http\Request;

use App\Http\Requests\StoreInternshipOfferRequest;

class InternshipOfferController extends Controller
{

    public function __construct()
    {
        
        // dd(Auth::user());
        $this->middleware('auth');
        $this->middleware(['permission:create offer|edit offer|delete offer'])->except(['index','show']);
        
        // $this->middleware(['role: coordinator'])->except(['index','show']);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        //

        $offers = $company->internshipOffers()->paginate(10);

        return view('company.internship_offer.index',[
            'company'=>$company,
            'offers'=>$offers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        //
        $types = InternshipOffer::TYPES;

        return view('company.internship_offer.create', [
            'types'=>$types,
            'company'=>$company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company, StoreInternshipOfferRequest $request)
    {
        //
        $offer = InternshipOffer::create([
            'company_id'=>$company->id,
            'position' =>$request->position,
            'duration_months'=>$request->duration,
            'type'=>$request->type,
            'schedule'=>$request->schedule,
            'contact_phone'=>$request->contact_phone,
            'contact_email'=>$request->contact_email,
            'vacancies'=>$request->vacancies,
            'description'=>$request->description
        ]);

        return redirect()->route('company.internship_offer.index',$company);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, InternshipOffer $internshipOffer)
    {
        //
        
        return view('company.internship_offer.show',['company'=>$company, 'offer'=>$internshipOffer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, InternshipOffer $internshipOffer)
    {
        //
        $types = InternshipOffer::TYPES;

        return view('company.internship_offer.edit', [
            'types'=>$types,
            'company'=>$company,
            'offer'=>$internshipOffer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInternshipOfferRequest $request, Company $company, InternshipOffer $internshipOffer)
    {
        //
        
        $internshipOffer->position = $request->position;
        $internshipOffer->duration_months = $request->duration;
        $internshipOffer->type = $request->type;
        $internshipOffer->schedule = $request->schedule;
        $internshipOffer->contact_phone = $request->contact_phone;
        $internshipOffer->contact_email = $request->contact_email;
        $internshipOffer->vacancies = $request->vacancies;
        $internshipOffer->description = $request->description;

        $internshipOffer->save();

        return redirect()->route('company.internship_offer.index',$company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, InternshipOffer $internshipOffer)
    {
        //
        $internshipOffer->delete();

        return back();
    }
}
