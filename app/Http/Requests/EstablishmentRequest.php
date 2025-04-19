<?php

namespace App\Http\Requests;

/**
 * Class EstablishmentRequest
 * @package App\Http\Requests
 */
class EstablishmentRequest extends Request
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
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'hint' => '',
            'phone' => '',
            'description'  => '',
            'city_id'  => 'required|numeric|exists:cities,id',
        ];
    }
}
