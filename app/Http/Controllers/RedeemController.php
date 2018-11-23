<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\RedeemRequest;
use App\UserBankDetails;
use App\UserMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

session_start();

class RedeemController extends Controller
{
    public function redeem_requests()
    {
        $redeem_requests = RedeemRequest::get();
        return view('redeem.redeem_requests')->with(['redeem_requests' => $redeem_requests]);
    }

    public function getapproved($id)
    {
        $redeem_requests = RedeemRequest::find($id);
        return view('redeem.approve_reason')->with(['redeem_requests' => $redeem_requests]);
    }

    public function approved($id)
    {
        $redeem = RedeemRequest::find($id);
        $redeem->status = 'approved';
        $redeem->reject_reason = request('approve_reason');
        $redeem->approved_time = Carbon::now('Asia/Kolkata');
        $redeem->save();

        $user = UserMaster::find($redeem->user_id);
        $user->points = 0;
        $user->save();


        $user_bank = UserBankDetails::where(['user_id' => $redeem->user_id])->first();
        $pay_amt = 0;
        if (isset($user_bank->aadhar_pan)) {
            $pay_amt = $redeem->amount - $redeem->amount * 10 / 100;
//            $tds_percent = 10;
        } else {
            $pay_amt = $redeem->amount - $redeem->amount * 20 / 100;
//            $tds_percent = 20;
        }

        $title = "Request Approved";
        $message = "Thanks for joining us your redeem request has been approved...Rs.$pay_amt has been sent to your paytm number";
        if (isset($user->token)) {
            AdminModel::getNotification($user->token, $title, $message);
        }
        return redirect('/redeem_requests')->with('message', 'Redeem request has been approved');
    }

    public function getreject($id)
    {
        $redeem_requests = RedeemRequest::find($id);
        return view('redeem.reject_reason')->with(['redeem_requests' => $redeem_requests]);
    }

    public function reject($id)
    {
        $redeem = RedeemRequest::find($id);
        $redeem->status = 'rejected';
        $redeem->reject_reason = request('reject_reason');
        $redeem->save();

        $user = UserMaster::find($redeem->user_id);
        $title = "Request Rejected";
        $message = "your redeem request has been rejected";
        if (isset($user->token)) {
            AdminModel::getNotification($user->token, $title, $message);
        }
        return redirect('/redeem_requests')->with('message', 'Redeem request has been rejected');
    }
}
