<?php

namespace App\Util\Filters;


class LoanFilter extends Filter
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
     * Filter by name .
     * Get all the loans by the name of user (firstname or lastname).
     *
     * @param $amount
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($name)
    {
        return $this->builder->whereHas('user', function ($query) use ($name) {
            $query->where('first_name', 'like', $name . '%')
                ->orWhere('last_name', 'like', $name . '%');
        });
    }


}
