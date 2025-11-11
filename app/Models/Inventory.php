<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
