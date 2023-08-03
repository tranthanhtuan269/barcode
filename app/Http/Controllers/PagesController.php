<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SettingBarCode;
use App\Models\Article;
use App\Models\SettingBarCodeFree;
use Auth,Validator;
use App\ContactUs;



class PagesController extends Controller
{

    public function getPageList(){
        $data = Page::get();
        return view('layouts_backend.pages.index',['data'=>$data]);
    }
    
    public function getPageAdd(){
        return view('layouts_backend.pages.add');
    }

    public function postPageAdd(Request $request){
        try{
            $rules = [
                'title' =>'required',
            ];
            $messages = [
                'title.required' => 'Please fill the title field!',
                'content.required' => 'Please fill the content field',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $item = new Page;
                $item->title =  $request->title;
                $item->content =  $request->content;
                $item->slug =  str_slug($request->title,'-');
                $item->created_by =  Auth::user()->id;
                $item->created_at = date('Y-m-d H:i:s');
                $item->save();
                return back()->with(['flash_message_succ' => 'Create a new sub-page successfully']);
            }
        } catch (\Illuminate\Database\QueryException $ex){
            return $ex->getMessage(); 
        }
    }


    public function getPageEdit($id){
        $data = Page::where('id',$id)->first();
        return view('layouts_backend.pages.edit',['data'=>$data]);
    }
    

    //redirect to Edit Contact Us Page
    public function getContactUsPage(){
        $data = ContactUs::find(1);
        return view('layouts_backend.pages.contactUsEdit', ['data'=>$data]);
    }
    public function putContactUsPage(Request $request){
        try{    
            $rules = [
                'title' =>'required',
                'email' => 'required',
                'phone' => 'required'
            ];
            $messages = [
                'title.required' => 'Please fill the title field!',
                'content.required' => 'Please fill the content field',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $item = ContactUs::find(1);
                $item->title =  $request->title;
                $item->phone = $request->phone;
                $item->email = $request->email;
                $item->content =  $request->content;
                $item->updated_at = date('Y-m-d H:i:s');
                $item->save();
                return back()->with(['flash_message_succ' => 'Edit sub-page successfully']);
            }
        } catch (\Illuminate\Database\QueryException $ex){
            return $ex->getMessage(); 
        }
    }

    public function putPageEdit(Request $request){
        try{    
            $rules = [
                'title' =>'required',
            ];
            $messages = [
                'title.required' => 'Please fill the title field!',
                'content.required' => 'Please fill the content field',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $item = Page::find($request->id);
                $item->title =  $request->title;
                $item->content =  $request->content;
                $item->updated_by =  Auth::user()->id;
                $item->updated_at = date('Y-m-d H:i:s');
                $item->save();
                return back()->with(['flash_message_succ' => 'Edit sub-page successfully']);
            }
        } catch (\Illuminate\Database\QueryException $ex){
            return $ex->getMessage(); 
        }
    }

    public function deletePageDel($id){
        $item = Page::find($id);
        $item->delete($id);
        return back()->with(['flash_message_succ' =>'Delete successfully']);
    }

    public function getCategories($cat){
        $data = Page::where('slug',$cat)->first();
        return view('layouts_frontend.pages.index',['data'=>$data]);
    }

    public function getDetailPage($cat,$id,$slug)
    {
        if ($cat =='tin-tuc') {
            $new = News::where('id',$id)->first();
            return view('detail.news',['data'=>$new,'slug'=>$slug]);
        }elseif ($cat =='mobile') {
            $mobile = Products::where('id',$id)->first();
            if (empty($mobile)) {
                return view ('errors.503');
                } else {
                   return view ('detail.mobile',['data'=>$mobile,'slug'=>$slug]);
               }
        }elseif ($cat =='pc') {            
            $pc = Products::where('id',$id)->first();
            if (empty($pc)) {
                return redirect(route('index'), 301);
            } else {
                return view ('detail.pc',['data'=>$pc,'slug'=>$slug]);
            }
        }else {
            return redirect(route('index'), 301);
        }
    }

    public function getPricePage(){
        $priceABarcode = SettingBarCode::find(1)->value('price');
        $numberBarcodeFree = SettingBarCodeFree::find(1)->value('number');

        return view('layouts_frontend.pricing.index', ['priceABarcode' => $priceABarcode, 'numberBarcodeFree' => $numberBarcodeFree]);
    }

    public function getAppPage(){
        $page = Page::where('slug','app')->first(); 
        if($page) {
            return view('layouts_frontend.app',compact('page'));
        }else {
            return view('layouts_frontend.app');
        }
    }
    public function getAboutPage(){
        $page = Page::where('slug','app')->first(); 
        if ($page) {
            return view('layouts_frontend.about',compact('page'));
        }else {
            return view('layouts_frontend.about');
        }
    }

    public function getAddBarcodePage(){
        $page = Page::where('slug','add-barcode')->first();
        $mostViewArticles = \Cache::rememberForever('most_view_article_home', function () {
            return Article::select('title', 'slug', 'post_public_time', 'image', 'id','count_view','rate')->where('status', 1)->orderBy('count_view', 'desc')->take(9)->get();
        });
        if ($page) {
            return view('layouts_frontend.addbarcode.index',compact('page','mostViewArticles'));
        }else {
            return view('layouts_frontend.addbarcode.index',compact('mostViewArticles'));
        }
    }


}
