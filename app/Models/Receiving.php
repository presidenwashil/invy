<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $staff_id
 * @property-read Collection<int, ReceivingDetail> $details
 * @property-read Staff|null $staff
 */
final class Receiving extends Model
{
    public function details()
    {
        return $this->hasMany(ReceivingDetail::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
