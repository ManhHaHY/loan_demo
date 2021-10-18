<?php

namespace App\Models\Swagger;

/**
 * @OA\Schema(
 *     schema="loan",
 *     title="Loan Model",
 * )
 * @OA\Property(
 *     property="amount",
 *     type="integer",
 *     description="amount borrowed",
 *     example="1000"
 * )
 * @OA\Property(
 *     property="amount_to_pay",
 *     type="float",
 *     description="amount to pay",
 *     example="1000"
 * )
 * @OA\Property(
 *     property="interest",
 *     type="integer",
 *     description="interest",
 *     example="10"
 * )
 * @OA\Property(
 *     property="duration",
 *     type="integer",
 *     description="duration",
 *     example="15"
 * )
 * @OA\Property(
 *     property="date_applied",
 *     type="date",
 *     description="date_applied",
 *     example="2021-10-16"
 * )
 * @OA\Property(
 *     property="date_loan_ends",
 *     type="date",
 *     description="date_loan_ends",
 *     example="2021-11-30"
 * )
 *
 * @OA\Schema(
 *     schema="newloan",
 *     title="New loan",
 *     allOf={
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 description="customer id",
 *                 example="1"
 *             )
 *         ),
 *        @OA\Schema(ref="#/components/schemas/loan"),
 *     }
 * )
 * @OA\Schema(
 *     schema="updateloan",
 *     title="Update loan",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/loan"),
 *     }
 * )
 * @OA\Schema(
 *     schema="loanapprove",
 *     title="Loan approve",
 *     allOf={
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="loan_id",
 *                 type="integer",
 *                 description="Loan id",
 *                 example="1"
 *             ),
 *             @OA\Property(
 *                 property="approved",
 *                 type="boolean",
 *                 description="true | false",
 *                 example="true"
 *             ),
 *             @OA\Property(
 *                 property="approved_date",
 *                 type="date",
 *                 description="approved_date",
 *                 example="2021-10-16"
 *             ),
 *             @OA\Property(
 *                 property="payment_date",
 *                 type="date",
 *                 description="payment_date",
 *                 example="2021-11-16"
 *             )
 *         )
 *     }
 * )
 */
class Loan
{
}
