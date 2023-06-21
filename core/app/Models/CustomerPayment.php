<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use Searchable, ActionTakenBy;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function saleReturn()
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id');
    }
}
