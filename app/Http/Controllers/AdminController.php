<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Http\Requests\SaveMenuRequest;
use App\Http\Requests\UpdateSiteConfigRequest;
use App\Http\Requests\BackendLogin;
use App\Http\Requests\BackendSlideRequest;
use App\Http\Requests\BackendUpdateConfigHome;
use App\Http\Requests\BackendUpdateConfigSeo;
use App\Helpers\Helper;
use App\Models\SiteConfig;
use App\Models\Page;
use App\Models\PostCategory;
use App\Models\ArticleCategory;
use App\Models\Menu;
use App\Models\Package;
use App\Models\User;
use Auth;
use Validator;
use Cache;
use App\Models\Article;

class AdminController extends Controller {

    public function locationIndex(Request $request){
        return view('backend.config.location');
    }

    public function locationDataAjax(Request $request){
        $package = Package::select('name', 'intro', 'price', 'count_month')->get();
        // dd($page);
        return datatables()->of($package)
                ->addColumn('action', function ($package) {
                    return $package->id;
                })
                ->addColumn('rows', function ($package) {
                    return $package->id;
                })
                ->removeColumn('id')->make(true);
    }

    public function getLoginAdmin(){
    	if(Auth::check()){
	        return redirect('admincp');
	    }else{
            Auth::logout();
        	return view('backend.login.index');
        }
    }

