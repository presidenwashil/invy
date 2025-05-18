<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
