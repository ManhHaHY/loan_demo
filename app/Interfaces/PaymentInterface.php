<?php

namespace App\Interfaces;

interface PaymentInterface
{
    public function getAllPayments($filter);
    public function createPayment($loan, $request);
}
