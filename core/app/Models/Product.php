<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Searchable, ActionTakenBy;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function productStock()
    {
        return $this->hasMany(ProductStock::class);
    }
    public function stock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function purchaseReturnDetails()
    {
        return $this->hasMany(PurchaseReturnDetails::class);
    }

    public function saleReturnDetails()
    {
        return $this->hasMany(SaleReturnDetails::class);
    }

    public function totalPurchase()
    {
        return $this->purchaseDetails()->sum('quantity');
    }

    public function totalSale()
    {
        return $this->saleDetails->sum('quantity');
    }

    public function totalInStock()
    {
        return $this->productStock->sum('quantity');
    }
}
