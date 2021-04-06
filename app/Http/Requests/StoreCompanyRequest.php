<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Company;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('edit company') || $this->user()->can('edit company situation');
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
            'name' => 'required|min:3|max:100',
            'nit' => 'required|min:3|max:50',
            'sector' => 'required|min:3|in:'.implode(",",Company::SECTORS),
            'country' => 'required|min:3',
            'state' => 'required|min:2',
            'city' => 'required|min:2',
            'situation' => 'min:2|in:'.implode(",",Company::SITUATIONS),
            'observation' => 'min:2',
            'documents.*' => 'mimes:jpeg,jpg,png,pdf'
        ];
    }
}
