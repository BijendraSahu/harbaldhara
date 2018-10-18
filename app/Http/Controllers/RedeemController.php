<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\RedeemRequest;
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

    public function approved($id)
    {
        $redeem = RedeemRequest::find($id);
        $redeem->status = 'approved';
        $redeem->approved_time = Carbon::now('Asia/Kolkata');
        $redeem->save();

        $user = UserMaster::find($redeem->user_id);
        $user->points = 0;
        $user->save();

        $title = "Request Approved";
        $message = "Thanks for joining us your redeem request has been approved amount has been sent to your paytm number";
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
