<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ReceivingDetail extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