    public function loginAdmin( BackendLogin $request ){
        $email = trim($request->email);
        $password = trim($request->password);

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->remember)) {
            session_start();
            $_SESSION['admin_upload_file'] = 1;
            return response()->json(['message' => 'Ok', 'status' => 200]);
        } else {
            return response()->json(['message' => 'The email or password is incorrect', 'status' => 404]);
        }
    }

    public function getLogoutAdmin(){
        Auth::logout();
        session_start();
        unset($_SESSION['admin_upload_file']);
        return redirect()->route('login-admin');
    }

    public function getAdminCp(){
        return view('backend.dashboard');
    }

    public function slide() {
        $listSlides = SiteConfig::where('key', '=', 'slide')->first();
        $listSlides = json_decode($listSlides->value, false);
        // dd($listSlides);die;
        return view('backend.config.slide', compact('listSlides'));
    }

    public function addSlide(BackendSlideRequest $request){
        $slide = SiteConfig::where('key', '=', 'slide')->value('value');
        $image = $request->image;
        $image = explode("/filemanager/data-images/", $image);

        if ($slide != '[]') {
            $arr_list_slide = json_decode($slide, true);
            array_unshift($arr_list_slide, ['image' => $image[1], 'link' => $request->link]);
            SiteConfig::updateRecord('slide', json_encode($arr_list_slide));
        } else {
            SiteConfig::updateRecord('slide', json_encode([['image' => $image[1], 'link' => $request->link]]));
        }

        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function editSlide(BackendSlideRequest $request){

        $slide = SiteConfig::where('key', '=', 'slide')->value('value');
        $image = $request->image;
        $image = explode("/filemanager/data-images/", $image);
        $image = trim($image[1]);

        if ($slide != '') {
            $arr_list_slide = json_decode($slide, true);
            $arr_list_slide [$request->id] = ['image' => $image, 'link' => $request->link];
            SiteConfig::updateRecord('slide', 0, json_encode($arr_list_slide));
        }

        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function updateSlide(UpdateSiteConfigRequest $request) {
        SiteConfig::where('key', '=', 'logo')->update(['value' => $request->logo]);
        SiteConfig::where('key', '=', 'email')->update(['value' => $request->email]);
        SiteConfig::where('key', '=', 'email_comment')->update(['value' => $request->email_comment]);
        SiteConfig::where('key', '=', 'keywords_not_good')->update(['value' => $request->keywords_not_good]);
        SiteConfig::where('key', '=', 'address')->update(['value' => $request->address]);
        SiteConfig::where('key', '=', 'phone')->update(['value' => $request->phone]);
        SiteConfig::where('key', '=', 'phone_2')->update(['value' => $request->phone_2]);
        SiteConfig::where('key', '=', 'facebook')->update(['value' => $request->facebook]);
        SiteConfig::where('key', '=', 'youtube')->update(['value' => $request->youtube]);
        SiteConfig::where('key', '=', 'instagram')->update(['value' => $request->instagram]);
        SiteConfig::where('key', '=', 'youtube')->update(['value' => $request->youtube]);
		SiteConfig::where('key', '=', 'lat')->update(['value' => $request->lat]);
        SiteConfig::where('key', '=', 'lng')->update(['value' => $request->lng]);
        Helper::clearCache();
		return back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công!']);
    }

    public function setupMenu(Request $request) {
        $language_id = ($request->language_id != '') ? $request->language_id : 'en';

        $myfunc =  new Helper();
        // $list_page = Page::where('language', $language_id)->get();
        $list_page = [];

        $myfunc_2 =  new Helper();
        $list_article_cat = ArticleCategory::where('language', $language_id)->get();
        $list_article_cat =  $myfunc_2->callProcessSelectReal($list_article_cat,0,'',0);

        $myfunc_3 =  new Helper();
        $list_article = Article::where('language', $language_id)->get();
        $list_article =  $myfunc_3->callProcessSelectReal($list_article,0,'',0);
        return view('backend.config.menu', compact('list_page', 'list_article_cat', 'list_article'));
    }

    public function saveMenu(Request $request){
        $item = SiteConfig::where('key', '=', $request->key)->first();
        $item->value = $request->value;
        $item->save();

        Helper::clearCache();

        return \Response::json(array('status' => '200', 'message' => 'Lưu thông tin thành công!'));
    }

    public function showMenuAjax(Request $request){
        $dataCate = Menu::where('id_menu', $request->id)->where('language', $request->language_id)->orderBy('id', 'desc')->get();
        // dd($dataCate);
        $myfunc =  new Helper();
        return $myfunc->listCatMenu($dataCate,0,'',0);
    }

    public function setupMenuAjax(Request $request){
        Menu::where('id_menu', $request->id_menu)->where('language', $request->language_id)->delete();
        $data =  json_decode(json_encode(json_decode($request->list)), true);
        $data = array_reverse($data);
        Menu::insert($data);

        Helper::clearCache();

        return \Response::json(array('status' => '200', 'Message' => 'Lưu thông tin thành công!'));
    }
    public function showMenuPostArticleAjax(Request $request){
        return ArticleCategory::where('language', $request->language)->get();
    }

  //   public function updateConfigHome(BackendUpdateConfigHome $request) {
  //       // $logo = $request->logo;

  //       // if ($logo != '') {
  //       //     $logo = explode("/filemanager/data-images/", $logo);
  //       //     SiteConfig::updateRecord('logo', $logo[1]);
  //       // }


  //       // echo $request->facebook;die;
  //       // SiteConfig::updateRecord('slogan', $request->slogan);
  //       // SiteConfig::updateRecord('phone_1', $request->phone_1);
  //       // SiteConfig::updateRecord('phone_2', $request->phone_2);
  //       SiteConfig::updateRecord('facebook', $request->facebook);
  //       // SiteConfig::updateRecord('youtube', $request->youtube);
  //       SiteConfig::updateRecord('instagram', $request->instagram);
  //       SiteConfig::updateRecord('twitter', $request->twitter);
  //       SiteConfig::updateRecord('youtube', $request->youtube);
  //       SiteConfig::updateRecord('number_request_free', $request->number_request_free);

		// SiteConfig::updateRecord('phone', $request->phone);
		// SiteConfig::updateRecord('address', $request->address);
		// SiteConfig::updateRecord('email', $request->email);
		// SiteConfig::updateRecord('copyright_text', $request->copyright_text);
		// SiteConfig::updateRecord('apple_store_link', $request->apple_store_link);
  //       SiteConfig::updateRecord('google_play_link', $request->google_play_link);
  //       SiteConfig::updateRecord('google_extension_link', $request->google_extension_link);
		// SiteConfig::updateRecord('firefox_extension_link', $request->firefox_extension_link);

  //       // SiteConfig::updateRecord('code_google_anaylytics', $request->code_google_anaylytics);
  //       // SiteConfig::updateRecord('email', $request->email);
		// Cache::flush();
  //       return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
  //   }

    public function updateConfigHome(BackendUpdateConfigHome $request) {
        $language_id = $request->language_id;
        $language_id_0 = 0;
        $logo = $request->logo;

        if ($logo != '') {
            $logo = explode("/filemanager/data-images/", $logo);
            SiteConfig::updateRecord('logo', $language_id_0, $logo[1]);
        }
        SiteConfig::updateRecord('email', $language_id_0, $request->email);
        SiteConfig::updateRecord('email_comment', $language_id_0, $request->email_comment);
        SiteConfig::updateRecord('keywords_not_good', $language_id_0, $request->keywords_not_good);
        SiteConfig::updateRecord('phone', $language_id_0, $request->phone);
        SiteConfig::updateRecord('facebook', $language_id_0, $request->facebook);
        SiteConfig::updateRecord('youtube', $language_id_0, $request->youtube);
        SiteConfig::updateRecord('instagram', $language_id_0, $request->instagram);
        SiteConfig::updateRecord('twitter', $language_id_0, $request->twitter);
        SiteConfig::updateRecord('linkedIn', $language_id_0, $request->linkedIn);
        SiteConfig::updateRecord('pinterest', $language_id_0, $request->pinterest);
        SiteConfig::updateRecord('copyright_text', $language_id_0, $request->copyright_text);
        SiteConfig::updateRecord('apple_store_link', $language_id_0, $request->apple_store_link);
        SiteConfig::updateRecord('google_play_link', $language_id_0, $request->google_play_link);
        Helper::clearCache();
        Cache::flush();
        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function updateConfigSeo(BackendUpdateConfigSeo $request) {
        $language_id = $request->language_id;

        $data = SiteConfig::getValue($language_id);

        if (count($data) > 0) {
            SiteConfig::updateRecord('keywords', $language_id, $request->keywords);
            SiteConfig::updateRecord('seo_title', $language_id, $request->seo_title);
            SiteConfig::updateRecord('seo_description', $language_id, $request->seo_description);
        } else {
            $arr = [
                [
                    'key' => 'keywords',
                    'value' => $request->keywords,
                    'language' => $language_id,
                ],
                [
                    'key' => 'seo_title',
                    'value' => $request->seo_title,
                    'language' => $language_id,
                ],
                [
                    'key' => 'seo_description',
                    'value' => $request->seo_description,
                    'language' => $language_id,
                ],
            ];
            // dd($arr);
            SiteConfig::insert($arr);
        }
        Helper::clearCache();
        return response()->json(['message' => 'Lưu thông tin thành công!', 'status' => 200]);
    }

    public function editInfo() {
        $data         = SiteConfig::getValue('en');
        $data_general = SiteConfig::getValue(0);
        return view('backend.config.general', compact('data', 'data_general'));
    }

    public function infoConfigByLang (Request $request)
    {
        $data         = SiteConfig::getValue($request->language_id);
        $data_general = SiteConfig::getValue(0);
        return response()->json(['status' => 200, 'data' => $data, 'data_general' => $data_general]);
    }

    public function ads(Request $request) {
        $banner_top_status = SiteConfig::where('key', '=', 'banner_top_status')->value('value');
        $banner_mid_status = SiteConfig::where('key', '=', 'banner_mid_status')->value('value');
        $banner_bottom_status = SiteConfig::where('key', '=', 'banner_bottom_status')->value('value');
        $banner_fixed_right_status = SiteConfig::where('key', '=', 'banner_fixed_right_status')->value('value');
        return view('backend.config.ads', compact('banner_top_status', 'banner_mid_status', 'banner_bottom_status', 'banner_fixed_right_status'));
    }

    public function postAds(Request $request) {
        SiteConfig::where('key', '=', 'banner_top_status')->update(['value' => $request->banner_top_status]);
        SiteConfig::where('key', '=', 'banner_mid_status')->update(['value' => $request->banner_mid_status]);
        SiteConfig::where('key', '=', 'banner_bottom_status')->update(['value' => $request->banner_bottom_status]);
        SiteConfig::where('key', '=', 'banner_fixed_right_status')->update(['value' => $request->banner_fixed_right_status]);

        $res = array('status'=>"200","Message"=>"The config has been successfully updated!");
        Cache::forget('cache_config_ads');
        return response()->json($res);
    }
}
