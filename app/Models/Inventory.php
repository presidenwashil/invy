<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status
 * @property-read Item|null $item
 * @property-read Staff|null $staff
 * @property-read Warehouse|null $warehouse
 */
final class Inventory extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
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
