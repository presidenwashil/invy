<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Loan|null $loan
 * @property-read Inventory|null $inventory
 */
final class LoanDetail extends Model
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
