<?php

namespace App\Util\Filters;

class PaymentFilter extends Filter
{
    /**
     * Filter by amount greater than
     * Get all the loans by the amount greater than $amount.
     *
     * @param $amount
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function minPrice($amount)
    {
        return $this->builder->where('amount', '>=', $amount);
    }

    /**
     * Filter by amount lower than amount
     * Get all the loans by the amount lower than $amount.
     *
     * @param $amount
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function maxPrice($amount)
    {
        return $this->builder->where('amount', '<=', $amount);
    }

    /**
     * Filter by amount lower than amount
     * Get all the loans by the amount lower than $amount.
     *
     * @param $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($status)
    {
        return $this->builder->where('status', '=', $status);
    }
}
