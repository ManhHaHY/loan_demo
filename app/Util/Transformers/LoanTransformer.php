<?php

namespace App\Util\Transformers;

class LoanTransformer extends Transformer
{
    protected $resourceName = 'loan';


    /**
     * Transform a collection of UserRepo items we can add extra data like custom attribute definded in LoanRepo model.
     *
     * @param Collection $loan
     * @return array
     */
    public function transform($loan)
    {
        $loan['userfull_name']=$loan->user->first_name . ' ' . $loan->user->last_name;
        return $loan;

    }
}
