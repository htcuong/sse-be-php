<?php
namespace App\Repositories;

interface WagerRepositoryInterface
{
    public function listing($params);
    public function getMinSellingPrice($totalWagerValue, $sellingPercentage);
    public function getCurrentSellingPrice($wagerId);
}
