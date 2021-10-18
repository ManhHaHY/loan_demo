<?php

namespace App\Models\Swagger;

/**
 * @OA\Schema(
 *     schema="payment",
 *     title="Payment Model",
 * )
 * @OA\Property(
 *     property="loan_id",
 *     type="integer",
 *     description="loan_id",
 *     example="1"
 * )
 * @OA\Property(
 *     property="amount",
 *     type="float",
 *     description="amount",
 *     example="10.00"
 * )
 * @OA\Property(
 *     property="payment_mode",
 *     type="string",
 *     description="payment_mode",
 *     example="paid"
 * )
 * @OA\Property(
 *     property="description",
 *     type="string",
 *     description="description",
 *     example="description"
 * )
 *
 * @OA\Schema(
 *     schema="payment_approve",
 *     title="Payment approve Model",
 *     allOf={
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 description="payment id",
 *                 example="1"
 *             ),
 *             @OA\Property(
 *                 property="loan_id",
 *                 type="integer",
 *                 description="loan id",
 *                 example="1"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 description="status",
 *                 enum={0,1},
 *                 default=1
 *             )
 *         )
 *     }
 * )
 */
class Payment
{
}
