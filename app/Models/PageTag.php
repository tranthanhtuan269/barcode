<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class PageTag extends Model{
    
    protected $table = "page_tag";
    public $timestamps = false;
    
}