<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DateTime;
use App\Barcode;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use App\PostCategory;
use App\Models\Role;
use App\Models\Redirect;
use App\Models\Article;
use App\Permission;
use App\RequestLogs;
use Cache;
use App\SendEmail;

class Helper {

    ///update-seo

    protected $_result ='';
    public static $result = '';

    public static function linkRedirect($link_old) {
        $link_new = Redirect::where('link_old', $link_old)->value('link_new');
        
        if (!empty($link_new)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $link_new);
            exit();
        }
    }

    public static function menuMain() {
        Cache::rememberForever('menuMain', function () {
            $menuMain = \App\Menu::where('id_menu', 1)->where('parent_id', 0)->where('language', 'en')->orderBy('id', 'desc')->get();
    		$result = '';

            foreach ($menuMain as $item) {
            	$list_children = $item->childrens()->where('id_menu', 1)->get();
        		$href = ($item->link != '') ? $item->link : route($item->route, ['slug' => $item->slug, 'id' => $item->id_root]);
                $rel = '';
                if ($item->link == 'https://gospeedcheck.com/about') {
                    $rel = "rel='nofollow'";
                }

            	if (count($list_children) > 0) {
	                $result .= '<li class="nav-item dropdown">';
	                	$result .= '<a class="nav-link dropdown-toggle" href="'.$href .'" '. $rel .' >'.$item->name_cat.'</a>';
	                	$result .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';

	                		foreach ($list_children as $child) {
	                			$href_child = ($child->link != '') ? $child->link : route($child->route, ['slug' => $child->slug, 'id' => $child->id_root]);
	                			$result .= '<a class="dropdown-item" href="'.$href_child.'">'.$child->name_cat.'</a>';
	                		}

	                	$result .= '</div>';
	                $result .= '</li>';
            	} else {
	                $result .= '<li class="nav-item menu-1">';
	                	$result .= '<a class="nav-link" href="'.$href.'" '. $rel .'>'.$item->name_cat.'</a>';
	                $result .= '</li>';
            	}
            }

            echo $result;
        });
    }

    public static function mynl2br($text) { 
       return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
    } 

    public static function deleteComment($comment){
        $children = $comment->children;
        foreach($children as $child){
            Helper::deleteComment($child);
        }
        $comment->delete();
    }

    public static function removeSpecialCharacter($string) {
        return preg_replace('/[^A-Za-z0-9 ]/','',$string);
    }

    public static function menuFooter() {
        Cache::rememberForever('menuFooter', function () {
            $menuMain = \App\Menu::where('id_menu', 2)->where('parent_id', 0)->where('language', 'en')->orderBy('id', 'desc')->get();
    		$result = '';

            foreach ($menuMain as $item) {
            	$list_children = $item->childrens()->where('id_menu', 2)->get();

                $result .= '<div class="col-12 col-md-2 mx-auto mt-3">';
                	$result .= '<div class="text-uppercase font-weight-bold">'.$item->name_cat.'</div>';
                	$result .= '<hr class="deep-purple accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 50px;">';

            		foreach ($list_children as $child) {
            			$href_child = ($child->link != '') ? $child->link : route($child->route, ['slug' => $child->slug, 'id' => $child->id_root]);
            			$result .= '<div><a class="color-text" href="'.$href_child.'">'.$child->name_cat.'</a></div>';
            		}

            	$result .= '</div>';
            }

            echo $result;
        });
    }

    public static function siteConfig() {
        return Cache::rememberForever('siteConfig', function () {
            return \App\SiteConfig::where('language', 0)->pluck('value', 'key');
        });
    }
    public static function menuMainMobile() {
        Cache::rememberForever('menuMainMobile', function () {
            $menuMain = \App\Menu::where('id_menu', 1)->where('parent_id', 0)->where('language', 'en')->orderBy('id', 'desc')->get();
            $result = '';

            foreach ($menuMain as $item) {
                $list_children = $item->childrens()->where('id_menu', 1)->get();
                $href = ($item->link != '') ? $item->link : route($item->route, ['slug' => $item->slug, 'id' => $item->id_root]);
                $rel = '';
                if ($item->link == 'https://gospeedcheck.com/about') {
                    $rel = "rel='nofollow'";
                }
                if (count($list_children) > 0) {
                    $result .= '<li class="menu-hasdropdown">';
                        $result .= '<a class="nav-link" href="'.$href .'" '. $rel .'  >'.$item->name_cat.'<label title="toggle menu" for="'.$item->name_cat.'"><img src="'.asset("frontend/images/ic_arrow_dropdown.svg").'" class="img-arow"></label></a><input type="checkbox" id="'.$item->name_cat.'">';
                        $result .= '<ul class="menu-dropdown">';

                            foreach ($list_children as $child) {
                                $href_child = ($child->link != '') ? $child->link : route($child->route, ['slug' => $child->slug, 'id' => $child->id_root]);
                                $result .= '<li><a class="dropdown-item" href="'.$href_child.'">'.$child->name_cat.'</a></li>';
                            }

                        $result .= '</ul>';
                    $result .= '</li>';
                } else {
                    $result .= '<li>';
                        $result .= '<a class="nav-link" href="'.$href.'" '. $rel .'  >'.$item->name_cat.'</a>';
                    $result .= '</li>';
                }
            }

            echo $result;
        });
    }
    public static function clearCache() {
        Cache::forget('global_seo_title');
        Cache::forget('global_seo_description');
        Cache::forget('global_seo_keywords');
        Cache::forget('siteConfig');
        Cache::forget('menuMain');
        Cache::forget('menuFooter');
        Cache::forget('menuMainMobile');
        Cache::forget('cache_language');
    }

    public static function countVisitedBlog($article) {
        // $article = Article::where('id', $id)->first();
        $article->count_view = $article->count_view + 1;
        $article->save(); 
        // $article_id = $a->id;
        // if (!isset($_COOKIE[$article_id])) {
        //     $file = public_path('visited_blog2.txt');
        //     $recoveredData = file_get_contents($file);
        //     $recoveredArray = unserialize($recoveredData);

        //     if (isset($recoveredArray[$article_id])) {
        //         $recoveredArray[$article_id] = $recoveredArray[$article_id] + 1;
        //     } else {
        //         $recoveredArray[$article_id] = 1;
        //     }

        //     $serializedData = serialize($recoveredArray);
        //     file_put_contents($file, $serializedData);
        //     setcookie($article_id, "visited_blog", time() + 2628000);// forever
        // }
    }


    public static function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

    // Hàm cắt chuỗi thông minh ^-^
    public static function smartStr($string, $length = 150, $character = '...') {
	    $limit = abs((int)$length);
	       if(strlen($string) > $limit) {
	          $string = preg_replace("/^(.{1,$limit})(\s.*|$)/s", '\1'.$character, $string);
	       }
	    return $string;
   }

    public static function updatedRequestCacheByMinute($key = '') {
        $time_day = date('Y-m-d');

        if ($key == '') {
            $data = cache()->getMemcached()->getAllKeys();
            if ($data) {
                $arr = [];
                foreach ($data as $value) {
                    $key_cache = str_replace('laravel_cache:', '', $value);
                    $arr = explode('_', $key_cache);

                    if ( isset($arr[1]) && \DateTime::createFromFormat('Y-m-d', $arr[1]) !== FALSE) {
                        $key_user_id = $arr[0].'-user_id_'. $time_day;
                        $key_package_id = $arr[0].'-package_id_'. $time_day;
                        $key_cache = $arr[0] .'_'. $time_day;

                        if (Cache::has($key_cache)) {
                            $package_id = Cache::get($key_package_id);
                            $data_request_month_user = RequestLogs::where([
                                                                ['user_id', Cache::get($key_user_id)],
                                                                ['time_day', $arr[1]],
                                                            ])->first();

                            if ($data_request_month_user) {
                                $data_request_month_user->total_request_day = $data_request_month_user->total_request_day + Cache::get($key_cache);
                                $data_request_month_user->save();
                            } else {
                                RequestLogs::insert([
                                    'user_id' => Cache::get($key_user_id),
                                    'time_day' => $arr[1],
                                    'total_request_day' => Cache::get($key_cache) > 0 ? Cache::get($key_cache) : 1,
                                    'package_id' => $package_id,
                                ]);
                            }

                            Cache::forget($key_cache);
                        }

                    }
                }
            }
        } else {
            $key_user_id = $key.'-user_id_'. $time_day;
            $key_limit_total_request_month = $key.'-limit_total_request_month_'. $time_day;
            $key_total_request_day = $key.'-total_request_day_'. $time_day;
            $key_cache = $key .'_'. $time_day;
            $key_package_id = $key.'-package_id_'. $time_day;

            if (Cache::has($key_cache)) {
                $package_id = Cache::get($key_package_id);
                $data_request_month_user = RequestLogs::where([
                                                    ['user_id', Cache::get($key_user_id)],
                                                    ['time_day', $time_day],
                                                ])->first();

                if ($data_request_month_user) {
                    $data_request_month_user->total_request_day = $data_request_month_user->total_request_day + Cache::get($key_cache);
                    $data_request_month_user->save();
                } else {
                    RequestLogs::insert([
                        'user_id' => Cache::get($key_user_id),
                        'time_day' => $time_day,
                        'total_request_day' => Cache::get($key_cache) > 0 ? Cache::get($key_cache) : 1,
                        'package_id' => $package_id,
                    ]);
                }

                Cache::forget($key_cache);
            }

            Cache::forget($key_total_request_day);
            Cache::forget($key_limit_total_request_month);
            Cache::forget($key_user_id);
            Cache::forget($key_package_id);
        }
    }

	public static function listRoles() {
        $list_roles = [];
        $user   = Auth::user();
        $user_id = $user->id;
        $role_id = $user->role_id;
        $data =  Role::where('id', $role_id)->first();

        if ($data) {
            $arr = explode(',', $data->permission);
            $data2 = Permission::find($arr);
            foreach ($data2 as $key => $value) {
                $list_roles[] = trim($value->route);
            }
        }

	    return $list_roles;
	}

	public static function checkPermissions($permission, $list_roles){
	    if (in_array($permission, $list_roles) || in_array('super_admin', $list_roles)) {
	     	return true;
		}

		return false;
    }

	public static function getArrCatId($post_type) {
        $language_id = session('language')['id'];
        $data = PostCategory::find($post_type);
        $data = json_decode($data->list_language, true);
        $id = $data[$language_id];
        $id_child = Helper::arrCategoriesChild_v2($id, 'post_categories_translate');
        $arr_cat_id = Helper::array_keys_multi($id_child);
        $arr_cat_id[] = $id;
        return $arr_cat_id;
    }

    public static function arrCatId($post_type, $language_id ) {
        $data = PostCategory::find($post_type);
        $data = json_decode($data->list_language, true);
        $id = $data[$language_id];
        $id_child = Helper::arrCategoriesChild_v2($id, 'post_categories_translate');
        $arr_cat_id = Helper::array_keys_multi($id_child);
        $arr_cat_id[] = $id;
        return $arr_cat_id;
    }

    public static function getKey($arr, $id)
    {
        foreach ($arr as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }

        return null;
    }

    public static function getParent($arr, $id)
    {
        $key = Helper::getKey($arr, $id);
        if ($arr[$key]['parent_id'] == 0) {
            return $id;
        } else {
            return Helper::getParent($arr, $arr[$key]['parent_id']);
        }
    }


    public static function callProcessSelect($data, $parent = 0,$text = '',$select=0) {
        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $id = $value->id;

                if ($select != 0 && $value->id == $select) {
                    self::$result .= '<option value="'.$value->id.'" selected="selected" data-slug="'.$value->slug.'">' .$text.$value->title.'</option>';
                } else {
                    self::$result .= '<option value="'.$value->id.'" data-slug="'.$value->slug.'">' .$text.$value->title.'</option>';
                }

                Helper::callProcessSelect($data,$id,$text.'--',$select);
            }
        }

        return self::$result;
    }

    public static function callProcessRadio($data, $parent = 0,$text = '',$select=0) {
        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $id = $value->id;
                self::$result .= '<div class="radio"><label>';

                if ($select != 0 && $value->id == $select) {
                    self::$result .= '<input type="radio" value="'.$value->id.'" checked>' .$value->title.'</option>';
                } else {
                    self::$result .= '<input type="radio" value="'.$value->id.'">' .$value->title.'</option>';
                }

                self::$result .= '</label></div>';

                Helper::callProcessRadio($data,$id,$text.'--',$select);
            }
        }

        return self::$result;
    }

    public static function formatPriceVND($price) {
        return  number_format($price,0,",",".");
    }

   public static function methodPayment($param) {
        switch ($param) {
            case 0:
                $txt = 'Giao hàng & Thu tiền tận nơi (COD)';
                break;
            case 1:
                $txt = 'Thanh toán qua ngân hàng (Quầy giao dịch hoặc Chuyển khoản)';
                break;
            default:
                $txt = 'Giao hàng & Thu tiền tận nơi (COD)';
                break;
        }
        return $txt;
    }

    public static function pagingDataSpecial($arr){
        $request = request();
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;
        return  new LengthAwarePaginator(array_slice($arr, $offset, $perPage, true), count($arr), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);
    }

    public static function formatDate($format_time, $time, $format, $time2 = null){
        if($time2 == null){
            $time2 = date('Y-m-d H:i:s');
        }
        // return $time;
        if($time != null && $time != '' && $time != '-0001-11-30 00:00:00'){
            return (!empty($time)) ? \Carbon\Carbon::createFromFormat($format_time,$time)->format($format) : '';
        }else{
            return (!empty($time2)) ? \Carbon\Carbon::createFromFormat($format_time,$time2)->format($format) : '';
        }
    }

    public function listCategories($data, $parent = 0,$text = '',$select=0){
        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $id = $value->id;

                if ($select != 0 && $value->id == $select) {
                    $this->_result .= '<option value="'.$value->id.'" selected="selected">' .$text.$value->title.'</option>';
                }else{
                    $this->_result .= '<option value="'.$value->id.'">' .$text.$value->title.'</option>';
                }

                $this->listCategories($data,$id,$text.'--',$select);
            }
        }

        return $this->_result;

    }

    public function callProcessSelectReal($data, $parent = 0,$text = '',$select=0) {
        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $id = $value->id;

                if ($select != 0 && $value->id == $select) {
                    $this->_result .= '<option value="'.$value->id.'" selected="selected" data-slug="'.$value->slug.'">' .$text.$value->title.'</option>';
                } else {
                    $this->_result .= '<option value="'.$value->id.'" data-slug="'.$value->slug.'">' .$text.$value->title.'</option>';
                }

                $this->callProcessSelectReal($data,$id,$text.'--',$select);
            }
        }

        return $this->_result;
    }

    public function listCatMenu($data, $parent = 0,$text = '',$select=0){
        foreach ($data as $k => $value){

            if ($value->parent_id == $parent) {
                $this->_result .= '<li style="display: list-item;" id="menuItem_'.$value->id_tmp.'" class="clear-element page-item1 left" data-route="'.$value->route.'" data-table="'.$value->name_table.'" data-id-root="'.$value->id_root.'" data-link="'.$value->link.'" data-slug="'.$value->slug.'" data-name-cat="'.$value->name_cat.'">';
                    $this->_result .= '<div class="menuDiv">';
                        $this->_result .= '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"></span>';
                        $this->_result .= '<span data-id="'.$value->id_tmp.'" class="itemTitle">'.$value->name_cat.'</span>';
                        $this->_result .= '<title="Click to delete item." data-id="'.$value->id_tmp.'" class="deleteMenu ui-icon ui-icon-closethick">';
                    $this->_result .= '</div>';
                    $this->_result .= '<ol>';
                        $this->listCatMenu($data,$value->id_tmp,$text,$select);
                    $this->_result .= '</ol>';
                $this->_result .= '</li>';
            }

        }

        return $this->_result;

    }

    // public function listCategoriesAction($data, $parent = 0, $text = '', $type){
    //     $list_roles = Helper::listRoles();

    //     foreach ($data as $k => $value){
    //         if ($value->parent_id == $parent) {
    //             $cat_id = $value->id;
    //             $confirm_delete = '';

    //             if ( $value->parent_id == 0 ) {
    //                 $this->_result .= '<tr>';
    //             } else {
    //                 $this->_result .= '</tr>';
    //             }

    //             $this->_result .= '<td>'.$text.$value->title.'</td>';
    //             $this->_result .='<td class="text-center">';
    //             $this->_result .='<a class="btn-edit" href="'.url('/admincp/'.$type.'/'.$cat_id.'/edit').'"> <i class="fa fa-edit"></i></a>';
    //             if (!Helper::checkPermissions('article.delete_category', $list_roles)) {
    //                 $this->_result .='<a href="javascript:void(0)" onclick="deleteCategory('. $cat_id .')"> <i class="fa fa-trash"></i></a>';
    //             }
    //             $this->_result .='</td>';


    //             $this->listCategoriesAction($data, $cat_id, $text.'--', $type);
    //         }
    //     }

    //     return $this->_result;
    // }

    public function listCategoriesAction($data, $parent = 0, $text = '', $type, $language){

        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $cat_id = $value->cat_lang_id;
                $confirm_delete = '';

                if ( $value->parent_id == 0 ) {
                    $this->_result .= '<tr>';
                } else {
                    $this->_result .= '</tr>';
                }

                $this->_result .= '<td>'.$text.$value->title.'</td>';
                $this->_result .= '<td>'.$text.$value->slug.'</td>';
                $this->_result .='<td class="text-center">';
                    $this->_result .='<a class="btn-edit" href="'.url('/admincp/'.$type.'/'.$cat_id.'/edit').'?language=en"> <i class="fa fa-edit"></i></a>';
                    $this->_result .='<a class="btn-edit" href="'.url('/admincp/'.$type.'/'.$cat_id.'/edit').'?language=vi"> <i class="fa fa-edit"></i></a>';
                $this->_result .='</td>';
                $this->_result .='<td class="text-center">';
                $this->_result .='<a href="javascript:void(0)" onclick="deleteCategory('. $cat_id .')"> <i class="fa fa-trash"></i></a>';
                $this->_result .='</td>';


                $this->listCategoriesAction($data, $value->id, $text.'--', $type, $language);
            }
        }

        return $this->_result;
    }

    public static function listPagesAction($data, $parent = 0, $text = '', $type=''){
        $arr_name_language = \Config::get('app.arr_name_language');
        $list_roles = Helper::listRoles();

        foreach ($data as $k => $value){
            if ($value->parent_id == $parent) {
                $id = $value->id;
                $confirm_delete = '';

                if ( $value->parent_id == 0 ) {
                    self::$result .= '<tr>';
                } else {
                    self::$result.= '</tr>';
                }

                self::$result .= '<td>'.$text.$value->title.'</td>';

                $arr_list_language = json_decode($value->list_language, true);
                $arr_list_language_id = array_keys($arr_list_language);

                self::$result .= '<td class="text-center">';

                foreach ($arr_name_language as $k_lang => $v_lang) {
                    if (in_array($k_lang, $arr_list_language_id)) {
                        self::$result .= '<a href="'.route("admincp.pages.edit", [ "page" => $arr_list_language[$k_lang] ]).'"><i class="fa fa-edit"></i></a> &nbsp';
                        // if (Helper::checkPermissions('page.edit', $list_roles)) {
                        // }
                    } else {
                        self::$result .= '<a href="'.route("admincp.pages.add-item-other", ["page_id" => $value->page_id, "language_id"=> $k_lang]).'"><i class="fa fa-plus"></i></a> &nbsp';
                        // if (Helper::checkPermissions('page.add', $list_roles)) {
                        // }
                    }
                }

                Helper::listPagesAction($data, $id, $text.'--', $type='');
            }
        }

        return self::$result;
    }

    public static function arrCategoriesChild($id=0,$table) {
        $results = array();
        $data = \DB::table($table)->where('parent_id', $id)->get();

        if( count($data) >0 ){
            foreach ( $data as $category) {
                $results[$category->id] =  Helper::arrCategoriesChild( $category->id,$table );
            }
        }

        return  Helper::array_keys_multi($results);
    }

    public static function array_keys_multi(array $array){
        $keys = array();

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys = array_merge($keys, Helper::array_keys_multi($value));
            }

        }

        return $keys;
    }

    public static function arrCategoriesChild_v2($id,$table) {
        $results = array();
        $data = \DB::table($table)->where('parent_id', $id)->get();

        if( count($data) >0 ){
            foreach ( $data as $category) {
                $results[$category->id] =  Helper::arrCategoriesChild_v2( $category->id,$table );
            }
        }
        return  $results;
    }

    public static function arrCategoriesParent($id,$table) {
        $results = array();
        $data = \DB::table($table)->where('id', $id)->get();

        if( count($data) >0 ){
            foreach ( $data as $category) {
                $results[$category->id] =  Helper::arrCategoriesParent( $category->parent_id,$table );
            }
        }
        return  $results;
    }

    public static function listCatMenuClient($parent = 0, $menu, $first = 0) {
        if(!is_object($menu)) return;

        $out = '';
        $has_child = false;

        foreach ($menu as $m) {
          // if this menu item is a parent; create the sub-items/child-menu-items
          if ($m->parent_id == $parent) {// if this menu item is a parent; create the inner-items/child-menu-items
              // if this is the first child
              if ($has_child === false) {
                  $has_child = true;// This is a parent
                  if ($first == 0){
                    $out .= "<ul>";
                    $first = 1;
                  } else {
                    $out .= "<div class='c-dropdown-menu'><ul>";
                  }
              }
              // if menu item has children
            $active = '';
            // $title = $m->name_cat;
            // $link = $m->link;

            // if ($link != '') {
            //     if ($link == route('home')) {
            //     $title = '<i class="home"></i>';
            //     }
            // } else {
            //     $link = route($m->route, ['cat' => $m->slug]);
            // }

            // if ($m->children > 0) {
            //     $out .= '<li class="c-menu-child '.$active.'"><a href="'.$link.'">' . $m->name_cat;
            //     $out .= '<span class="c-submenu-btn fa fa-angle-down"></span>' .'</a>';
            // } else {
            //     $out .= '<li '.$active.'><a href="'.$link.'">' . $title .'</a>';
            // }

             if ($m->children > 0) {
                 // if (Request::is(Route::currentRouteName().'/*')) {
                 //        $active = 'active';
                 //     }

                $out .= '<li class="c-menu-child '.$active.'"><a href="javascript:void(0)">' . $m->name_cat;
                $out .= '<span class="c-submenu-btn fa fa-angle-down"></span>' .'</a>';
             } else {
                 $title = $m->name_cat;
                 $link = $m->link;

                 if ($link != '') {
                    //  if ($link== url()->current()) {
                    //     $active = 'class="current-menu-item"';
                    //  }

                     if ($link == route('home')) {
                        $title = '<i class="home"></i>';
                     }

                 } else {
                    //  if (route($m->route, ['cat' => $m->slug]) == url()->current()) {
                    //     $active = 'class="current-menu-item"';
                    //  }

                     $link = route($m->route, ['cat' => $m->slug]);
                 }

                $out .= '<li '.$active.'><a href="'.$link.'">' . $title .'</a>';
             }
              // call function again to generate nested list for sub-menu items belonging to this menu item.
              $out .= Helper::listCatMenuClient($m->id_tmp, $menu, $first);
              $out .= "</li>";
          }// end if parent

        }

        if ($has_child === true) {
          $out .= "</ul>";
        }

        return $out;
    }

    public static function pre($data) {
        echo '<pre>';
            print_r($data);
        echo '</pre>';

    }

    public static function send_mail($email, $content_mail, $title, $template) {
        $yandex = [
            'driver' => env('MAIL_DRIVER', 'smtp'),
            'host' => env('MAIL_HOST', 'smtp.yandex.ru'),
            'port' => env('MAIL_PORT', 465),
            'username' => env('MAIL_USERNAME', 'tohweb@tohsoft.com'),
            'password' => env('MAIL_PASSWORD', 'TOHweb@12345'),
            'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
        ];

        $yandex2 = [
            'driver' => env('MAIL_DRIVER', 'smtp'),
            'host' => env('MAIL_HOST', 'smtp.yandex.ru'),
            'port' => env('MAIL_PORT', 465),
            'username' => env('MAIL_USERNAME', 'tuantt@tohsoft.com'),
            'password' => env('MAIL_PASSWORD', 'thanhtuan@3230'),
            'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
        ];

        try {
            \Config::set('mail', $yandex);
            \Mail::send($template, $content_mail, function($message) use ($email, $title) {
                $message->from(env('MAIL_USERNAME', 'tohweb@tohsoft.com'), 'TOH');
                $message->to($email)->subject($title);
            });
        }catch(\Exception $e){}

        // try {
        //     \Config::set('mail', $yandex2);
        //     \Mail::send($template, $content_mail, function($message) use ($email, $title) {
        //         $message->from(env('MAIL_USERNAME', 'tuantt@tohsoft.com'), 'TOH');
        //         $message->to($email)->subject($title);
        //     });
        //     $send_done = true;
        // }catch(\Exception $e){}
    }

	public static function init_static_files($testing, $base_path, $version){
		if(!@file_exists($base_path.'public/frontend/assets/')){
			@mkdir($base_path.'public/frontend/assets/');
		}
		if($testing || !@file_exists($base_path.'public/frontend/assets/'.$version.'_main_style.css')){
            copy ($base_path.'public/frontend/css/style.css', $base_path.'public/frontend/assets/'.$version.'_main_style.css');
        }
    }

    public static function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    Helper::recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

	public static function get_server_list($type){
		$file_name = 'server_ok2.txt';
		$file_name_filter = 'server_ok2.txt';
		$base_path = base_path().'/storage/';
		$file_path = $base_path.$file_name;
		$file_path_filter = $base_path.$file_name_filter;
		if(@file_exists($file_path_filter) && $type === true){
			return json_decode(@file_get_contents($file_path_filter));
		}else if(@file_exists($file_path)){
			return json_decode(@file_get_contents($file_path));
		}else{
			$data = simplexml_load_file("https://www.speedtest.net/speedtest-servers-static.php");
			$list_server = [];
			foreach (current($data->servers) as $key => $value){
				$list_server[] = current($value->attributes());
			}
			$json_data = json_encode($list_server);
			@file_put_contents($file_path, $json_data);
			return $json_data;
		}
	}
}