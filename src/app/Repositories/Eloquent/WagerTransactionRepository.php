<?php

namespace App\Repositories\Eloquent;

use App\Repositories\WagerTransactionRepositoryInterface;
use App\WagerTransaction;
use Illuminate\Support\Facades\DB;

/**
 * Class WagerTransactionRepository
 * @package App\Repositories\Eloquent
 */
class WagerTransactionRepository extends BaseRepository implements WagerTransactionRepositoryInterface
{
    /**
     * @var WagerRepository
     */
    protected $wagerRepository;

    /**
     * WagerTransactionRepository constructor.
     *
     * @param WagerTransaction $wagerTransaction
     * @param WagerRepository $wagerRepository
     */
    public function __construct(WagerTransaction $wagerTransaction, WagerRepository $wagerRepository)
    {
        parent::__construct($wagerTransaction);
        $this->wagerRepository = $wagerRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function processWagerTransaction($params)
    {
        if (!$this->validateWagerTransaction($params)) {
            return ['error' => 'Cannot buy this wager'];
        }
        DB::beginTransaction();
        try {
            $newWagerTransId = $this->model->create($params)->id;
            if ($newWagerTransId) {
                $wagerInfo = $this->wagerRepository->find($params['wager_id']);
                $wagerInfo->percentage_sold =
                    ($wagerInfo->amount_sold + $params['buying_price']) / $wagerInfo->total_wager_value * 100;
                $wagerInfo->current_selling_price = $params['buying_price'];
                $wagerInfo->amount_sold += $params['buying_price'];
                $wagerInfo->save();
            }
            DB::commit();
            return ['newWagerTransId' => $newWagerTransId];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateWagerTransaction($params)
    {
        $currentSellingPrice = $this->wagerRepository->getCurrentSellingPrice($params['wager_id']);
        if((float)$currentSellingPrice > 0 && (float)$params['buying_price'] <= (float)$currentSellingPrice) {
            return true;
        }

        return false;
    }
}
