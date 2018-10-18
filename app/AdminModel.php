<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class AdminModel extends Model
{
    protected $table = 'admin_master';
    public $timestamps = false;

    public static function checkUsername($username)
    {
        $user = AdminModel::where(['is_active' => 1, 'username' => $username])->first();
        if (is_null($user)) return true;
        else return false;
    }

    public
    function scopegetFranchiseDropdown()
    {
        $roles = AdminModel::where(['is_active' => '1'])->where('id', '>', 1)->get(['id', 'name','contact']);
        $arr[0] = "SELECT";
        foreach ($roles as $role) {
            $arr[$role->id] = $role->name."-".$role->contact;
        }
        return $arr;
    }

    public
    function scopegetAllDropdown()
    {
        $roles = AdminModel::where(['is_active' => '1'])->get(['id', 'name']);
        $arr[0] = "SELECT";
        foreach ($roles as $role) {
            $arr[$role->id] = $role->name;
        }
        return $arr;
    }


    public static function getNotification($token, $title, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

//        $token = "denG_Y3xlKw:APA91bFg0PVxYaI-knF2q-X79Lbz5xRP_a0BhPOQyfSmbW7bYmPQuZyfPUnArMpmYnM8K6WbUKt-iKT4Owjlx31XNH4fMC1ioBsqTtcI5_rEfJJc2ImvvWOBEG_ejPZLdfYzdyZ9eDGx";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

}
