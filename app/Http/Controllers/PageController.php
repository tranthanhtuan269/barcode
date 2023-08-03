<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Validator;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\Tag;
use App\Models\PageTag;
use App\Models\ArticleTag;

class PageController extends Controller
{
    public function demo(Request $request){
        return view('frontend.demo');
    }

    public function filterAjax(Request $request){
        $filter;
        $dateDelete;
        $download=0;
        $upload=0;
        $bestDownload=0;
        $bestUpload=0;
        $totalResult=0;
        $arrayDownload = [];
        $arrayUpload = [];
        $time = $request->time;
        
        $timeFirst = 0;
        $timeEnd;
        $createdAt=[];
        if ($time){
            $timeFirst = strtotime(str_replace("/", "-", $request->time));
            $timeEnd = strtotime("+1 day", $timeFirst);
        }
        $query =  \DB::table('gauge_logs')->where('user_id', $_COOKIE['user_id']);
        if($request->time != ''){
            $query->where([['created_at', '>', $timeFirst], ['created_at', '<', $timeEnd]]);
        }
        if($request->ip != ''){
            $query->where( 'ip', $request->ip);
        }
        if($request->sponsor != ''){
            $query->where('sponsor', $request->sponsor);
        }
        $filter = $query->get();
        // dd($filter);
        if(count($filter)>0){
            $hosts = $query->groupBy('sponsor')->get();
            $hosts = count($hosts);
            foreach ($filter as $key => $value) {
                array_push($arrayDownload, $value->download);
                array_push($createdAt, $value->created_at);
            }
            foreach ($filter as $key => $value) {
                array_push($arrayUpload, $value->upload);
            }
            $bestDownload = max($arrayDownload);
            $bestUpload = max($arrayUpload);
            $totalResult = count($filter);
            $timeFirst = $filter[0]->created_at;
            return response()->json(['createdAt'=>$createdAt, 'timeFirst'=>$timeFirst, 'hosts'=>$hosts, 'totalResult'=>$totalResult, 'bestDownload'=>$bestDownload, 'bestUpload'=>$bestUpload, 'filter'=>$filter, 'arrayDownload'=>$arrayDownload, 'arrayUpload'=>$arrayUpload, 'status' => 200]);
        }
        else{
            $dateDelete = \DB::table('gauge_logs')->where('user_id', $_COOKIE['user_id'])->get();
            return response()->json(['dateDelete'=>$dateDelete, 'status' => 201]);
        }
    }

    public function deleteHistory(Request $request){
        $id = GaugeLogs::find($request->id);
        if( $id ){
            $id->delete();
            return \Response::json(['status' => 200]); 
        }
        return \Response::json(['status' => 404]);
    }

    public function resultUploadAjax(Request $request){
        $arrayUpload = [];
        $recharge_history = GaugeLogs::where('user_id', $_COOKIE['user_id'])->get();
        foreach ($recharge_history as $key => $value) {
            array_push($arrayUpload, $value->upload);
        }
        return response()->json(['arrayUpload'=>$arrayUpload, 'status' => 200]);
    }

    public function resultDownloadAjax(Request $request){
        $arrayDownload = [];
        $recharge_history = GaugeLogs::where('user_id', $_COOKIE['user_id'])->get();
        foreach ($recharge_history as $key => $value) {
            array_push($arrayDownload, $value->download);
        }
        return response()->json(['arrayDownload'=>$arrayDownload, 'status' => 200]);
    }
    
    public function index()
    {
        $datas = Page::all();
        return view('backend.pages.index',compact('datas'));
    }

    public function create()
    {
        return view('backend.pages.form');
    }

