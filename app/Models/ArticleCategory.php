<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class ArticleCategory extends Model{
    
    protected $table = "article_categories";
    public static function getAll() {
        return ArticleCategory::get(['id', 'title', 'parent_id', 'slug']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
}