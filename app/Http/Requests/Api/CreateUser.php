<?php

namespace App\Http\Requests\Api;

class CreateUser extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|max:255|unique:users',
            'personal_code' => 'required',
            'phone' => 'max:255',
            'password' => 'required|min:6|max:255',
        ];
    }
}
