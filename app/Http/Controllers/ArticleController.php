<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,File,Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Helpers\Helper;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\ArticleTag;
use App\Models\SiteConfig;
use App\EmailSubscribenNews;
use Illuminate\Support\Str;
use Cache;


class ArticleController extends Controller
{
    //update seo -21/11/2022
    public function rateAjax(Request $request) {
        $data = Article::where('id', $request->id)->first();
        $rate = $data->rate;
        $vote = $data->number_rate;
        if($request->rate_before == 0){
	        if($vote == 0) {
	            $vote = 1;
	            $rate = round(($request->rate),1);
	        }else {
	            $rate = round(($rate*$vote + $request->rate)/($vote+1),1);
	            $vote +=1;
	        }
        }else {
        	$rate = round((($rate*$vote - $request->rate_before+ $request->rate)/$vote),1);
        }
        $data->rate = $rate;
        $data->number_rate = $vote;
        $rate_new = number_format($rate,1);
        $data->save();
        return response()->json(['status' => 200, "message"=>"Thank you!","rate"=>$rate_new,"vote"=>$vote]);
    }

    public function commentAjax(Request $request){
		$author = $request->author;
		$content =  $request->comment;
		$content = Helper::mynl2br($content);
		$content = preg_replace('"\b(https?://\S+)"', '<a target="_blank" href="$1">$1</a>', $content);
		$com =  new Comment;
		$com->article_id = $request->article_id;
		$com->barcode_id = $request->barcode_id;
		$com->type = $request->type;
		$com->author = $request->author;
		$com->email = $request->email;
		$com->content = $content;
		$com->parent_id = $request->parent_id;
		$com->save();

		return view('layouts_frontend.comment', compact('com'))->render();
	}

    public function deleteCommentAjax(Request $request){
		$comment_id = $request->comment_id;
		$article_id =  $request->article_id;
		$barcode_id =  $request->barcode_id;
		$comment = Comment::find($comment_id);
		Helper::deleteComment($comment);
        if(isset($request->barcode_id)) {
            $totalComments = Comment::where('barcode_id',$barcode_id)->count();
        }else {
            $totalComments = Comment::where('article_id',$article_id)->count();
        }
		return response()->json(['status' => 200,"totalComments"=>$totalComments]);
	}

	public function filterCommentAjax(Request $request){
		$filter_comment = $request->filter_comment;
		$article_id = $request->article_id;
		$barcode_id = $request->barcode_id;
		if($filter_comment == 1) {
            $filter = 'desc';
		}else {
            $filter = 'asc';
		}
        if(isset($request->barcode_id)) {
			$comments = Comment::where('barcode_id',$barcode_id)->where('parent_id', 0)->orderBy('id', $filter)->get();
        }else {
			$comments = Comment::where('article_id',$article_id)->where('parent_id', 0)->orderBy('id', $filter)->get();
        }
		return view('layouts_frontend.comment_1', compact('comments'))->render();
	}

    public function searchAjax(Request $request) {
        $search = $request->search;
        $results = Article::where('status', 1)
                        ->where('post_public_time', '<=', date('Y-m-d H:i:s'))
                        ->where(function($q) use ($search) {
					       	$q->where('title', 'like', '%'.$search.'%')
					            ->orWhere('content', 'like', '%'.$search.'%');
					    })
						->orderBy('count_view', 'DESC')
                        ->get()->toArray();
        return response()->json(["Response"=>"Success","results"=> $results]);
    }

