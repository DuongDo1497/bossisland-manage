<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use Searchable, ActionTakenBy;

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function transferDetails()
    {
        return $this->hasMany(TransferDetails::class);
    }
}
