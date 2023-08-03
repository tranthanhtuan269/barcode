<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class Comment extends Model{
    
    protected $table = "comments";
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    
}