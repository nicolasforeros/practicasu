<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

use App\Models\InternshipOffer;
use App\Models\Company;
use App\Models\User;

use App\Http\Requests\StoreApplicationRequest;

class ApplicationController extends Controller
{

    public function __construct()
    {
        
        // dd(Auth::user());
        $this->middleware('auth');
        $this->middleware(['permission:send application'])->only(['store']);
        $this->middleware(['permission:accept application'])->only(['index','update']);
        
        // $this->middleware(['role: coordinator'])->except(['index','show']);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company, InternshipOffer $offer)
    {
        //
        $applications = $offer->applications()->paginate(10);
        
        $states = Application::STATES;

        return view('company.internship_offer.application.index',[
            'company'=>$company,
            'offer'=>$offer,
            'applications'=>$applications,
            'states'=>$states
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company, InternshipOffer $internshipOffer, StoreApplicationRequest $request)
    {
        //
        $application = Application::where('user_id',auth()->user()->id)->where('internship_offer_id',$internshipOffer->id);

        if ($company->situation == Company::SITUATIONS[1] && $internshipOffer->vacancies > 0 && !isset($application)) {
            $application = Application::create([
                'user_id'=>auth()->user()->id,
                'internship_offer_id' =>$internshipOffer->id
            ]);

            return redirect()->route('company.internship_offer.index', [$company]);
        } else {
            return redirect()->back()->withErrors('Unavailable Internship Offer')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(StoreApplicationRequest $request, Company $company, InternshipOffer $offer, Application $application)
    {
        //
        if ($company->situation == Company::SITUATIONS[1] && $offer->vacancies > 0) {
            
            $application->state = $request->state;

            if ($request->state == Application::STATES[1]) {
                $offer->vacancies -= 1;
                $offer->save();
            }

            $application->save();

            return redirect()->route('company.internship_offer.application.index', [$company, $offer]);

        } else {
            abort(422, 'Unavailable Internship Offer');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
