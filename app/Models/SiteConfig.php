<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\BatvHelper;
use App\Config;
class SiteConfig extends Model{
    
    protected $table = 'site_config';
	public $timestamps = false;
    protected $fillable = ['key', 'value'];

	public static function updateRecord($key, $language_id, $value) {
		return SiteConfig::where('key', '=', $key)->where('language', $language_id)->update(['value' => $value]);
    }

    public static function getValue($language_id) {
		return SiteConfig::where('language', $language_id)->pluck('value', 'key');
	}
    
}