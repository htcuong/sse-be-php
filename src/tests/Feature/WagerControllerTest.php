<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class WagerControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * testPlaceWithValidParam
     * @dataProvider placeWithValidParamDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testPlaceWithValidParam($params, $statusCode, $expected)
    {
        $this->json('POST', 'api/wagers', $params)
            ->assertStatus($statusCode)
            ->assertJsonStructure($expected);
    }

    /**
     * placeWithValidParamDataProvider
     *
     * @return array
     */
    public function placeWithValidParamDataProvider()
    {
        return [
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 10,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 201,
                'expected' => [
                    'id',
                    "total_wager_value",
                    "odds",
                    "selling_percentage",
                    "selling_price",
                    "current_selling_price",
                    "percentage_sold",
                    "amount_sold",
                    "placed_at"
                ]
            ]
        ];
    }

    /**
     * testPlaceWithInvalidParam
     * @dataProvider placeWithInvalidParamDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testPlaceWithInvalidParam($params, $statusCode, $expected)
    {
        $this->json('POST', 'api/wagers', $params)
            ->assertStatus($statusCode)
            ->assertJson($expected);
    }

    /**
     * placeWithInvalidParamDataProvider
     *
     * @return array
     */
    public function placeWithInvalidParamDataProvider()
    {
        return [
            // total_wager_value
            [
                'params' => [
                    'total_wager_value' => 1.1,
                    'odds' => 10,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The total wager value must be an integer.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 0,
                    'odds' => 10,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The total wager value must be greater than 0.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => -1,
                    'odds' => 10,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The total wager value must be greater than 0.',
                ]
            ],
            // odds
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 1.1,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The odds must be an integer.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 0,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The odds must be greater than 0.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => -1,
                    'selling_percentage' => 80,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The odds must be greater than 0.',
                ]
            ],
            // selling_percentage
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 9,
                    'selling_percentage' => 1.1,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The selling percentage must be an integer.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 9,
                    'selling_percentage' => 0,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The selling percentage must be greater than 0.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 9,
                    'selling_percentage' => 101,
                    'selling_price' => 81,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The selling percentage may not be greater than 100.',
                ]
            ],
            // selling_price
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 9,
                    'selling_percentage' => 50,
                    'selling_price' => 4,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The selling price must be greater than 5.',
                ]
            ],
            [
                'params' => [
                    'total_wager_value' => 10,
                    'odds' => 9,
                    'selling_percentage' => 50,
                    'selling_price' => 5,
                ],
                'statusCode' => 400,
                'expected' => [
                    'error' => 'The selling price must be greater than 5.',
                ]
            ],
            [
                'params' => [],
                'statusCode' => 500,
                'expected' => []
            ],
        ];
    }

    /**
     * testListingWithInvalidParams
     * @dataProvider listingWithInvalidParamsDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testListingWithInvalidParams($params, $statusCode, $expected)
    {
        $this->json('GET', 'api/wagers' . $params['queryString'])
            ->assertStatus($statusCode)
            ->assertJson($expected);
    }

    /**
     * listingWithInvalidParamsDataProvider
     *
     * @return array
     */
    public function listingWithInvalidParamsDataProvider()
    {
        return [
            [
                'params' => [
                    'queryString' => ''
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The page field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?page=0'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The limit field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?pages=0&limit=1'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The page field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?page=&limit=1'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The page field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?page=text&limit=1'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The page must be an integer.']
            ],
            [
                'params' => [
                    'queryString' => '?page=0&limits=1'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The limit field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?page=0&limit='
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The limit field is required.']
            ],
            [
                'params' => [
                    'queryString' => '?page=0&limit=text'
                ],
                'statusCode' => 400,
                'expected' => ['error'=>'The limit must be an integer.']
            ]
        ];
    }

    /**
     * testListingWithValidParams
     * @dataProvider listingWithValidParamsDataProvider
     *
     * @param $params
     * @param $statusCode
     * @param $expected
     * @return void
     */
    public function testListingWithValidParams($params, $statusCode, $expected)
    {
        $this->json('GET', 'api/wagers' . $params['queryString'])
            ->assertStatus($statusCode)
            ->assertJson($expected);
    }

    /**
     * listingWithValidParamsDataProvider
     *
     * @return array
     */
    public function listingWithValidParamsDataProvider()
    {
        return [
            [
                'params' => [
                    'queryString' => '?page=0&limit=1'
                ],
                'statusCode' => 200,
                'expected' => []
            ]
        ];
    }
}
