<?php

namespace App\Util\Filters;



class UserFilter extends Filter
{
    /**
     * Filter by firstName.
     * Get all the users by the given firstName.
     *
     * @param $firstName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function firstName($firstName)
    {
        return $this->builder->where('firs_name','like',$firstName.'%');
    }

    /**
     * Filter by lastName.
     * Get all the users by the given $lastName.
     *
     * @param $lastName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function lastName($lastName)
    {
        return $this->builder->where('last_name','like',$lastName.'%');
    }

    /**
     * Filter by personalCode.
     * Get all the users by the given $personalCode.
     *
     * @param $personalCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function personalCode($personalCode)
    {
        return $this->builder->where('personal_code','like',$personalCode.'%');
    }


}
