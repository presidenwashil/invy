<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandoverDetail extends Model
{
    public function handover()
    {
        return $this->belongsTo(Handover::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
