<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\GainTypePoints;
use App\Reffer;
use App\RoleMaster;
use App\UserBankDetails;
use App\UserKey;
use App\UserMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

session_start();

class UserMasterController extends Controller
{
    public function index()
    {
        if (request('type') == '') {
            return view('user.view_user_master')->with('user_masters', UserMaster::getActiveUserMaster());
        } elseif (request('type') == 'active') {
            return view('user.view_user_master')->with('user_masters', UserMaster::getPaidUserMaster());
        } else {
            return view('user.view_user_master')->with('user_masters', UserMaster::getUnPaidUserMaster());
        }
    }


    public function active_user()
    {
        return view('user.view_user_master')->with('user_masters', UserMaster::getActiveUserMaster());
    }


    public function edit($id)
    {
        $user_master = UserMaster::find($id);
        $sponsers = UserMaster::getUserDropdown();
        $bank = UserBankDetails::where(['user_id' => $id])->first();
        return view('user.edit_user_master')->with(['user_master' => $user_master, 'sponsers' => $sponsers, 'bank' => $bank]);
    }


    public function update($id, Request $request)
    {

        $user_master = UserMaster::find($id);
        $user_master->name = request('name');
        $user_master->contact = request('contact');
        $user_master->paytm_contact = request('paytm_contact');
        $user_master->address = request('address');
//        $user_master->activated_by = request('activated_by');
        $user_master->save();

        if(request('account_holder') != null) {
            $bank = UserBankDetails::where(['user_id' => $id])->first();
            $bank->account_holder = request('account_holder');
            $bank->ac_number = request('ac_number');
            $bank->bank = request('bank');
            $bank->aadhar_pan = request('aadhar_pan');
            $bank->ifsc_code = request('ifsc_code');
            $bank->save();
        }

        $r_user = UserMaster::find(request('reffer_by'));
        $checkRefPoint = DB::select("SELECT * FROM `reffer` WHERE (reffer_by = $r_user->id and reffer_to = $user_master->id or reffer_by = $user_master->id and reffer_to = $r_user->id) or reffer_to = $user_master->id");
        if (count($checkRefPoint) < 1) {
            $reffer = new Reffer();
            $reffer->reffer_by = $r_user->id;
            $reffer->reffer_to = $user_master->id;
            $reffer->save();
            GainTypePoints::get_gain_type_points($r_user->id, 'referral');
        }
        return redirect('/user_master')->with('message', 'User has been updated...!');
    }

    public function destroy($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->is_active = 0;
        $user_master->save();
        return redirect('/user_master')->with('message', 'User is now inactivated...User cannot login now!');
    }

    public function allow_login($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->is_active = 1;
        $user_master->save();
        return redirect('/user_master')->with('message', 'User is now activated...User can login now!');
    }

//
    public function activate_with_key($id)
    {
        $user_master = UserMaster::find($id);
        return view('user.activate_user')->with(['user_master' => $user_master]);
    }

    public function activate($id)
    {
//        echo request('key');
        $key = UserKey::where(['key_name' => request('key')])->first();
        if (isset($key)) {
            if ($key->remaining > 0) {
                $key->remaining -= 1;
                $key->save();
                $user_master = UserMaster::find($id);
                $user_master->is_paid = 1;
                $user_master->paid_time = Carbon::now();
                $user_master->activated_by = $_SESSION['admin_master']->id;
                $user_master->save();
                $title = "Account Activation Successful";
                $message = "your account has been activated";
                if (isset($user_master->token)) {
                    AdminModel::getNotification($user_master->token, $title, $message);
                }
                return redirect('/admin')->with('message', 'User is now activated');
            } else {
                return Redirect::back()->withInput()->withErrors("You don't have enough key to activate this user");
            }
        } else {
            return Redirect::back()->withInput()->withErrors('Please enter valid key');
        }
    }

    public function inactivate($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->is_paid = 0;
        $user_master->paid_time = null;
        $user_master->save();
        return redirect('/user_master')->with('message', 'User is now inactivated...');
    }

    public function empty_point($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->points = 0;
        $user_master->save();
        return redirect('user_master')->with('message', 'User point is now 0');
    }

    public function reminder_points($id)
    {
        $user = UserMaster::find($id);
        $title = "Aranea Reminder";
        $message = "Hi $user->name it's an reminder for you to become paid member otherwise your points will get laps in next 24 hours";
        if (isset($user->token)) {
            AdminModel::getNotification($user->token, $title, $message);
            return redirect('user_master')->with('message', 'Notification has been send');
        } else {
            return redirect('user_master')->with('message', 'Notification has not been send because user is using older version');
        }
    }

    public function checkUsername($username)
    {
        $user = UserMaster::where(['is_active' => 1, 'username' => $username])->first();
        if (is_null($user)) return true;
        else return false;
    }
}
