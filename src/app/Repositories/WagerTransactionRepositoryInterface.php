<?php
namespace App\Repositories;

interface WagerTransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function processWagerTransaction($params);
    public function validateWagerTransaction($params);
}
