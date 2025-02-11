<?php

namespace App\Repositories\Eloquent;

use App\Wager;
use App\Repositories\WagerRepositoryInterface;

/**
 * Class WagerRepository
 * @package App\Repository\Eloquent
 */
class WagerRepository extends BaseRepository implements WagerRepositoryInterface
{
    /**
     * WagerRepository constructor.
     *
     * @param Wager $model
     */
    public function __construct(Wager $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function listing($params)
    {
        return $this->model->offset($params['page'])->limit($params['limit'])->get();
    }

    /**
     * @param $totalWagerValue
     * @param $sellingPercentage
     * @return float|int
     */
    public function getMinSellingPrice($totalWagerValue, $sellingPercentage)
    {
        return $totalWagerValue * ($sellingPercentage / 100);
    }

    /**
     * @param $wagerId
     * @return float|int
     */
    public function getCurrentSellingPrice($wagerId)
    {
        return $this->model->find($wagerId)->current_selling_price;
    }
}
