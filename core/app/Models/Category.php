<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Searchable;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