    public function search(Request $request){
        if($request->search){
            $search = $request->search;
			$news = Article::where('status', 1)
                        ->where('post_public_time', '<=', date('Y-m-d H:i:s'))
                        ->where(function($q) use ($request) {
					       	$q->where('title', 'like', '%'.$request->search.'%')
					            ->orWhere('content', 'like', '%'.$request->search.'%');
					    })
						->orderBy('count_view', 'DESC')
                        ->paginate(10);
            if(count($news)==0) {
                $news_nominate = Article::where('status', 1)
                                ->where('post_public_time', '<=', date('Y-m-d H:i:s'))
                                ->orderBy('count_view', 'DESC')
                                ->paginate(10);
                return view('layouts_frontend.search',compact('search','news_nominate'),['news' => $news]);
            }
            return view('layouts_frontend.search',compact('search'),['news' => $news]);
        }else{
			$news = Article::where('status', 1)
                        ->where('post_public_time', '<=', date('Y-m-d H:i:s'))
						->orderBy('count_view', 'DESC')
                        ->paginate(10);
            return view('layouts_frontend.search',['news' => $news]);
		}
	}

    //end




	public function index(Request $request)
    {
        $datas = Article::orderBy('created_at', 'DESC')->paginate(15);
        return view('backend.article.index',compact('datas'));
    }

    public function create()
    {
        // $data_cat = ArticleCategory::where('language', 'en')->get();
        // $myfunc =  new Helper();
        // $categories = $myfunc->listCategories($data_cat,0,'',0);
        Cache::flush();
        return view('backend.article.form');
    }

