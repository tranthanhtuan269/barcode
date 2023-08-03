<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,File,Auth;
use App\Helpers\Helper;
use App\Models\Article;
use App\Models\Page;
use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use Cache;
use App\Models\SiteConfig;


class ArticleCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $dataCate = ArticleCategory::where('language', $language)->get();
        // dd($language);
        $myfunc =  new Helper();
        $listCategoriesAction = $myfunc->listCategoriesAction($dataCate,0,'', $type = 'articlecategories', $language);
        return view("backend.articlecategory.index", compact('listCategoriesAction'));

    }

    public function create()
    {
        $dataCate = ArticleCategory::where('language', 'en')->get();
        $myfunc =  new Helper();
        $categories = $myfunc->listCategories($dataCate,0,'',0);
        Cache::flush();
        return view("backend.articlecategory.form", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreArticleCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        $item               = new ArticleCategory;
        $item->title        = $request->title;
        $item->slug         = $request->slug;
        $item->description  = $request->description;
        $item->parent_id    = $request->parent_id;
        $item->language    = 'en';
        // $item->keywords     = $request->keywords;
        $item->seo_title    = $request->seo_title;
        $item->seo_description  = $request->seo_description;
        $item->keywords    = $request->keywords;
        $item->seo_indexed      = $request->seo_indexed;

        // $item->og_type          = $request->og_type;
        // $item->og_title         = $request->og_title;
        // $item->og_description   = $request->og_description;
        // $item->og_image         = $request->og_image;
        // $item->og_image_alt     = $request->og_image_alt;
        // $item->twitter_title    = $request->twitter_title;
        // $item->twitter_description    = $request->twitter_description;
        // $item->twitter_image    = $request->twitter_image;

        $item->updated_at   = date('Y-m-d H:i:s');

        $image = $request->image;

        if ($image != '') {
            $image = explode("/filemanager/data-images/", $image);
            $item->image = $image[1];
        }

        $item->save();
        $item->cat_lang_id = $item->id;
        $item->save();
        Cache::flush();

        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $data = ArticleCategory::where('language', $language)->where('cat_lang_id', $id)->first();
        $dataCate = ArticleCategory::where('language', $language)->where('cat_lang_id', '<>', $id)->get();
        $myfunc =  new Helper();
        if ($data) {
            $arrCategoriesChild = Helper::arrCategoriesChild($data->id,'article_categories');
            $arrCategoriesChild[] = $data->id;
            $data = ArticleCategory::where('cat_lang_id', $id)->where('language', $language)->first();
            $categories = $myfunc->listCategories($dataCate,0,'',$data->parent_id);
        } else {
            $categories = $myfunc->listCategories($dataCate,0,'');
            $data = [];
        }
        Cache::flush();
        return view("backend.articlecategory.form", compact('categories', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $data = ArticleCategory::where('language', $language)->where('cat_lang_id', $id)->first();
        $slug = trim($request->slug);
        if ($data) { //UPDATE
            // $check_slug_title = ArticleCategory::where('id', '<>', $data->id)->where('language', $language)->where('slug', $slug)->count();
            $rules = [
                'title'          => 'required|max:255|unique:article_categories,title,'.$data->id,
                'slug'          => 'required|max:255|unique:article_categories,slug,'.$data->id,
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]);
            } else {
                $item               = ArticleCategory::find($data->id);
                $item->title        = $request->title;
                // $item->slug         = \Str::slug($request->title, '-');
                $item->slug         = $request->slug;
                $item->description  = $request->description;
                $item->parent_id    = $request->parent_id;
                // $item->keywords     = $request->keywords;
                $item->seo_title        = $request->seo_title;
                $item->keywords    = $request->keywords;
                $item->seo_description  = $request->seo_description;
                $item->seo_indexed      = $request->seo_indexed;

                // $item->og_type          = $request->og_type;
                // $item->og_title         = $request->og_title;
                // $item->og_description   = $request->og_description;
                // $item->og_image         = $request->og_image;
                // $item->og_image_alt     = $request->og_image_alt;
                // $item->twitter_title    = $request->twitter_title;
                // $item->twitter_description    = $request->twitter_description;
                // $item->twitter_image    = $request->twitter_image;

                $item->updated_at   = date('Y-m-d H:i:s');

                $image = $request->image;

                if ($image != '') {
                    $image = explode("/filemanager/data-images/", $image);
                    $item->image = $image[1];
                }
            }
        } else {
            $rules = [
                'title'          => 'required|max:255|unique:article_categories,title',
                'slug'          => 'required|max:255|unique:article_categories,slug',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]);
            } else {
                $item               = new ArticleCategory;
                $item->title        = $request->title;
                $item->slug         = $request->slug;
                $item->description  = $request->description;
                $item->parent_id    = $request->parent_id;
                $item->language    = $request->language;
                // $item->keywords     = $request->keywords;
                $item->seo_title    = $request->seo_title;
                $item->seo_description  = $request->seo_description;
                $item->keywords    = $request->keywords;
                $item->seo_indexed      = $request->seo_indexed;

                // $item->og_type          = $request->og_type;
                // $item->og_title         = $request->og_title;
                // $item->og_description   = $request->og_description;
                // $item->og_image         = $request->og_image;
                // $item->og_image_alt     = $request->og_image_alt;
                // $item->twitter_title    = $request->twitter_title;
                // $item->twitter_description    = $request->twitter_description;
                // $item->twitter_image    = $request->twitter_image;

                $item->updated_at   = date('Y-m-d H:i:s');
                $image = $request->image;
                if ($image != '') {
                    $image = explode("/filemanager/data-images/", $image);
                    $item->image = $image[1];
                }
                $item->cat_lang_id = ArticleCategory::where('language', 'en')->where('cat_lang_id', $id)->value('cat_lang_id');
            }
        }
        $item->save();
        Cache::flush();
        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function destroy($id)
    {
        $arr_id = ArticleCategory::where('cat_lang_id', $id)->pluck('id');
        if (Article::whereIn('cat_id', $arr_id)->count() > 0) {
            return response()->json(['message' => 'Danh mục đang chứa bài viết nên không thể xóa được!', 'status' => 404]);
        }
        if (count($arr_id) > 0) {
            ArticleCategory::whereIn('parent_id', $arr_id)->update(['parent_id' => 0]);
        }
        ArticleCategory::where('cat_lang_id', $id)->delete();
        Cache::flush();
        return response()->json(['message' => 'Xóa thông tin thành công!', 'status' => 200]);
    }

    public function showCatArticles($slug)
    {
        $data = Article::leftJoin('article_tag', 'article_tag.article_id', '=', 'articles.id')
        ->leftJoin('tags', 'tags.id', '=', 'article_tag.tag_id')
        ->leftJoin('article_categories', 'article_categories.id', '=', 'articles.cat_id')
        ->selectRaw('article_categories.title as cat_title, article_categories.slug as cat_slug, GROUP_CONCAT(tags.name) as list_tags, GROUP_CONCAT(tags.slug) as list_slug_tags, articles.*')
        ->where('articles.slug', $slug)
        ->where('articles.status', 1)
        ->groupBy('articles.id')
        ->first();

        if ($data) {
            $totalComments = $data->comments()->count();

            if(!empty($data->relative_acticles) && $data->relative_acticles != "null"){
                $relateds = Article::select('title', 'slug','image','id','count_view', 'rate')->whereIn('id',json_decode($data->relative_acticles))->orderBy('count_view','desc')->get();
            }else{
                $relateds = Article::select('title', 'slug', 'image', 'id', 'count_view', 'rate')->where('cat_id',$data->cat_id)->where('id','<>',$data->id)->orderBy('count_view','desc')->take(3)->get();
            }

            Helper::countVisitedBlog($data); 

            $keywords_not_good = SiteConfig::where('key', 'keywords_not_good')->value('value');
            return view('layouts_frontend.article.detail', compact('data','totalComments','relateds', 'keywords_not_good'));
        }else{
            $info_cat = ArticleCategory::where('slug',$slug)->first();
            if($info_cat){
                $cat_id = $info_cat->id;
                $id_child = Helper::arrCategoriesChild_v2($cat_id, 'article_categories');
                $arr_cat_id = Helper::array_keys_multi($id_child);
                $arr_cat_id[] = (int)$cat_id;
                $mostViewArticles = \Cache::rememberForever('most_view_article-'. $slug, function ()  use ($arr_cat_id) {
                    return Article::select('title', 'slug', 'post_public_time', 'image', 'id','count_view','rate')->where('status', 1)->whereIn('cat_id', $arr_cat_id)->where('post_public_time', '<=', date('Y-m-d H:i:s'))->orderBy('count_view', 'desc')->take(12)->get();
                });
                $data = Article::select('title', 'slug', 'post_public_time', 'image', 'description', 'id','count_view','rate')->where('status', 1)->whereIn('cat_id', $arr_cat_id)->where('post_public_time', '<=', date('Y-m-d H:i:s'))->orderBy('post_public_time', 'desc')->paginate(10);
                return view('layouts_frontend.article.list', compact('data', 'info_cat','mostViewArticles'));
            }else{
                $data =  Page::where('slug',$slug)->first();
                if($data) {
                    if($data->type == 1) {
                        return view('layouts_frontend.pages.index',['data'=>$data]);
                    }else {
                        return redirect(route('index'), 301);
                    }
                }else{
                    return redirect(route('index'), 301);
                }
            }
        }

        
    }

    public function infoCatArticleByLang(Request $request){
        return Helper::callProcessSelect(ArticleCategory::where('language', $request->language_id)->get(), 0, '', 0);
    }
	
}
