<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

use App\Models\CompanyDocument;

class CompanyController extends Controller
{
    public function __construct()
    {
        
        // dd(Auth::user());
        
        $this->middleware('auth');
        $this->middleware(['permission:create company|edit company|delete company'])->except(['index','show']);
        // $this->middleware(['role: coordinator'])->except(['index','show']);
        
    }

    /**
     * Obtain all the countries calling an api
     * 
     * @return array $countries
     */
    public function getCountries()
    {
        $client = new Client([            
            'base_uri' => 'https://countriesnow.space/api/v0.1/', 
            
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
        
        $response = $client->request('GET', 'countries');
        
        $countriesData = json_decode($response->getBody()->getContents());
        
        $countries = array_map(
            function ($country) {
                return $country->country;
            },
            $countriesData->data
        );
        
        return $countries;
    }

    /**
     * Obtain all the states of a determined country
     * 
     * @param string $country
     * @return array $states
     */
    public static function getStatesOfCountry($country)
    {
        $client = new Client([            
            'base_uri' => 'https://countriesnow.space/api/v0.1/', 
            
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);

        $response = $client->request('POST', 'countries/states',[
            'json' => ['country' => $country]
        ]);
        
        $statesData = json_decode($response->getBody()->getContents());

        $states = $statesData->data->states;

        return $states;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderby('id')->paginate(10);

        return view('company.index',[
            'companies'=>$companies
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
        $sectors = Company::SECTORS;
        $countries = self::getCountries();

        return view('company.create', [
            'sectors'=>$sectors,
            'countries'=>$countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        //
        // dd(request('name'));

        $company = Company::create($request->validated());

        $this->uploadDocument($request,$company);

        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
        return view('company.show',['company'=>$company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
        $sectors = Company::SECTORS;
        $situations = Company::SITUATIONS;
        $countries = self::getCountries();

        return view('company.edit', [
            'sectors'=>$sectors,
            'situations'=>$situations,
            'countries'=>$countries,
            'company'=>$company
        ]);
    }

    // /**
    //  * Show the form for editing the situation of the specified resource.
    //  *
    //  * @param  \App\Models\Company  $company
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit_situation(Company $company)
    // {
    //     //
    //     $sectors = Company::SECTORS;
    //     $countries = self::getCountries();

    //     return view('company.edit', [
    //         'sectors'=>$sectors,
    //         'countries'=>$countries,
    //         'company'=>$company
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompanyRequest $request, Company $company)
    {
        //
        // dd($request->all());
        $company->update($request->validated());

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        $company->delete();

        return back();
    }

    /**
     * Upload a company related document
     */
    public function uploadDocument(Request $request, Company $company){

        // dd($request->documents);

        foreach ($request->documents as $key=>$document) {
            $filename = $company->id ."-" . $key ."-" . time() . "." . $document->extension();

            $document->move(public_path('documents'),$filename);

            CompanyDocument::create(['company_id'=> $company->id, 'filename'=>$filename]);
        }

    }
}
