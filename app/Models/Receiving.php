<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
