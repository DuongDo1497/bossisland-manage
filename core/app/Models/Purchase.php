<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;

class Purchase extends Model
{
    use Searchable, ActionTakenBy;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseReturn()
    {
        return $this->hasOne(PurchaseReturn::class);
    }
}
