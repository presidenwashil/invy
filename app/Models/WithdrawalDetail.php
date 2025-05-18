<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalDetail extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
