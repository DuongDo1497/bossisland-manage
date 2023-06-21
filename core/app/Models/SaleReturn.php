<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use Searchable, ActionTakenBy;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function details()
    {
        return $this->hasMany(SaleReturnDetails::class);
    }
}
