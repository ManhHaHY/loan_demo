<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\LoanInterface;
use App\Models\User;
use App\Models\Loan;
use App\Util\Paginate\Paginate;
use App\Util\Filters\LoanFilter;
use App\Http\Requests\Api\CreateLoan;
use App\Http\Requests\Api\UpdateLoan;
use App\Util\Transformers\LoanTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class LoansController extends ApiController
{
    protected $loan;
    protected $transformer;

    /**
     * LoansController constructor.
     *
     * @param LoanTransformer $transformer
     */
    public function __construct(LoanTransformer $transformer, LoanInterface $loan)
    {
        $this->loan = $loan;
        $this->transformer = $transformer;
    }

    /**
     * Get all the loans.
     *
     * @OA\Tag(
     *     name="Loan",
     *     description="Api using for Loan"
     * )
     *
     * @OA\Post(
     *     tags={"Loan"},
     *     path="/loans/search",
     *     summary="Get all loans",
     *     description="Get all loans to list.",
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
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="minPrice",
     *                     type="integer",
     *                     description="minPrice",
     *                     example="100"
     *                 ),
     *                 @OA\Property(
     *                     property="maxPrice",
     *                     type="integer",
     *                     description="maxPrice",
     *                     example="10000"
     *                 ),
     *                 @OA\Property(
     *                     property="page",
     *                     type="integer",
     *                     description="page",
     *                     example="0"
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
     * @param LoanFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LoanFilter $filter)
    {
        $loans = $this->loan->getAllLoans($filter);

        return $this->respondWithPagination($loans);
    }


    /**
     * Create a new LoanRepo and return the LoanRepo if successful.
     *
     * @OA\Post(
     *     tags={"Loan"},
     *     path="/loans",
     *     summary="Create new loan",
     *     description="Create new loan",
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
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/newloan"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/loan"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Not Found"
     *     )
     * )
     *
     * @param CreateLoan $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLoan $request)
    {
        $data = $request->all();
        $payPerWeek = $request->amount / ($request->duration / 7);
        $data['pay_per_week'] = $payPerWeek;
        $loan = $this->loan->createLoan($data);

        return $this->respondWithTransformer($loan);
    }

    /**
     * Get loan detail given by its id.
     *
     * @OA\Get(
     *     tags={"Loan"},
     *     path="/loans/detail/{loanId}",
     *     summary="Get loan detail",
     *     description="Get loan detail given by its id",
     *     security={{
     *         "Authorization": {}
     *     }},
     *     @OA\Parameter(
     *         description="ID of loan need get info.",
     *         in="path",
     *         name="loanId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="X-Requested-With",
     *         in="header",
     *         description="Request Header",
     *         @OA\Schema(
     *             type="string",
     *             default="XMLHttpRequest"
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
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loan $loan)
    {
        return $this->respondWithTransformer($loan);
    }

    /**
     * Update the $loan given by its id and return the $loan if successful.
     *
     * @OA\Put(
     *     tags={"Loan"},
     *     path="/loans/update/{loanId}",
     *     summary="Update loan by id.",
     *     description="Update loan by id.",
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
     *         description="ID of loan need update.",
     *         in="path",
     *         name="loanId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/updateloan"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/loan"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Not Found"
     *     )
     * )
     *
     * @param UpdateLoan $request
     * @param User $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLoan $request, Loan $loan)
    {
        $inputs = $request->all();
        $payPerWeek = $request->amount / ($request->duration / 7);
        $inputs['pay_per_week'] = $payPerWeek;
        $loan->update($inputs);

        return $this->respondWithTransformer($loan);
    }

    /**
     * @OA\Patch(
     *     tags={"Loan"},
     *     path="/loans/approve",
     *     summary="Approve loan",
     *     description="Approve loan",
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
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/loanapprove"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/loanapprove"
     *             )
     *         )
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
    public function approveLoan(Request $request)
    {
        $loan = Loan::find($request->loan_id);
        if (!$loan) {
            return $this->respondNotFound('This loan does not exist');
        }
        $loan->approved = $request->approved;
        $loan->approved_by = $request->user()->id;
        $loan->approved_date = Carbon::now();
        $loan->payment_date = Carbon::today()->addMonths($loan->duration);
        $loan->save();
        return  $this->respond([
            'success' => [
                'approved'  => ['Loan has been approved.']
            ]
        ],Response::HTTP_OK);
    }

}
