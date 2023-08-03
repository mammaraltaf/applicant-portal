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
            'facility' => ['required'],
            'address'  => ['required'],
            'city'     => ['required'],
            'state'    => ['required'],
            'zip'      => ['required']
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
            'facility.required' => 'facility is required',
            'address.required'  => 'address is required',
            'city.required'     => 'city is required',
            'state.required'    => 'state is required',
            'zip.required'      => 'zip is required'
        ];
    }
}
