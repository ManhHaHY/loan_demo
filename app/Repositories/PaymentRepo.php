<?php

namespace App\Repositories;

use App\Interfaces\PaymentInterface;
use App\Models\Payment;
use App\Util\Paginate\Paginate;

class PaymentRepo implements PaymentInterface
{
    protected $payment;

    public function __construct(Payment $loan)
    {
        $this->payment = $loan;
    }

    public function getAllPayments($filter)
    {
        $payments = new Paginate($this->payment->WhereHas('loan')->filter($filter));
        return $payments;
    }

    public function createPayment($loan, $request)
    {
        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->description = $request->description;
        $payment->payment_mode = $request->payment_mode;
        if ($loan->payments()->save($payment)) {
            $payment->reference_no = 'PAYMENT/'. date('Y/m/d') . '/' . $loan->id . '/' . (1000 + $payment->id);
            $payment->save();
        }
        $afterPayment = Payment::loanBalance($loan->id, $loan->amount_to_pay);
        return [
            'data' => [
                'payment_id' => $payment->id,
                'balance' => number_format($afterPayment, 2)
            ]
        ];
    }
}
