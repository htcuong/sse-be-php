<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagerTransaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'wager_id',
        'buying_price',
        'bought_at'
    ];
}
