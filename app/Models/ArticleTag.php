<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class ArticleTag extends Model{
    
    protected $table = "article_tag";
    public $timestamps = false;
    
}