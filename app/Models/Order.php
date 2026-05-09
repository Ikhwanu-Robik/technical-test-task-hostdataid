<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'reference_id',
        'game_code',
        'amount',
        'status',
    ];

    public static function createOrderId()
    {
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $index = $lastOrder ? $lastOrder->id : 1;

        $datePart = Carbon::now()->format('Ymd');

        $indexPart = Str::padLeft($index, 6, '0');

        return "ORD-{$datePart}-{$indexPart}";
    }
}
