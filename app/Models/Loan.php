<?php

namespace App\Models;

use App\Util\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{

    use Filterable;

    protected $tablename = "loans";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id',
        'amount',
        'amount_to_pay',
        'pay_per_week',
        'interest',
        'duration',
        'date_applied',
        'date_loan_ends',
        'status',
        'approved',
        'approved_date',
        'payment_date',
        'approved_by',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user'
    ];

    /**
     * Get the key name for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Get all the tags that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * total customer loan borrowed
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeTotalLoan($query, $id)
    {
        return $query->where([['user_id','=', $id],['approved', '=', true]])
            ->sum('amount_borrowed');
    }

    /**
     * total customer loan interest
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeTotalInterest($query, $id)
    {
        $totalBorrowed = $query->where([['user_id','=', $id],['approved', '=', true]])->sum('amount_borrowed');
        $totalToPay = $query->where([['user_id','=', $id],['approved', '=', true]])->sum('amount_to_pay');
        return $totalToPay - $totalBorrowed;
    }
    public function scopeLoanBalance($query, $id, $total_loan)
    {
        $totalPayed = DB::table('payments')->where([['loan_id','=', $id],['approved', '=', true]])->sum('amount');
        return $total_loan - $totalPayed ;
    }

    /**
     * get total daily loan
     *
     * @param $query
     * @return mixed
     */
    public function scopeDailyLoan($query)
    {
        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->sum('amount_borrowed');
    }

    /**
     * get total daily approved loan
     *
     * @param $query
     * @return mixed
     */
    public function scopeDailyApprovedLoans($query)
    {
        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->count();
    }
    /**
     * total un approved loans
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnapprovedLoans($query)
    {
        return $query->where('approved', null)->count();
    }

}
