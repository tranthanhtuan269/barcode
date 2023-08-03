<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function aff()
    {
        return $this->belongsTo(Aff::class, 'aff_id');
    }
}