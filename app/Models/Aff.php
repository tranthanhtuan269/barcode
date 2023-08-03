<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aff extends Model
{
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}