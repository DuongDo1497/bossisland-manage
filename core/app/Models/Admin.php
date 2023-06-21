<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use Searchable, GlobalStatus;

    protected $hidden = [
        'password', 'remember_token',
    ];
}