    public function store(StoreArticleRequest $request)
    {
        if($request->list_ask == null){
            $list_ask = [];
        }else{
            $list_ask = json_decode($request->list_ask, TRUE);
        }
        $user_id = Auth::id();
        $date_current = date('Y-m-d H:i:s');

        $item                   = new Article;
        $item->title            = $request->title;
        $item->language    = 'en';
        $item->slug             = $request->slug;
        $item->intro            = $request->intro;
        $item->intro_faq            = $request->intro_faq;
        $item->ending            = $request->ending;
        $item->description      = $request->description;
        $item->relative_acticles= json_encode($request->relative_acticles);
        $item->content          = $request->content;
        $item->list_ask         = $list_ask ? $request->list_ask : null;
        $image                  = $request->image;
        $item->cat_id           = $request->cat_id;
        $item->status           = $request->status;
        $post_public_time = $request->post_public_time;
        if ($post_public_time != '') {
            $item->post_public_time = Helper::formatDate('d/m/Y H:i', $post_public_time, 'Y-m-d H:i:s');
        } else {
            $item->post_public_time = $date_current;
        }
        $item->seo_title        = $request->seo_title;
        $item->keywords    = $request->keywords;
        $item->seo_description  = $request->seo_description;
        $item->seo_indexed      = $request->seo_indexed;
        $item->count_view             = rand(100, 120);
        $item->rate             = rand(46, 50) / 10;
        $item->number_rate      = 50;



        $content = $request->content;
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
        $nodes = $dom->getElementsByTagName("*");
        $arrayList = [];
        foreach ($nodes as $key=>$node) {
            if($node->tagName == "h2"){
                $object = [];
                $object['name'] = $node->tagName;
                $object['value'] = $node->nodeValue;
                $object['tag'] = 'tag-' . $key;
                $arrayList[] = $object;
                // echo "tagName: " . $node->tagName."<br />";
                // echo "tagValue: " . $node->nodeValue."<br />";
                // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                $node->setAttribute('id', 'tag-' . $key);
            }
            if($node->tagName == "h3"){
                $object = [];
                $object['name'] = $node->tagName;
                $object['value'] = $node->nodeValue;
                $object['tag'] = 'tag-' . $key;
                $arrayList[] = $object;
                // echo "tagName: " . $node->tagName."<br />";
                // echo "tagValue: " . $node->nodeValue."<br />";
                // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                $node->setAttribute('id', 'tag-' . $key);
            }
            if($node->tagName == "h4"){
                $object = [];
                $object['name'] = $node->tagName;
                $object['value'] = $node->nodeValue;
                $object['tag'] = 'tag-' . $key;
                $arrayList[] = $object;
                // echo "tagName: " . $node->tagName."<br />";
                // echo "tagValue: " . $node->nodeValue."<br />";
                // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                $node->setAttribute('id', 'tag-' . $key);
            }
            if($node->tagName == "h5"){
                $object = [];
                $object['name'] = $node->tagName;
                $object['value'] = $node->nodeValue;
                $object['tag'] = 'tag-' . $key;
                $arrayList[] = $object;
                // echo "tagName: " . $node->tagName."<br />";
                // echo "tagValue: " . $node->nodeValue."<br />";
                // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                $node->setAttribute('id', 'tag-' . $key);
            }
            // echo $node->nodeValue."<br />";
        }

        $content = $dom->saveHTML($dom->documentElement);
        $json_data = json_encode($arrayList);

        $item->content = $content;
        $item->content_json = $json_data;





        // $item->og_type          = $request->og_type;
        // $item->og_title         = $request->og_title;
        // $item->og_description   = $request->og_description;
        // $item->og_image         = $request->og_image;
        // $item->og_image_alt     = $request->og_image_alt;
        // $item->twitter_title    = $request->twitter_title;
        // $item->twitter_description    = $request->twitter_description;
        // $item->twitter_image    = $request->twitter_image;
        // $item->schema_type      = $request->schema_type;
        // $item->schema_code      = $request->schema_content;
        $item->created_by       = $user_id;
        $item->updated_by       = $user_id;
        $item->created_at       = $date_current;

        if ($image != '') {
            $image = explode("/filemanager/data-images/", $image);
            $item->image = $image[1];
        }

        $item->save();
        $item->article_lang_id = $item->id;
        $item->save();

        $tags = $request->article_tag;

        if (!empty($tags)) {
            $tag_slug = [];
            $article_tag_arr = [];
            foreach ($tags as $key => $tag) {
                $tag = trim($tag);
                $tag_slug[$key] = Str::slug($tag, '-');
                if ( isset(Tag::where('slug', $tag_slug[$key])->first()->id) ){
                    if ( !isset(ArticleTag::where( 'tag_id', Tag::where('slug', $tag_slug[$key])->first()->id )->where('article_id', $item->id)->first()->id) ){
                        $article_tag = new ArticleTag;
                        $article_tag->article_id = $item->id;
                        $article_tag->tag_id = Tag::where('slug', $tag_slug[$key])->first()->id;
                        $article_tag->save();
                        $article_tag_arr[$key] = $article_tag->tag_id;
                    }
                }else{
                    $new_tag = new Tag;
                    $new_tag->name = $tag;
                    $new_tag->slug = $tag_slug[$key];
                    $new_tag->save();

                    $article_tag = new ArticleTag;
                    $article_tag->article_id = $item->id;
                    $article_tag->tag_id = $new_tag->id;
                    $article_tag->save();
                    $article_tag_arr[$key] = $new_tag->id;
                }
            }
        }

        Cache::flush();
        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function edit(Request $request, $id)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $data = Article::leftJoin('article_tag', 'article_tag.article_id', '=', 'articles.id')
                        ->leftJoin('tags', 'tags.id', '=', 'article_tag.tag_id')
                        ->selectRaw('GROUP_CONCAT(DISTINCT tags.name) as list_tags,articles.*')
                        ->where('articles.id', $id)
                        // ->where('articles.language', $language)
                        ->groupBy('articles.id')
                        ->first();

        if ($data) {
            // $categories = Helper::callProcessSelect(ArticleCategory::where('language', $language)->get(), 0, '', $data->cat_id);
            return view('backend.article.form', compact('data'));
        }
        Cache::flush();
        return view('backend.article.form', compact('data'));
    }

