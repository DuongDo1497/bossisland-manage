<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    use Searchable, ActionTakenBy;

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function totalPurchaseDueAmount()
    {
        return $this->purchases->sum('due_amount');
    }

    public function totalPurchaseReturnDueAmount()
    {
        return $this->purchaseReturns->sum('due_amount');
    }

    function totalPayableAmount()
    {
        $purchaseAmount = $this->purchases->where('due_amount', '>', 0)->sum('due_amount');
        $returnAmount   = $this->purchaseReturns->where('due_amount', '<', 0)->sum('due_amount');
        return $purchaseAmount + abs($returnAmount);
    }

    function totalReceivableAmount()
    {
        $purchaseAmount = $this->purchases->where('due_amount', '<', 0)->sum('due_amount');
        $returnAmount   = $this->purchaseReturns->where('due_amount', '>', 0)->sum('due_amount');
        return abs($purchaseAmount) + $returnAmount;
    }
}
