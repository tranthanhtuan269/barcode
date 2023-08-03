<?php

namespace App\Http\Controllers;

use App\Models\Article;

class RssController extends Controller
{
    public function indexTest(){
        $articles = Article::where('updated_at', '<=', date('Y-m-d H:i:s'))->orderBy('updated_at', 'desc')->limit(50)->get();
        return response()->view('layouts_frontend.rss.feed', compact('articles'))->header('Content-Type', 'application/xml');
    }
}
