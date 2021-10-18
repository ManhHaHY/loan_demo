<?php

namespace App\Http\Requests\Api;

class UpdateUser extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
//    public function validationData()
//    {
//        return $this->get('car') ?: [];
//    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'personalCode' => 'required',
            'email' => 'required|email|max:255,unique:users,'.$this->user,
        ];
    }

}
