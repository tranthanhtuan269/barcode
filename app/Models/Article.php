<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Helpers\Helper;
use App\Config;
class Article extends Model{
    
    protected $table = "articles";

    public static function getDataForDatatable($request){
        $keyword = trim($request['keyword']);
        $cat_id = $request['cat_id'];
        $language = ($request->language != '') ? $request->language : 'en';
        $query =  \DB::table('articles')
                    // ->leftJoin('article_categories', 'article_categories.id', '=', 'articles.cat_id')
                    ->where('articles.language', $language)
                    ->selectRaw('articles.id as id,articles.title,articles.image,articles.created_at,articles.updated_at,articles.cat_id, articles.article_lang_id');
                    // ->selectRaw('articles.id as id,articles.title,articles.image,articles.created_at,articles.updated_at,article_categories.title as cat_name,articles.cat_id, articles.article_lang_id');

        if( !empty($keyword) ) {
            $query->where('articles.title', 'like', '%' . $keyword . '%');
        }

        if (!empty($cat_id)) {
            $query->where('articles.cat_id', $cat_id);
        }

        if (!empty($cat_id)) {
            $id_child = Helper::arrCategoriesChild_v2($cat_id, 'article_categories');
            $arr_cat_id = Helper::array_keys_multi($id_child);
            $arr_cat_id[] = $cat_id;
            $query->whereIn('articles.cat_id', $arr_cat_id);
        }

        return $query;
    }

    public static function delMulti($id_list){
        $list = explode(",",$id_list);
        $item = Article::whereIn('article_lang_id', $list);
        return ($item->delete() > 0);
    }

    public function relateds()
    {
        return $this->belongsTo(Article::class, 'cat_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsRoot(){
        return $this->hasMany(Comment::class)->where('parent_id', 0)->orderBy('id','desc');   
    }
    
}