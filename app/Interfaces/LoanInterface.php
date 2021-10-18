<?php
namespace App\Interfaces;

interface LoanInterface {
    public function getAllLoans($filter);
    public function createLoan($data);
}
