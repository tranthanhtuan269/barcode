<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, File, Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Helpers\Helper;
use App\Models\BarCode;
use App\Models\SiteConfig;
use App\EmailSubscribenNews;
use Illuminate\Support\Str;
use App\Helpers\BatvHelper;
use Cache;


class BarCodeAdminController extends Controller
{


    public function index(Request $request)
    {
        $datas = BarCode::orderBy('created_at', 'DESC')->paginate(20);
        return view('backend.barcode.index', compact('datas'));
    }

    public function create()
    {
        return view('backend.barcode.form');
    }

    public function store(Request $request)
    {
        $list_ask = json_decode($request->list_ask, TRUE);
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
        $item->relative_acticles = json_encode($request->relative_acticles);
        $item->content          = $request->content;
        $item->list_ask          = $list_ask ? $request->list_ask : null;
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
        foreach ($nodes as $key => $node) {
            if ($node->tagName == "h2") {
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
            if ($node->tagName == "h3") {
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
            if ($node->tagName == "h4") {
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
            if ($node->tagName == "h5") {
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

        $item->image = $image;
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
                if (isset(Tag::where('slug', $tag_slug[$key])->first()->id)) {
                    if (!isset(ArticleTag::where('tag_id', Tag::where('slug', $tag_slug[$key])->first()->id)->where('article_id', $item->id)->first()->id)) {
                        $article_tag = new ArticleTag;
                        $article_tag->article_id = $item->id;
                        $article_tag->tag_id = Tag::where('slug', $tag_slug[$key])->first()->id;
                        $article_tag->save();
                        $article_tag_arr[$key] = $article_tag->tag_id;
                    }
                } else {
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
        $data = BarCode::where('id', $id)->first();

        if ($data) {
            return view('backend.barcode.form', compact('data'));
        }
        return view('backend.barcode.form', compact('data'));
    }

    public function update($id, Request $request)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $item = BarCode::where('id', $id)->first();
        $date_current = date('Y-m-d H:i:s');

        if ($item) {
            $item->image = $request->image;
            $list_ask = json_decode($request->list_ask, TRUE);
            $item->list_ask          = $list_ask ? $request->list_ask : null;
            $item->name            = $request->name;
            $item->barcode            = $request->barcode;
            $item->model            = $request->model;
            $item->manufacturer            = $request->manufacturer;
            $item->avg_price          = $request->avg_price;
            $item->currency_unit           = $request->currency_unit;
            $item->title_content      = $request->title_content;
            $item->description      = $request->description;
            $item->spec    = $request->spec;
            $item->feature           = $request->feature;
            $item->seo_title        = $request->seo_title;
            $item->keywords    = $request->keywords;
            $item->seo_description  = $request->seo_description;
            $item->seo_indexed      = $request->seo_indexed;
            $item->show_status = $request->show_status;
            $item->updated_at      = $date_current;
            $item->related_articles = json_encode($request->related_articles);

            $content = $request->content;
            $dom = new \DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
            $nodes = $dom->getElementsByTagName("*");
            $arrayList = [];
            foreach ($nodes as $key => $node) {
                if ($node->tagName == "h2") {
                    $object = [];
                    $object['name'] = $node->tagName;
                    $object['value'] = $node->nodeValue;
                    $object['tag'] = 'tag-' . $key;
                    $arrayList[] = $object;
                    $node->setAttribute('id', 'tag-' . $key);
                }
                if ($node->tagName == "h3") {
                    $object = [];
                    $object['name'] = $node->tagName;
                    $object['value'] = $node->nodeValue;
                    $object['tag'] = 'tag-' . $key;
                    $arrayList[] = $object;
                    $node->setAttribute('id', 'tag-' . $key);
                }
            }
            $content = $dom->saveHTML($dom->documentElement);
            $json_data = json_encode($arrayList);
            $item->content = $content;
            $item->content_json = $json_data;

            $item->save();
            BatvHelper::updateBarcode($item);
            return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
        }
    }

    public function destroy($id)
    {
        Article::where('article_lang_id', $id)->delete();
        return response()->json(['message' => 'Xóa thông tin thành công!', 'status' => 200]);
    }

    public function getBarcodeAjax(Request $request)
    {
        $articles = BarCode::where('name', 'like', '%' . $request->search . '%')->orWhere('barcode', 'like', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->get();
        return view('backend.barcode.table', compact('articles'))->render();
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

    public function delMulti(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if (BarCode::delMulti($id_list)) {
                $res = array('status' => 200, "Message" => "Đã xóa lựa chọn thành công");
            } else {
                $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
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

    public function getAritcleCorrespondingLanguage(Request $request)
    {
        $article_lang_id = Article::where('id', $request->article_id)->value('article_lang_id');
        $data = Article::where('language', $request->language)->where('article_lang_id', $article_lang_id)->first(['id', 'slug']);
        if ($data) {
            $link = url('/' . $request->language . '/detail-news/' . $data->slug . '-' . $data->id . '.html');
        } else {
            $link = url('/' . $request->language);
        }
        return response()->json(['message' => 'Xóa thông tin thành công!', 'status' => 200, 'link' => $link]);
    }
}
