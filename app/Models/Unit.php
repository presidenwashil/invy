<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Unit extends Model
{
    use SoftDeletes;

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
