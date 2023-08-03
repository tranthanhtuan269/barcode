<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aff;
use App\Models\Request as TOHRequest;

class AffController extends Controller {

  public function __construct() {
    // $this->middleware('auth');
  }
  
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
      $keyword = $request->get('search');
      if (!empty($keyword)) {
        $affs = Aff::where('slug', 'LIKE', "%$keyword%")
          ->orWhere('name', 'LIKE', "%$keyword%")
          ->orderBy('id', 'DESC')
          ->paginate(config('batv_config.number_page'));
      } else {
        $affs = Aff::orderBy('id', 'DESC')->paginate(config('batv_config.number_page'));
      }
      return view('backend.aff.index', compact('affs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.aff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
      $item = new Aff;
      $item->slug =  $request->slug;
      $item->name =  $request->name;
      $item->save();

      $res=array('status'=>"200","Message"=>"The Aff has been successfully created!");
      echo json_encode($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
      $data = Aff::find($id);
      return view('backend.aff.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
      $item = Aff::find($id);
      $item->slug =  $request->slug;
      $item->name =  $request->name;
      $item->save();

      $res=array('status'=>"200","Message"=>"The Aff has been successfully updated!");
      echo json_encode($res);
    }

    public function show($id)
    {
      $requests = TOHRequest::where('aff_id', $id)->orderBy('id', 'DESC')->paginate(config('batv_config.number_page'));
      return view('backend.aff.admin', compact('requests'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
      Aff::destroy($id);
      return back()->with(['flash_message_succ' => 'The Aff has been successfully delete!']);
    }

}