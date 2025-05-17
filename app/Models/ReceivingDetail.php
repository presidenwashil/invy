<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivingDetail extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
