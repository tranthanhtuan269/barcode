<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;
use Auth;
use App\Models\SettingBarCodeFree;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getIsAdminAttribute()
    {
        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles () {
        return $this->belongsTo('App\Models\Roles','role_id');
    }

    public static function getUserList( $request ){
       return DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.name','users.email','users.id','roles.roles_name','users.status')
            // ->where('users.status',1)
            ->where(function ($query) use ($request){
                if ($request->name != '') {
                    $query->where('users.name', '=',$request->name);
                }     
                if ($request->email != '') {
                    $query->where('users.email', '=',$request->email);
                }     
            })
            // ->orderBy('users.id', 'desc')
            ->orderBy('users.id', 'asc')
            ->paginate(10);
   }

    public static function updateUser($arr,$id){
        return DB::table('users')
                ->where('id', '=', $id)
                ->update($arr);
   }

    public static function getNewsList($arr,$id){
        return DB::table('news')->get();
   }

    public static function checkResetCode($code){
        $data = User::where('reset_code',$code)->value('reset_code_time');
   }

    public static function checkAccount($code,$email){
        $reset_code_time = User::where([
                                ['reset_code', $code],
                                ['email', $email],
                        ])->value('reset_code_time');

        if($reset_code_time){
            $timeFirst  = strtotime($reset_code_time);
            $timeSecond = strtotime(date('Y-m-d H:i:s'));
            $differenceInSeconds = $timeSecond - $timeFirst;
            return ( $differenceInSeconds <= 1800 )?TRUE:FALSE;
        }else{
            return FALSE;
        }
    }

    public static function checkBarCodebyUser($number=''){
        $barCodeStatus = SettingBarCodeFree::where('id', 2)->value('number');
        if($barCodeStatus == 0) return TRUE;
        if( !empty($number) ){
            return ( Auth::user()->number_barcode > $number )?TRUE:FALSE;
        }else{
            return ( Auth::user()->number_barcode > 0 )?TRUE:FALSE;
        }
    }

    public static function getNumberBarcode(){
        if(SettingBarCodeFree::where('id', 2)->value('number') == 0){
            return 1000000;  
        }else {
            return Auth::user()->number_barcode;
        }
    }

    public static function activeUser($id, $status){
        $statusActive = ($status == 'unactive') ? 0 : 1;
        return DB::table('users')
                ->where('id', '=', $id)
                ->update(['status' => $statusActive]);
    }
}
