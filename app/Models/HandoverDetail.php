<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class HandoverDetail extends Model
{
    /**
     * @return BelongsTo<Handover, $this>
     */
    public function handover(): BelongsTo
    {
        return $this->belongsTo(Handover::class);
    }

    /**
     * @return BelongsTo<Inventory, $this>
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
