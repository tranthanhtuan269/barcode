<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,File,Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Article;
use Illuminate\Support\Str;
use Cache;


class CronjobController extends Controller
{
    //update seo - 21/10/2022
    public function saveVisited (){
        $file_blog = public_path('visited_blog2.txt');
        $recoveredData_blog = file_get_contents($file_blog);
        $recoveredArray_blog = unserialize($recoveredData_blog);
        if (is_array($recoveredArray_blog) && count($recoveredArray_blog) > 0) {
          foreach ($recoveredArray_blog as $blog_id => $count_visited_blog) {
            $item = Article::find($blog_id);
            if ($item) {
              $item->count_view = $item->count_view + $count_visited_blog;
              $item->save();
            }
          }
          
          file_put_contents($file_blog, '');
        }
    }
}
