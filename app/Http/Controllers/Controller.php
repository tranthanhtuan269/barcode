<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use View;
use App\Models\Aff;
use App\Models\Request as TOHRequest;
use App\Models\Page;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\SiteConfig;
use App\Helpers\Helper;
use Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct() {
        // \Cache::flush();
        // check aff link
        if(isset($_GET['aff'])){
            $aff = Aff::where('slug', $_GET['aff'])->first();
            if($aff){
                // create request
                $request = new TOHRequest;
                $request->aff_id = $aff->id;
                $request->link = url()->current();
                $request->save();
                
                if(date("Y-m-d H") == $aff->updated_at->format("Y-m-d H")){
                    $aff->last_hour = $aff->last_hour + 1;
                    $aff->last_day = $aff->last_day + 1;
                    $aff->last_month = $aff->last_month + 1;
                    $aff->last_year = $aff->last_year + 1;
                    $aff->save();
                }else{
                    if($aff->json_content == null){
                        $data = array(array(
                            "time" => $aff->updated_at->format("Y-m-d H"),
                            "access" => $aff->last_hour
                        ));
                        $aff->json_content = json_encode($data);
                    }else{
                        $array = json_decode($aff->json_content);

                        $data = array(
                            "time" => $aff->updated_at->format("Y-m-d H"),
                            "access" => $aff->last_hour
                        );

                        array_push($array, $data);
                        $aff->json_content = json_encode($array);
                        $aff->save();
                    }
                    if(date("Y-m-d") == $aff->updated_at->format("Y-m-d")){
                        $aff->last_hour = 1;
                        $aff->last_day = $aff->last_day + 1;
                        $aff->last_month = $aff->last_month + 1;
                        $aff->last_year = $aff->last_year + 1;
                        $aff->save();
                    }else{
                        if(date("Y-m") == $aff->updated_at->format("Y-m")){
                            $aff->last_hour = 1;
                            $aff->last_day = 1;
                            $aff->last_month = $aff->last_month + 1;
                            $aff->last_year = $aff->last_year + 1;
                            $aff->save();
                        }else{
                            if(date("Y") == $aff->updated_at->format("Y")){
                                $aff->last_hour = 1;
                                $aff->last_day = 1;
                                $aff->last_month = 1;
                                $aff->last_year = $aff->last_year + 1;
                                $aff->save();
                            }else{
                                $aff->last_hour = 1;
                                $aff->last_day = 1;
                                $aff->last_month = 1;
                                $aff->last_year = 1;
                                $aff->save();
                            }
                        }
                    }
                }
            }
        }

        Helper::linkRedirect(url()->current());
        
        // if (!in_array(\Route::getCurrentRoute()->getPath(), ['save-cache-visited-website', 'get-data-ajax-highchart'])) {
        //     // ======START Đếm lượt visited======
        //     Cache::rememberForever('cache_visited', function () {
        //         return [];
        //     });

        //     $cache_visited = Cache::get('cache_visited');

        //     if (!isset($_COOKIE['cache_visited'])) {
        //         if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        //                   $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        //                   $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        //         }
                
        //         $client  = @$_SERVER['HTTP_CLIENT_IP'];
        //         $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        //         $remote  = $_SERVER['REMOTE_ADDR'];

        //         if(filter_var($client, FILTER_VALIDATE_IP)) {
        //             $ip = $client;
        //         } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        //             $ip = $forward;
        //         } else {
        //             $ip = $remote;
        //         }

        //         $cache_visited[]= ['created_at' => date('Y-m-d H:i:s'), 'ip' => $ip];
        //         Cache::put('cache_visited', $cache_visited, 14400); // 10*24*60 = 10 ngày
        //         setcookie('cache_visited', "cache_visited", time() + 86400 );// 1 day
        //     }
        //     // ======END Đếm lượt visited======
        // }

        //update-seo 19/10/2022
        Cache::rememberForever('cache_all_article', function () {
            return Article::select('title', 'id','updated_at','slug')->get();
        });
        \View::share('cache_all_article', Cache::get('cache_all_article'));

        Cache::rememberForever('cache_all_categories', function () {
            return ArticleCategory::where('language', 'en')->get();
        });
        \View::share('cache_all_categories', Cache::get('cache_all_categories'));

        Cache::rememberForever('cate_root', function () {
            $result = "";
            $cates =  ArticleCategory::select('slug','title','id')->where('parent_id',0)->get();
            foreach ($cates as $cate) {
                $result.= '<li>';
                $link = url('/') .'/' . $cate->slug;
                $result.= '<a href="' . $link . '" >' . $cate->title . '</a>';
                $result.= '</li>';
            }
            return $result;
        });
        \View::share('cate_root', Cache::get('cate_root'));

        Cache::rememberForever('cate_child', function () {
            $result = "";
            $cate =  ArticleCategory::where('slug','blog')->first();
            $cates = ArticleCategory::select('slug','title','id')->where('parent_id',$cate->id)->get();
            foreach ($cates as $cate) {
                $result.= '<li>';
                $link = url('/') .'/' . $cate->slug;
                $result.= '<a href="' . $link . '" >' . $cate->title . '</a>';
                $result.= '</li>';
            }
            return $result;
        });
        \View::share('cate_child', Cache::get('cate_child'));

        Cache::rememberForever('socials', function () {
            return SiteConfig::where('social',1)->get();
        });
        \View::share('socials', Cache::get('socials'));

        Cache::rememberForever('apple_store_link', function () {
            return SiteConfig::where('key', 'apple_store_link')->value('value');
        });

        Cache::rememberForever('google_play_link', function () {
            return SiteConfig::where('key', 'google_play_link')->value('value');
        });
        
        $pages = Page::get();
        \View::share('pages', $pages);

    } 
}
