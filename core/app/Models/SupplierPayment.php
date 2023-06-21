<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    use Searchable, ActionTakenBy;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class, 'purchase_return_id');
    }
}
