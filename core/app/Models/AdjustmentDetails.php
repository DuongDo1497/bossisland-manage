<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class AdjustmentDetails extends Model
{
    use Searchable;

    public function adjustment()
    {
        return $this->belongsTo(Adjustment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
