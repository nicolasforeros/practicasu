<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\InternshipOffer;

class StoreInternshipOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create offer') || $this->user()->can('edit offer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'position'=>'required',
            'duration'=>'required|numeric',
            'type'=> 'required|in:'.implode(",",InternshipOffer::TYPES),
            'schedule' => 'required',
            'contact_phone'=> 'required',
            'contact_email'=> 'required',
            'vacancies'=> 'required|numeric|integer',
            'description'=> 'required'
        ];
    }
}
