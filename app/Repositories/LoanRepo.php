<?php
namespace App\Repositories;

use App\Interfaces\LoanInterface;
use App\Models\Loan;
use App\Util\Paginate\Paginate;

class LoanRepo implements LoanInterface {
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function getAllLoans($filter)
    {
        $loans = new Paginate($this->loan->WhereHas('user')->filter($filter));
        return $loans;
    }

    public function createLoan($data)
    {
        return $this->loan->create($data);
    }
}
