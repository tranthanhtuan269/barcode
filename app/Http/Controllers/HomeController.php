<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\News;
use App\Models\Article;
use App\Models\Contact;

class HomeController extends Controller
{ 
    public function tuantt(Request $request){
        $rules = array(
            'hao' => 'checkJson',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
        }
        dd(1);
    }
    public function getIndex(Request $request){
    	$route_arr = $request->route_arr;
    	return view('layouts_backend.dashboard',['route_arr'=>$route_arr]);
    }

    public function templateShareSocial(){
        return view('layouts_frontend.share_modal')->render();
    }

    public function postContact(Request $request) {
        $rules = [
            'username'          => 'required|max:255',
            'email'             => 'required|email',
            'comment'       => 'required',
        ];

        $messages = [];

        $validator = \Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag(), 'status' => 404]);
        }else{
            $contact =  new Contact;
            $contact->name            = $request->username;
            $contact->email            = $request->email;
            $contact->question     = $request->comment;
            $contact->save();

            return response()->json(['message' => ('send_contact_succes'), 'status' => 200]);
        }
    }
}
