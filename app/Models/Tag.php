<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class Tag extends Model{
    
    protected $table = "tags";
    public $timestamps = false;
    
}