<?php

namespace App\Http\Requests\Api;

class CreateLoan extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'amount_to_pay' => 'required',
            'interest' => 'required',
            'duration' => 'required',
            'date_applied' => 'required',
            'date_loan_ends' => 'required',
        ];
    }
}
