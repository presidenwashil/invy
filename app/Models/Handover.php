<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Handover extends Model
{
    use SoftDeletes;

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function details()
    {
        return $this->hasMany(HandoverDetail::class, 'handover_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
