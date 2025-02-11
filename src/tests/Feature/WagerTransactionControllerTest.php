<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Wager;

class WagerTransactionControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * testBuyWithValidParam
     * @dataProvider buyWithValidParamDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testBuyWithValidParam($params, $statusCode, $expected)
    {
        $wager = factory(Wager::class)->create();
        $this->json('POST', 'api/buy/' . $params['wager_id'], $params['buying_price'])
            ->assertStatus($statusCode)
            ->assertJsonStructure($expected);
    }

    /**
     * buyWithValidParamDataProvider
     *
     * @return array
     */
    public function buyWithValidParamDataProvider()
    {
        return [
            [
                'params' => [
                    'wager_id' => 1,
                    'buying_price' => ['buying_price' => 10]
                ],
                'statusCode' => 201,
                'expected' => ['wager_id', 'buying_price', 'bought_at']
            ],
            [
                'params' => [
                    'wager_id' => 1,
                    'buying_price' => ['buying_price' => 51]
                ],
                'statusCode' => 201,
                'expected' => ['wager_id', 'buying_price', 'bought_at']
            ]
        ];
    }

    /**
     * testBuyWithInvalidParam
     * @dataProvider buyWithInvalidParamDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testBuyWithInvalidParam($params, $statusCode, $expected)
    {
        $wager = factory(Wager::class)->create();
        $this->json('POST', 'api/buy/' . $params['wager_id'], $params['buying_price'])
            ->assertStatus($statusCode)
            ->assertJson($expected);
    }

    /**
     * buyWithInvalidParamDataProvider
     *
     * @return array
     */
    public function buyWithInvalidParamDataProvider()
    {
        return [
            [
                'params' => [
                    'wager_id' => 'text',
                    'buying_price' => ['buying_price' => 51]
                ],
                'statusCode' => 400,
                'expected' => ['error' => 'The wager id must be an integer.']
            ],
            [
                'params' => [
                    'wager_id' => 1,
                    'buying_price' => ['buying_price' => -1]
                ],
                'statusCode' => 400,
                'expected' => ['error' => 'The buying price must be greater than 0.']
            ],
            [
                'params' => [
                    'wager_id' => 2,
                    'buying_price' => ['buying_price' => 51]
                ],
                'statusCode' => 400,
                'expected' => ['error' => 'The selected wager id is invalid.']
            ],
            [
                'params' => [
                    'wager_id' => 1,
                    'buying_price' => ['buying_price' => 52]
                ],
                'statusCode' => 400,
                'expected' => ['error' => 'Cannot buy this wager.']
            ]
        ];
    }
}
