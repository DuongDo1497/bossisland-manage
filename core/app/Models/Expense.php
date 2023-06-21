<?php

namespace App\Models;

use App\Traits\ActionTakenBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use Searchable, ActionTakenBy;

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
