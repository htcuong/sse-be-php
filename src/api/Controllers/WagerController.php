<?php

namespace Api\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\WagerRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

/**
 * Class WagerController
 * @package Api\Controllers
 */
class WagerController extends Controller
{
    /**
     * @var WagerRepositoryInterface
     */
    private $wagerRepository;

    /**
     * WagerController constructor.
     * @param WagerRepositoryInterface $wagerRepository
     */
    public function __construct(WagerRepositoryInterface $wagerRepository)
    {
        $this->wagerRepository = $wagerRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function place(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, $this->getRules($request->route()->getName(), $params));
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $newWager = $this->wagerRepository->create($this->prepareData($params));

        return response()->json($this->wagerRepository->find($newWager->id)->toArray(), 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listing(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, $this->getRules($request->route()->getName(), $params));
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        return response()->json($this->wagerRepository->listing($params)->toArray(), 200);
    }

    /**
     * @param $routeName
     * @param $params
     * @return array
     */
    private function getRules($routeName, $params)
    {
        switch ($routeName) {
            case 'place_wager':
                return [
                    'total_wager_value' => 'required|integer|gt:0',
                    'odds' => 'required|integer|gt:0',
                    'selling_percentage' => 'required|integer|gt:0|max:100',
                    'selling_price' => 'required|numeric|gt:'
                        . $this->wagerRepository->getMinSellingPrice(
                            $params['total_wager_value'], $params['selling_percentage']
                        )
                ];
            default:
                return [
                    'page' => 'required|integer',
                    'limit' => 'required|integer'
                ];
        }
    }

    /**
     * @param $params
     * @return array
     */
    private function prepareData($params)
    {
        $params['current_selling_price'] = $params['selling_price'];
        return $params;
    }
}
