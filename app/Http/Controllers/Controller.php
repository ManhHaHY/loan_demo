<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Demo Loans System", version="0.1")
 *
 * @OA\Server(
 *      url="/api/{version}",
 *      description="Api for loans system",
 *      @OA\ServerVariable(
 *          serverVariable="version",
 *          enum={"v1"},
 *          default="v1"
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     description="Header value: `Bearer {access_token}`",
 *     in="header",
 *     securityScheme="Authorization",
 *     name="Authorization"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
