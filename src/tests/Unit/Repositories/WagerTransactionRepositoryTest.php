<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Eloquent\WagerRepository;
use App\Repositories\Eloquent\WagerTransactionRepository;
use App\Wager;
use App\WagerTransaction;
use Tests\TestCase;

class WagerTransactionRepositoryTest extends TestCase
{
    protected $wager;
    /**
     * @var WagerRepository
     */
    private $wagerRepository;
    /**
     * @var array
     */
    private $wagerTransaction;
    /**
     * @var WagerRepository
     */
    private $wagerTransactionRepository;

    public function setUp() : void
    {
        parent::setUp();
        $this->wager = [
            'id' => 1,
            'total_wager_value' => 100,
            'odds' => 10,
            'selling_percentage' => 50,
            'selling_price' => 51.0,
            'current_selling_price' => 51.0,
            'percentage_sold' => null,
            'amount_sold' => null,
            'placed_at' => now()
        ];
        $this->wagerTransaction = [
            'id' => 1,
            'wager_id' => 1,
            'buying_price' => 51.0,
            'bought_at' => now()
        ];
        $wager = new Wager();
        $this->wagerRepository = new WagerRepository($wager);
        $wagerTransaction = new WagerTransaction();
        $this->wagerTransactionRepository = new WagerTransactionRepository(
            $wagerTransaction,
            $this->wagerRepository
        );
    }

    /**
     * testProcessWagerTransaction
     *
     * @return void
     */
    public function testProcessWagerTransaction()
    {
        $wager = $this->wagerRepository->create($this->wager);
        $this->assertInstanceOf(Wager::class, $wager);
        $this->assertDatabaseHas('wagers', $this->wager);
        $params = [
            'wager_id' => 1,
            'buying_price' => 51.0
        ];
        $this->wagerTransactionRepository->processWagerTransaction($params);
        $this->assertDatabaseHas('wager_transactions', $this->wagerTransaction);
        $this->wager['percentage_sold'] =
            ($this->wager['amount_sold'] + $params['buying_price']) / $this->wager['total_wager_value'] * 100;
        $this->wager['amount_sold'] += $params['buying_price'];
        $this->assertDatabaseHas('wagers', $this->wager);
    }
}
