<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $quantity
 * @property-read Item|null $item
 */
final class ReceivingDetail extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
