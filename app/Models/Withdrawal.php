<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $staff_id
 * @property-read Collection<int, WithdrawalDetail> $details
 * @property-read Staff|null $staff
 */
final class Withdrawal extends Model
{
    /**
     * @return HasMany<WithdrawalDetail, $this>
     */
    public function details(): HasMany
    {
        return $this->hasMany(WithdrawalDetail::class);
    }

    /**
     * @return BelongsTo<Staff, $this>
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
