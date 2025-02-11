<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Wager;
use App\Repositories\Eloquent\WagerRepository;

class WagerRepositoryTest extends TestCase
{
    protected $wager;
    /**
     * @var WagerRepository
     */
    private $wagerRepository;

    public function setUp() : void
    {
        parent::setUp();
        $this->wager = [
            'id' => 1,
            'total_wager_value' => 100,
            'odds' => 10,
            'selling_percentage' => 50,
            'selling_price' => 51,
            'current_selling_price' => 51,
            'percentage_sold' => null,
            'amount_sold' => null,
            'placed_at' => now()
        ];
        $wager = new Wager();
        $this->wagerRepository = new WagerRepository($wager);
    }

    /**
     * testCreate
     *
     * @return void
     */
    public function testCreate()
    {
        $wager = $this->wagerRepository->create($this->wager);
        $this->assertInstanceOf(Wager::class, $wager);
        $this->assertDatabaseHas('wagers', $this->wager);
    }

    /**
     * testFind
     *
     * @return void
     */
    public function testFind()
    {
        $this->wagerRepository->create($this->wager);
        $wager = $this->wagerRepository->find(1);
        $this->assertInstanceOf(Wager::class, $wager);
        $this->assertDatabaseHas('wagers', $this->wager);
        $this->assertEquals($wager->toArray(), $this->wager);
    }

    /**
     * testListing
     *
     * @return void
     */
    public function testListing()
    {
        $params = [
            'page' => 0,
            'limit' => 1,
        ];
        $this->wagerRepository->create($this->wager);
        $wager = $this->wagerRepository->listing($params);
        $this->assertEquals($wager->toArray(), [$this->wager]);
    }

    /**
     * testGetMinSellingPrice
     *
     * @return void
     */
    public function testGetMinSellingPrice()
    {
        $this->wagerRepository->create($this->wager);
        $minSellingPrice = $this->wagerRepository->getMinSellingPrice(
            $this->wager['total_wager_value'],
            $this->wager['selling_percentage']
        );
        $this->assertEquals(50.0, $minSellingPrice);
    }

    /**
     * testGetCurrentSellingPrice
     *
     * @return void
     */
    public function testGetCurrentSellingPrice()
    {
        $this->wagerRepository->create($this->wager);
        $currentSellingPrice = $this->wagerRepository->getCurrentSellingPrice(1);
        $this->assertEquals(51.0, $currentSellingPrice);
    }
}
