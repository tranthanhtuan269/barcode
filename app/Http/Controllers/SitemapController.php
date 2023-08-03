<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\BarCode;
use App\Models\Article;
use App\Models\ArticleCategory;
use Cache;


class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function barcodes() 
    {
        $barcodes = Barcode::where('seo_indexed', 1)->latest()->get();
        return response()->view('sitemap.barcodes', [
            'barcodes' => $barcodes,
        ])->header('Content-Type', 'text/xml');
    }

    public function pages() 
    {   
        $cates = ArticleCategory::all();
        $articles = Article::where('seo_indexed', 1)->where('post_public_time', '<=', date('Y-m-d H:i:s'))->select('title', 'id','updated_at','slug')->get();
        foreach ($articles as $article) {
            if(strpos($article->slug, '’') > -1){
                $article->slug = str_replace('’', '', $article->slug);
                $article->save();
            }
        }
        return response()->view('sitemap.pages',[
            'cates' => $cates,
            'articles' => $articles,
        ])->header('Content-Type', 'text/xml');
    }

}
