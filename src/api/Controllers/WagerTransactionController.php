<?php

namespace Api\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\WagerRepositoryInterface;
use App\Repositories\WagerTransactionRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

/**
 * Class WagerTransactionController
 * @package Api\Controllers
 */
class WagerTransactionController extends Controller
{
    /**
     * @var WagerTransactionRepositoryInterface
     */
    private $wagerTransactionRepository;

    /**
     * @var WagerRepositoryInterface
     */
    private $wagerRepository;

    /**
     * WagerTransactionController constructor.
     * @param WagerTransactionRepositoryInterface $wagerTransactionRepository
     * @param WagerRepositoryInterface $wagerRepository
     */
    public function __construct(
        WagerTransactionRepositoryInterface $wagerTransactionRepository,
        WagerRepositoryInterface $wagerRepository
    ) {
        $this->wagerTransactionRepository = $wagerTransactionRepository;
        $this->wagerRepository = $wagerRepository;
    }

    /**
     * @param Request $request
     * @param $wagerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, $wagerId)
    {
        $params = $request->all();
        $params['wager_id'] = $wagerId;
        $validator = Validator::make($params, $this->rules());
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $result = $this->wagerTransactionRepository->processWagerTransaction($params);
        if (empty($result['error'])) {
            return response()->json(
                $this->wagerTransactionRepository->find($result['newWagerTransId'])->toArray(),
                201
            );

        }

        return response()->json(['error' => 'Cannot buy this wager.'], 400);
    }

    /**
     * @return array
     */
    private function rules()
    {
        return [
            'wager_id' => 'required|integer|exists:wagers,id',
            'buying_price' => 'required|numeric|gt:0'
        ];
    }
}