    public function store(StorePageRequest $request)
    { 
        $user_id = Auth::id();
        $date_current = date('Y-m-d H:i:s');

        $item                   = new Page;
        $item->title            = $request->title;
        $item->language          = 'en';
        $item->slug             = $request->slug;
        $item->content          = $request->content;
        $item->status           = $request->status;
        $item->seo_title        = $request->seo_title;
        $item->keywords         = $request->keywords;
        $item->seo_description  = $request->seo_description;
        $item->seo_indexed      = $request->seo_indexed;
        $item->created_by       = $user_id;
        $item->updated_by       = $user_id;
        $item->created_at       = $date_current;
        $item->description      = $request->description;
        $item->save();
        $item->page_lang_id            = $item->id;
        $item->save();

        $tags = $request->page_tag;
        
        if (!empty($tags)) {
            $tag_slug = [];
            $page_tag_arr = [];
            foreach ($tags as $key => $tag) {
                $tag = trim($tag);
                $tag_slug[$key] = Str::slug($tag, '-');
                if ( isset(Tag::where('slug', $tag_slug[$key])->first()->id) ){
                    if ( !isset(ArticleTag::where( 'tag_id', Tag::where('slug', $tag_slug[$key])->first()->id )->where('page_id', $item->id)->first()->id) ){
                        $page_tag = new ArticleTag;
                        $page_tag->page_id = $item->id;
                        $page_tag->tag_id = Tag::where('slug', $tag_slug[$key])->first()->id;
                        $page_tag->save();
                        $page_tag_arr[$key] = $page_tag->tag_id;
                    }
                }else{
                    $new_tag = new Tag;
                    $new_tag->name = $tag;
                    $new_tag->slug = $tag_slug[$key];
                    $new_tag->save();
    
                    $page_tag = new ArticleTag;
                    $page_tag->page_id = $item->id;
                    $page_tag->tag_id = $new_tag->id;
                    $page_tag->save();
                    $page_tag_arr[$key] = $new_tag->id;
                }
            }
        }

        return response()->json(['message' => 'Thêm mới thông tin thành công!', 'status' => 200]);
    }

    public function edit(Request $request, $id)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $data = Page::leftJoin('page_tag', 'page_tag.page_id', '=', 'pages.id')
                        ->leftJoin('tags', 'tags.id', '=', 'page_tag.tag_id')
                        ->selectRaw('GROUP_CONCAT(DISTINCT tags.name) as list_tags,pages.*')
                        ->where('pages.page_lang_id', $id)
                        ->where('pages.language', $language)
                        ->groupBy('pages.id')
                        ->first();


