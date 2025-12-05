<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Collection<int, LoanDetail> $details
 * @property-read Staff|null $staff
 * @property-read Warehouse|null $warehouse
 */
final class Loan extends Model
{
    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