    public function update($id, Request $request)
    {
        if($request->list_ask == null){
            $list_ask = [];
        }else{
            $list_ask = json_decode($request->list_ask, TRUE);
        }

        $language = ($request->language != '') ? $request->language : 'en';
        $data = Article::where('id', $id)->first();
        $user_id = \Auth::id();
        $date_current = date('Y-m-d H:i:s');
    
        if ($data) { //UPDATE
            $rules = [
                'cat_id'            => 'required',
                'description'       => 'required',
                'content'           => 'required',
                'image'             => 'required',
                'list_ask'          => 'checkJson',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]);
            } else {
                $title = trim($request->title);
                $item                   = Article::find($data->id);
                $item->title            = $title;
                $item->slug             = $request->slug;
                $item->intro            = $request->intro;
                $item->intro_faq            = $request->intro_faq;
                $item->ending            = $request->ending;
                $item->description      = $request->description;
                $item->relative_acticles= json_encode($request->relative_acticles);
                $item->content          = $request->content;
                $item->list_ask          = $list_ask ? $request->list_ask : null;
                $image                  = $request->image;
                $item->cat_id           = $request->cat_id;
                $item->language    = $request->language;
                $item->status           = $request->status;
                $post_public_time = $request->post_public_time;
                if ($post_public_time != '') {
                    $item->post_public_time = Helper::formatDate('d/m/Y H:i', $post_public_time, 'Y-m-d H:i:s');
                } else {
                    $item->post_public_time = $date_current;
                }
                $item->seo_title        = $request->seo_title;
                $item->keywords    = $request->keywords;
                $item->seo_description  = $request->seo_description;
                $item->seo_indexed      = $request->seo_indexed;


                $content = $request->content;
                $dom = new \DOMDocument();
                @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                $nodes = $dom->getElementsByTagName("*");
                $arrayList = [];
                foreach ($nodes as $key=>$node) {
                    if($node->tagName == "h2"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h3"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h4"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h5"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    // echo $node->nodeValue."<br />";
                }

                $content = $dom->saveHTML($dom->documentElement);
                $json_data = json_encode($arrayList);

                $item->content = $content;
                $item->content_json = $json_data;


                // $item->og_type          = $request->og_type;
                // $item->og_title         = $request->og_title;
                // $item->og_description   = $request->og_description;
                // $item->og_image         = $request->og_image;
                // $item->og_image_alt     = $request->og_image_alt;
                // $item->twitter_title    = $request->twitter_title;
                // $item->twitter_description    = $request->twitter_description;
                // $item->twitter_image    = $request->twitter_image;
                // $item->schema_type      = $request->schema_type;
                // $item->schema_code      = $request->schema_content;
                $item->updated_by       = $user_id;
                $item->updated_at       = $date_current;

                if ($image != '') {
                    $image = explode("/filemanager/data-images/", $image);
                    $item->image = $image[1];
                }
            }
        } else {
            $rules = [
                // 'title'          => 'required|max:70|unique:articles,title',
                'slug'          => 'required|max:255|unique:articles,slug',
                'cat_id'          => 'required',
                'description'          => 'required',
                'content'          => 'required',
                'image'          => 'required',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]);
            } else {
                $item                   = new Article();
                $item->title            = $request->title;
                $item->slug             = $request->slug;
                $item->intro            = $request->intro;
                $item->intro_faq            = $request->intro_faq;
                $item->ending            = $request->ending;
                $item->description      = $request->description;
                $item->relative_acticles= json_encode($request->relative_acticles);
                $item->content          = $request->content;
                $item->list_ask          = is_array($list_ask) ? json_encode($list_ask) : null;
                $image                  = $request->image;
                $item->cat_id           = $request->cat_id;
                $item->language    = $request->language;
                $item->status           = $request->status;
                $post_public_time = $request->post_public_time;
                if ($post_public_time != '') {
                    $item->post_public_time = Helper::formatDate('d/m/Y H:i', $post_public_time, 'Y-m-d H:i:s');
                } else {
                    $item->post_public_time = $date_current;
                }
                $item->seo_title        = $request->seo_title;
                $item->keywords    = $request->keywords;
                $item->seo_description  = $request->seo_description;
                $item->seo_indexed      = $request->seo_indexed;


                $content = $request->content;
                $dom = new \DOMDocument();
                @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                $nodes = $dom->getElementsByTagName("*");
                $arrayList = [];
                foreach ($nodes as $key=>$node) {
                    if($node->tagName == "h2"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h3"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h4"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    if($node->tagName == "h5"){
                        $object = [];
                        $object['name'] = $node->tagName;
                        $object['value'] = $node->nodeValue;
                        $object['tag'] = 'tag-' . $key;
                        $arrayList[] = $object;
                        // echo "tagName: " . $node->tagName."<br />";
                        // echo "tagValue: " . $node->nodeValue."<br />";
                        // echo "tagValue: " . $node->setAttribute('id', 'tag-' . $key) ."<br />";
                        $node->setAttribute('id', 'tag-' . $key);
                    }
                    // echo $node->nodeValue."<br />";
                }

                $content = $dom->saveHTML($dom->documentElement);
                $json_data = json_encode($arrayList);
                $item->rate             = rand(46, 50) / 10;
                $item->number_rate      = 50;

                $item->content = $content;
                $item->content_json = $json_data;

                // $item->og_type          = $request->og_type;
                // $item->og_title         = $request->og_title;
                // $item->og_description   = $request->og_description;
                // $item->og_image         = $request->og_image;
                // $item->og_image_alt     = $request->og_image_alt;
                // $item->twitter_title    = $request->twitter_title;
                // $item->twitter_description    = $request->twitter_description;
                // $item->twitter_image    = $request->twitter_image;
                // $item->schema_type      = $request->schema_type;
                // $item->schema_code      = $request->schema_content;
                $item->created_by       = $user_id;
                $item->updated_by       = $user_id;
                $item->created_at       = $date_current;
                $item->updated_at       = $date_current;

                if ($image != '') {
                    $image = explode("/filemanager/data-images/", $image);
                    $item->image = $image[1];
                }
                $item->article_lang_id = Article::where('language', 'en')->where('article_lang_id', $id)->value('article_lang_id');
            }
        }
        $item->save();

        $tags = $request->article_tag;
        ArticleTag::where('article_tag.article_id', $id)->delete();
        if (!empty($tags)) {
            // dd($tags);
            $tag_slug = [];
            $article_tag_arr = [];
            // dd($request->article_tag);
            foreach ($tags as $key => $tag) {
                $tag = trim($tag);
                $tag_slug[$key] = Str::slug($tag, '-');

                if ( isset(Tag::where('slug', $tag_slug[$key])->first()->id) ){
                    if ( !isset(ArticleTag::where( 'tag_id', Tag::where('slug', $tag_slug[$key])->first()->id )->where('article_id', $id)->first()->id) ){
                        $article_tag = new ArticleTag;
                        $article_tag->article_id = $item->id;
                        $article_tag->tag_id = Tag::where('slug', $tag_slug[$key])->first()->id;
                        $article_tag->save();
                        $article_tag_arr[$key] = $article_tag->tag_id;
                    }
                }else{
                    $new_tag = new Tag;
                    $new_tag->name = $tag;
                    $new_tag->slug = $tag_slug[$key];
                    $new_tag->save();

                    $article_tag = new ArticleTag;
                    $article_tag->article_id = $item->id;
                    $article_tag->tag_id = $new_tag->id;
                    $article_tag->save();
                    $article_tag_arr[$key] = $new_tag->id;
                }
            }
        }
        Cache::flush();
        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function destroy($id)
    {
        Article::where('article_lang_id', $id)->delete();
        Cache::flush();
        return response()->json(['message' => 'Xóa thông tin thành công!', 'status' => 200]);
    }

    public function getArticleAjax(Request $request)
    {
        $articles = Article::where('title', 'like', '%'.$request->search.'%')->orderBy('created_at','DESC')->get();
        return view('backend.article.table', compact('articles'))->render();
    }

    public function getDataAjax(Request $request)
    {
        $articles = Article::getDataForDatatable($request);
        return datatables()->of($articles)
                ->addColumn('action', function ($article) {
                    return $article->article_lang_id;
                })
                ->addColumn('rows', function ($article) {
                    return $article->article_lang_id;
                })
                ->removeColumn('id')->make(true);
    }

    public function delMulti(Request $request){
        if(isset($request) && $request->input('id_list')){
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if(Article::delMulti($id_list)){
                $res=array('status'=>200,"Message"=>"Đã xóa lựa chọn thành công");
            }else{
                $res=array('status'=>"204","Message"=>"Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function list(Request $request)
    {

        $language = $this->global_language;
        $data = Article::leftJoin('users', 'users.id', '=', 'articles.created_by')
                        ->select('users.name', 'users.avatar', 'articles.id', 'articles.title', 'articles.slug', 'articles.type', 'articles.created_at', 'articles.image')
                        ->where('articles.language', $language)
                        ->where('articles.status', 1);
        if ($request->order_by == 'desc' || !isset($request->order_by)) {
            $data->orderBy('articles.post_public_time', 'desc');
        }
        if ($request->order_by == 'asc') {
            $data->orderBy('articles.id', 'asc');
        }
        if ($request->order_by == 'count_view_desc') {
            $data->orderBy('articles.count_view', 'desc');
        }
        if ($request->filter > 0) {
            $data->where('articles.type', $request->filter);
        }
        $data = $data->paginate(13);
        return view('frontend.layouts.article.index', compact('data'));
    }

    public function showArticle($slug)
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
                $relateds = Article::select('title', 'slug','image','id')->whereIn('id',json_decode($data->relative_acticles))->orderBy('count_view','desc')->get();
            }else{
                $relateds = Article::select('title', 'slug', 'image', 'id')->where('cat_id',$data->cat_id)->orderBy('count_view','desc')->take(3)->get();
            }
            Helper::countVisitedBlog($slug);

            $keywords_not_good = SiteConfig::where('key', 'keywords_not_good')->value('value');
            
            // if (in_array($id, [532, 534, 535, 533, 536, 538, 539, 540, 541, 542, 544, 545, 546, 547, 548, 549])) {
            //     Cache::remember('list_server', 24*60*60, function (){
            //         $list_server = Helper::get_server_list(true);
            //         return $list_server;
            //     });

            //     $result_obj = (object)array();
            //     $article_speed = true;
            //     $content = $data->content;
            //     $content = explode("<h2",$content);
            //     $new = [];
            //     $j = count($content);
            //     for( $i=1 ; $i<$j ; $i++) {
            //         $part = '<h2' . $content[$i];
            //         if($i == $j-1) {
            //             $part = preg_replace('(</body>)','',$part);
            //             $part = preg_replace('(</html>)','',$part);
            //         }
            //         array_push($new, $part);
            //     }
            //     return view('frontend.layouts.article.detail_big', compact('data', 'result_obj', 'article_speed','totalComments','relateds', 'keywords_not_good','new'));
            // } else  {
            // }
            return view('layouts_frontend.article.detail', compact('data','totalComments','relateds', 'keywords_not_good'));
        } else {
            $id = (int)$id;
            $data = Article::where('id', $id)
                        ->where('status', 1)
                        ->first();
            if($data){
                return redirect(route('client.show-article', ['slug' => $data->slug, 'id' => $data->id]), 301);
            }else{
                abort(404);
            }
        }

    }

    public function showTagArticle(Request $request, $slug)
    {
        $query = Article::rightJoin('article_tag', 'article_tag.article_id', '=', 'articles.id')
                        ->rightJoin('tags', 'tags.id', '=', 'article_tag.tag_id')
                        ->select('articles.*', 'tags.name as tag_name')
                        ->where('tags.slug', $slug)
                        ->where('articles.status', 1);
        $link_first = $query->first();
        $data = $query->paginate(10);
        return view('frontend.layouts.article.tags', compact('data', 'link_first'));
    }

    public function getAritcleCorrespondingLanguage (Request $request)
    {
        $article_lang_id = Article::where('id', $request->article_id)->value('article_lang_id');
        $data = Article::where('language', $request->language)->where('article_lang_id', $article_lang_id)->first(['id', 'slug']);
        if ($data) {
            $link = url('/' . $request->language . '/detail-news/' . $data->slug . '-' . $data->id .'.html');
        } else {
            $link = url('/' . $request->language);
        }
        return response()->json(['message' => 'Xóa thông tin thành công!', 'status' => 200, 'link' => $link]);
    }
}
