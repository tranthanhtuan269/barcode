<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class Page extends Model{
    
    protected $table = "pages";
    protected $fillable = [
                            'title',
                            'content',
                            'slug',
                        ];

    public static function checkBarCode($barcode){
        return BarCode::where('barcode',$barcode)->count();
    }

    public static function delMulti($id_list) {
        $list = explode(",",$id_list);
        $item = Page::whereIn('id', $list);
        return ($item->delete() > 0);
    }

    public static function getAll() {
        return Page::get();
    }


    public static function updateMenu($id) {
        $data = Page::find($id);
        return Menu::where([ ['id_root', $id], ['name_table', (new static)->getTable()] ])->update(['name_cat' => $data->title, 'slug' => $data->slug] );
    }

}
