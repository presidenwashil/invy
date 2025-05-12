<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    use SoftDeletes;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_supplier');
    }
}
