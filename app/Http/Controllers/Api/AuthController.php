<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateUser;
use App\Http\Requests\AuthRequest;
use App\Interfaces\UserInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiController
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Tag(
     *     name="Auth",
     *     description="Api using for Auth"
     * )
     *
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/login",
     *     summary="Login user to get token",
     *     description="`user@example.com / 123456`",
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
     *                 @OA\Property(
     *                     property="email",
     *                     type="email",
     *                     example="user@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="123456"
     *                 ),
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
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return $this->respondFailedLogin();
            }

            try {
                $user = $request->user();
                $tokenResult = $user->createToken((string)$request->user()->personal_code);
                $token = $tokenResult->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            } catch (\Exception $e) {
                return $this->respondError($e->getMessage(),Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Tag(
     *     name="Auth",
     *     description="Api using for Auth"
     * )
     *
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/signup",
     *     summary="Create new user",
     *     description="Create new user account for login",
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
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/users"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/users"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Not Found"
     *     )
     * )
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(CreateUser $request)
    {
        try {
            try {
                $user = $this->user->createUser($request->all());
                return $this->respond($user, Response::HTTP_OK);
            } catch (\Exception $e) {
                return $this->respondError($e->getMessage(),Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/logout",
     *     summary="Logout user",
     *     description="Logout user",
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
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->respondNoContent();
    }
}
