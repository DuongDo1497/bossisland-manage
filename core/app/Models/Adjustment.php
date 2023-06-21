<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use Searchable, ActionTakenBy;

    public function adjustmentDetails()
    {
        return $this->hasMany(AdjustmentDetails::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
