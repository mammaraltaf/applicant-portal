<?php

namespace App\Http\Requests\Facility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FacilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'address'  => ['required'],
            'city_id'     => ['required', 'numeric' , 'exists:cities,id'],
            'state_id'    => ['required', 'numeric' , 'exists:states,id'],
            'country_id'  => ['required', 'numeric' , 'exists:countries,id'],
            'zipcode'      => ['required']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'facility name is required',
            'address.required'  => 'address is required',
            'city_id.required'     => 'city is required',
            'state_id.required'    => 'state is required',
            'country_id.required'    => 'country is required',
            'zipcode.required'      => 'zipcode is required'
        ];
    }
}