        return view('backend.pages.form', compact('data'));
        // if ($id == 1) { // CƠ HỘI NGHỀ NGHIỆP
        //     return view('backend.pages.form-recruitment', compact('data'));
        // } else if ($id == 3) { // CUỘC SỐNG TẠI TOHSOFT
        //     return view('backend.pages.form-life', compact('data'));
        // }
    }

    public function update(Request $request, $id)
    {
        $language = ($request->language != '') ? $request->language : 'en';
        $data = Page::where('language', $language)->where('page_lang_id', $id)->first();
        $user_id = \Auth::id();
        $date_current = date('Y-m-d H:i:s');
        if ($data) { //UPDATE
            $rules = [
                // 'title'          => 'required|max:255|unique:pages,title,'.$data->id,
                // 'slug'          => 'required|max:255|unique:pages,slug,'.$data->id,
            ];
            $messages = [];  
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]); 
            } else {
                $item               = Page::find($data->id);
                $item->title          = $request->title;
                $item->slug          = $request->slug;
                $item->content          = $request->content;
                $item->description       = $request->description;
                $item->status           = $request->status;
                $item->seo_title        = $request->seo_title;
                $item->keywords    = $request->keywords;
                $item->seo_description  = $request->seo_description;
                $item->seo_indexed      = $request->seo_indexed;
                $item->updated_by =  $user_id;
                $item->updated_at = $date_current;
            }
        } else {
            $rules = [
                // 'title'          => 'required|max:255|unique:pages,title',
                // 'slug'          => 'required|max:255|unique:pages,slug',
            ];
            $messages = [];  
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->toArray(), 'status' => 404]); 
            } else {
                $item                   = new Page;
                $item->title          = $request->title;
                $item->slug          = $request->slug;
                $item->language         = $request->language;
                $item->content          = $request->content;
                $item->description       = $request->description;
                $item->status           = $request->status;
                $item->seo_title        = $request->seo_title;
                $item->keywords    = $request->keywords;
                $item->seo_description  = $request->seo_description;
                $item->seo_indexed      = $request->seo_indexed;
                $item->created_by       = $user_id;
                $item->updated_by       = $user_id;
                $item->created_at       = $date_current;
                $item->page_lang_id = Page::where('language', 'en')->where('page_lang_id', $id)->value('page_lang_id');
            }
        }
        $item->save();

        $tags = $request->page_tag;
        PageTag::where('page_tag.page_id', $id)->delete();
        if (!empty($tags)) {
            // dd($tags);
            $tag_slug = [];
            $page_tag_arr = [];
            // dd($request->page_tag);
            foreach ($tags as $key => $tag) {
                $tag = trim($tag);
                $tag_slug[$key] = Str::slug($tag, '-');
    
                if ( isset(Tag::where('slug', $tag_slug[$key])->first()->id) ){
                    if ( !isset(PageTag::where( 'tag_id', Tag::where('slug', $tag_slug[$key])->first()->id )->where('page_id', $id)->first()->id) ){
                        $page_tag = new PageTag;
                        $page_tag->page_id = $item->id;
                        $page_tag->tag_id = Tag::where('slug', $tag_slug[$key])->first()->id;
                        $page_tag->save();
                        $page_tag_arr[$key] = $page_tag->tag_id;
                    }
                }else{
                    $new_tag = new Tag;
                    $new_tag->name = $tag;
                    $new_tag->slug = $tag_slug[$key];
                    $new_tag->save();
                    
                    $page_tag = new PageTag;
                    $page_tag->page_id = $item->id;
                    $page_tag->tag_id = $new_tag->id;
                    $page_tag->save();
                    $page_tag_arr[$key] = $new_tag->id;
                }
            }
        } 

        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]); 
    }

    public function destroy($id)
    {
        $item = Page::find($id);
        $item->delete($id);
        $res=array('status'=>200,"Message"=>"Xóa thông tin thành công");
        echo json_encode($res);        
    }

    public function delMulti(Request $request){
        if(isset($request) && $request->input('id_list')){
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if(Page::delMulti($id_list)){
                $res=array('status'=>200,"Message"=>"Đã xóa lựa chọn thành công");
            }else{
                $res=array('status'=>"204","Message"=>"Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function getDataAjax(Request $request) {
        $pages = Page::getDataForDatatable($request);
        return datatables()->of($pages)
                ->addColumn('action', function ($page) {
                    return $page->id;
                })
                ->addColumn('rows', function ($page) {
                    return $page->id;
                })
                ->removeColumn('id')->make(true);
    }

    public function getPrivacy()
    {
        $data_seo = Page::where('page_lang_id', 28)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed', 'updated_at']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 28)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed', 'updated_at']);
        }

        return view('frontend.layouts.page.privacy', compact('data_seo'));
    }
    public function getAbout(){
        $data_seo = Page::where('page_lang_id', 3)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 3)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);
        }

        return view('frontend.layouts.page.about', compact('data_seo'));
    }
    public function websiteTest(){
        $data_seo = Page::where('page_lang_id', 2)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 2)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);
        }

		$tags = Tag::leftJoin('page_tag', 'page_tag.tag_id', '=', 'tags.id')
					->leftJoin('pages', 'pages.id', '=', 'page_tag.page_id')
					->select('tags.*')
					->where('pages.slug', 'website-test')
					->get();
        return view('frontend.layouts.page.website-test', compact('data_seo', 'tags'));
    }

    public function extensions(Request $request){
        $data_seo = Page::where('page_lang_id', 1)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 1)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);
        }

        return view('frontend.layouts.page.extensions', compact('data_seo'));
    }

    public function mobileApps(){
        $data_seo = Page::where('page_lang_id', 4)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 4)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);
        }
        
        return view('frontend.layouts.page.mobileapps', compact('data_seo'));
    }

    public function developers(){
        $data_seo = Page::where('page_lang_id', 5)->where('language', $this->global_language)->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);

        if (!$data_seo) {
            $data_seo = Page::where('page_lang_id', 5)->where('language', 'en')->first(['seo_title', 'seo_description', 'keywords', 'language', 'seo_indexed']);
        }
        
        return view('frontend.layouts.page.developers', compact('data_seo'));
    }

    public function result(Request $request){
        $bestDownload=0;
        $bestUpload=0;
        $download=0;
        $upload=0;
        $hosts = 0;
        $sponsor;
        $firstTime = 0;
        $arrayDownload = [];
        $arrayUpload = [];
        $totalResult=0;
        $createdAt=[];
        if(isset($_COOKIE['user_id'])){
            $userId = $_COOKIE['user_id'];
            $recharge_history = GaugeLogs::where('user_id', $userId)->get();
            // dd($recharge_history);
            if(count($recharge_history)>0){
                foreach ($recharge_history as $key => $value) {
                    array_push($arrayDownload, $value->download);
                    array_push($createdAt, $value->created_at);
                }
                foreach ($recharge_history as $key => $value) {
                    array_push($arrayUpload, $value->upload);
                }
                $bestDownload = max($arrayDownload);
                $bestUpload = max($arrayUpload);
                $ip = GaugeLogs::where('user_id', $userId)
                            ->groupBy('ip')
                            ->get();
                $hostName = GaugeLogs::where('user_id', $userId)
                        ->groupBy('host_name')
                        ->get();
                $sponsor = GaugeLogs::where('user_id', $userId)
                ->groupBy('sponsor')
                ->get();
                $hosts = count($sponsor);
                $totalResult = count($recharge_history);
                $firstTime = $recharge_history[0]->created_at;
                return view('frontend.layouts.page.result', compact('bestDownload', 'bestUpload', 'arrayDownload', 'recharge_history', 'hosts', 'firstTime', 'totalResult', 'ip', 'sponsor', 'createdAt'));
            }
            else{
                return view('frontend.layouts.page.result-zero');
            }
        }
        else{
            return view('frontend.layouts.page.result-zero');
        }
    }
    
    public function pageMobileApp(Request $request) {
        $language = 'en';

        if ($request->language != '') {
            $language = $request->language;
        }

        $data = PageMobileApp::where('language', $language)->first();
        // dd($data);
        return view('backend.pages.pageMobileApp', compact('data'));
    }

        public function getGaugeLogs(Request $request)
    {
        if (isset($_COOKIE['user_id'])) {
            $time = $request['time'];
            $timeFirst;
            $timeEnd;
            if ($time != '') {
                if(isset($_COOKIE['cookie_common_unit-date-layout'])) {
                    if($_COOKIE['cookie_common_unit-date-layout'] == "mm/dd/yyyy"){
                        $time = date("Y-m-d", strtotime($time));
                        $timeFirst = strtotime(str_replace("/", "-", $time));
                        $timeEnd = strtotime("+1 day", $timeFirst);
                    } else{
                        $timeFirst = strtotime(str_replace("/", "-", $request->time));
                        $timeEnd = strtotime("+1 day", $timeFirst);
                    }
                } else {
                    $time = date("Y-m-d", strtotime($time));
                    $timeFirst = strtotime(str_replace("/", "-", $time));
                    $timeEnd = strtotime("+1 day", $timeFirst);
                }
            }
            $ip = $request['ip'];
            $sponsor = $request['sponsor'];
            $query =  \DB::table('gauge_logs')->selectRaw('*')->where('user_id', $_COOKIE['user_id']);

            if ($time != '') {
                $query->where([['created_at', '>', $timeFirst], ['created_at', '<', $timeEnd]]);
            } 

            if ($ip != '') {
                $query->where( 'ip', $ip);
            } 

            if ($sponsor != '') {
                $query->where('sponsor', $sponsor);
            }
            return datatables()->of($query)
                    ->addColumn('action', function ($query) {
                        return $query->id;
                    })
                    ->addColumn('rows', function ($query) {
                        return $query->id;
                    })
                    ->removeColumn('id')->make(true);
        }
    }
}
