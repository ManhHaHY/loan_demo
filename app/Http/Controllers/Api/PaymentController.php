<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentInterface;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use App\Util\Filters\PaymentFilter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends ApiController
{

    private $payment;

    public function __construct(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @OA\Get(
     *     tags={"Payment"},
     *     path="/payment/list",
     *     summary="Get list payments",
     *     security={{
     *         "Authorization": {}
     *     }},
     *     @OA\Parameter(
     *         name="X-Requested-With",
     *         in="header",
     *         description="Request Header",
     *         @OA\Schema(
     *             type="string",
     *             default="XMLHttpRequest"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="items",
     *         in="query",
     *         description="Paginate with items.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example=10
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Array of payments",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorize."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     *
     * @param Request $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPayment(PaymentFilter $filter)
    {
        $loans = $this->payment->getAllPayments($filter);

        return $this->respondWithPagination($loans);
    }

    /**
     * @OA\Post(
     *     tags={"Payment"},
     *     path="/payment/create",
     *     summary="Create payment for Loan",
     *     description="Create payment for Loan",
     *     security={{
     *         "Authorization": {}
     *     }},
     *     @OA\Parameter(
     *         name="X-Requested-With",
     *         in="header",
     *         description="Request Header",
     *         @OA\Schema(
     *             type="string",
     *             default="XMLHttpRequest"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 ref="#/components/schemas/payment"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Not Found"
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loanPayment(Request $request)
    {
        $loan = Loan::findOrFail($request->loan_id);
        if (!$loan) {
            return $this->respondError('This loan does not exist',Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($loan->approved === null) {
            return $this->respondError('This loan has not been approved. Contact admin', Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($loan->approved === false) {
            return $this->respondError('This loan has not been declined. Contact admin', Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($loan->status === 'paid') {
            return $this->respondError('This loan has fully been paid. Contact admin',Response::HTTP_NOT_ACCEPTABLE);
        }

        //calculate loan balance
        $balance_before = Payment::loanBalance($loan->id, $loan->amount_to_pay);
        if ($request->amount > $balance_before) {
            return $this->respondError("Amount exceeds loan balance: Balance: ksh.".number_format($balance_before, 2),Response::HTTP_NOT_ACCEPTABLE);
        }

        $loanPayment = $this->payment->createPayment($loan, $request);

        return $this->respond($loanPayment, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     tags={"Payment"},
     *     path="/payment/detail/{paymentId}",
     *     summary="Get Payment Detail",
     *     security={{
     *         "Authorization": {}
     *     }},
     *     @OA\Parameter(
     *         name="X-Requested-With",
     *         in="header",
     *         description="Request Header",
     *         @OA\Schema(
     *             type="string",
     *             default="XMLHttpRequest"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="paymentId",
     *         in="path",
     *         description="Payment Id.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Array of service provider",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorize."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     *
     * @param Request $request
     * @return $this
     */
    public function paymentDetails(Request $request)
    {
        $payment = Payment::findOrFail($request->paymentId);
        if (!$payment) {
            return $this->respondNotFound('Payment Not Found');
        }
        $loan = Loan::findOrFail($payment->loan_id);
        if (!$loan) {
            return $this->respondNotFound('Loan Not Found');
        }
        $loan->balance = Loan::loanBalance($loan->id, $loan->amount_to_pay);
        $data = [
            'loan' => $loan,
            'payment' => $payment
        ];
        return $this->respond($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     tags={"Payment"},
     *     path="/payment/approve",
     *     summary="Approve payment",
     *     description="Approve payment",
     *     security={{
     *         "Authorization": {}
     *     }},
     *     @OA\Parameter(
     *         name="X-Requested-With",
     *         in="header",
     *         description="Request Header",
     *         @OA\Schema(
     *             type="string",
     *             default="XMLHttpRequest"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 ref="#/components/schemas/payment_approve"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Not Found"
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvePayment(Request $request)
    {
        $payment = Payment::findOrFail($request->id);
        if (!$payment) {
            return response()->json([
                'errors' => [
                    'approved'  => ['This payment does not exist']
                ]
            ], 406);
        }
        $payment->approved = $request->status;
        $payment->save();
        $loan = Loan::findOrFail($payment->loan_id);
        $loanBalance = Loan::loanBalance($loan->id, $loan->amount_to_pay);
        if ($loanBalance == 0) {
            $status = 'paid';
        } elseif ($loanBalance > 0) {
            $status = 'partial';
        } else {
            $status = 'unpaid';
        }
        $loan->status = $status;
        $loan->save();
        return response()->json([
            'success' => [
                'approved'  => ['This payment has been approved and updated.']
            ]
        ], 200);
    }
}
