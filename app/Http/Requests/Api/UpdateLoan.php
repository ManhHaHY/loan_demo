<?php

namespace App\Http\Requests\Api;

class UpdateLoan extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required',
            'interest' => 'required',
            'duration' => 'required',
            'date_applied' => 'required',
            'date_loan_ends' => 'required',
        ];
    }

}
