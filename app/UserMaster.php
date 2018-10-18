<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMaster extends Model
{
    protected $table = 'users';
    public $timestamps = false;


    public
    function scopegetUserDropdown()
    {
        $roles = UserMaster::where(['is_active' => '1'])->get(['id', 'name', 'contact']);
        $arr[0] = "SELECT";
        foreach ($roles as $role) {
            $arr[$role->id] = $role->name . "-" . $role->contact;
        }
        return $arr;
    }

    public function scopeGetActiveUserMaster($query)
    {
        return $query->where('is_active', '=', 1)->get();
    }

    public function scopeGetPaidUserMaster($query)
    {
        return $query->where('is_paid', '=', 1)->get();
    }

    public function scopeGetUnPaidUserMaster($query)
    {
        return $query->where('is_paid', '=', 0)->get();
    }

    public function city_name()
    {
        return $this->belongsTo('App\CityModel', 'city_id');
    }

    public function activate_by()
    {
        return $this->belongsTo('App\AdminModel', 'activated_by');
    }

    public static function checkcontact($c)
    {
        $user = UserMaster::where(['contact' => $c])->first();
        if (is_null($user)) return true;
        else return false;
    }

    public static function checkemail($c)
    {
        $user = UserMaster::where(['email' => $c])->first();
        return (is_null($user)) ? true : false;
    }
}
