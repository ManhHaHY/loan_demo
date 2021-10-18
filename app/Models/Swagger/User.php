<?php

namespace App\Models\Swagger;

/**
 * @OA\Schema(
 *     schema="users",
 *     title="User Model"
 * )
 * @OA\Property(
 *     property="first_name",
 *     type="string",
 *     description="First Name",
 *     example="UserRepo"
 * )
 * @OA\Property(
 *     property="last_name",
 *     type="string",
 *     description="Last Name",
 *     example="A"
 * )
 * @OA\Property(
 *     property="email",
 *     type="string",
 *     description="Email address",
 *     example="user1@email.com"
 * )
 * @OA\Property(
 *     property="password",
 *     type="string",
 *     description="password",
 *     example="123321"
 * )
 * @OA\Property(
 *     property="personal_code",
 *     type="string",
 *     description="0123456789",
 *     example="0123456789"
 * )
 * @OA\Property(
 *     property="phone",
 *     type="string",
 *     description="0912345678",
 *     example="0912345678"
 * )
 */
class User
{
}
