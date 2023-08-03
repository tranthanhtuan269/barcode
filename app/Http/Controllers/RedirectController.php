<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRedirectRequest;
use App\Http\Requests\UpdateRedirectRequest;
use Auth;
use Cache;

class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::orderBy('id','desc')->paginate(20);
        return view('backend.redirect.index', compact('redirects'));
    }

    public function store(StoreRedirectRequest $request)
    {
        $item = new Redirect();
        $item->link_old =  $request->link_old;
        $item->link_new =  $request->link_new;
        $item->save();

        return response()->json(['status' => 200]);
    }

    public function update(UpdateRedirectRequest $request, $id)
    {
        $item = Redirect::find($id);
        $item->link_old =  $request->link_old;
        $item->link_new =  $request->link_new;
        $item->save();

        return response()->json(['status' => 200]);
    }

    public function destroy($id)
    {
        Redirect::destroy($id);
        return response()->json(['status' => 200]); 
    }

    public function getDataAjax(Request $request)
    {
        $redirects =  \DB::table('redirects');
        return datatables()->of($redirects)->make(true);
    }
}
