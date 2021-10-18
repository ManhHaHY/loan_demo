<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'loan_id',
        'reference_no',
        'payment_mode',
        'approved',
        'description'
    ];
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
    /**
     * @param $query
     * @param $id
     * @param $total_loan
     * @return mixed
     */
    public function scopeLoanBalance($query, $id, $total_loan)
    {
        $totalPayed = $query->where('loan_id', $id)->sum('amount');
        return $total_loan - $totalPayed ;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function scopeTotalPayment($query, $id)
    {
        $user = User::findOrFail($id);
        return $user->payments()->sum('amount');
    }
    /**
     *get total daily payment
     * @param $query
     * @return
     */
    public function scopeDailyPayment($query)
    {
        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->sum('amount');
    }
    /**
     *get total daily approved payment
     * @param $query
     * @return
     */
    public function scopeDailyApprovedPayments($query)
    {
        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->count();
    }
    /**
     * total unapproved payments
     * @param $query
     * @return mixed
     */
    public function scopeUnapprovedPayments($query)
    {
        return $query->where('approved', null)->count();
    }

    /**
     * daily Amount by Agent
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeDailyAmountByAgent($query, $id)
    {
        return $query->where([['agent' ,'=', $id], ['approved','=', true], ['created_at', '>=', Carbon::today()]])->sum('amount');
    }

    /**
     * daily Amount count by Agent
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeDailyAmountCountByAgent($query, $id)
    {
        return $query->where([['agent' ,'=', $id], ['approved','=', true], ['created_at', '>=', Carbon::today()]])->count();
    }
}
