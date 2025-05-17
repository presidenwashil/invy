<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function details()
    {
        return $this->hasMany(ReceivingDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
