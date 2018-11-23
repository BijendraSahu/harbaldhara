<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::GET('logout', function () {
    session_start();
    $_SESSION['admin_master'] = null;
    return redirect('/');
});

/*********Admin + Login***********/
Route::get('/admin', 'AdminController@admin');
Route::get('/', 'AdminController@adminlogin');
Route::get('account', 'AdminController@change_account');
Route::get('user_by_franchise', 'AdminController@user_by_franchise');
Route::post('search_user_by_franchise', 'AdminController@search_user_by_franchise');

Route::get('distribution', 'AdminController@distribution');
Route::post('distribution', 'AdminController@search_distribution');


Route::get('/logincheck', 'AdminController@logincheck');

Route::get('gain_type_points', 'AdminController@gain_type_points');
Route::get('gain_type_points/{id}/edit', 'AdminController@edit_gain_type_points');
Route::post('gain_type_points/{id}', 'AdminController@update_gain_type_points');

Route::get('/settings/{id}', 'SettingController@settings');
Route::get('/changepass', 'SettingController@changepass');
Route::post('myadminpost', 'SettingController@myadminpost');
/*********Admin + Login***********/


/*********Users***********/
Route::resource('user_master', 'UserMasterController');
Route::get('activate_with_key/{id}', 'UserMasterController@activate_with_key');
Route::get('user_master/{id}/delete', 'UserMasterController@destroy');
Route::post('user_master/{id}/activate', 'UserMasterController@activate');
Route::get('user_master/{id}/inactivate', 'UserMasterController@inactivate');
Route::get('user_master/{id}/empty', 'UserMasterController@empty_point');
Route::get('user_master/{id}/remind', 'UserMasterController@reminder_points');
Route::get('user_master/{id}/repurchase', 'UserMasterController@repurchase');
/*********Users***********/

/*********News***********/
Route::resource('news', 'NewsController');
Route::get('news/{id}/delete', 'NewsController@destroy');
/*********News***********/

/*********Gallery***********/
Route::resource('gallery_master', 'GalleryController');
Route::get('gallery/{id}/delete', 'GalleryController@destroy');
/*********Gallery***********/


/*********Key***********/
Route::resource('key', 'UserKeyController');
Route::get('key/{id}/activate', 'UserKeyController@activate');
Route::get('key/{id}/inactivate', 'UserKeyController@inactivate');
Route::get('key/{id}/empty', 'UserKeyController@emptyKey');
Route::get('assign_key/{id}', 'UserKeyController@assign_key');
/*********Key***********/

/*********Advertisement***********/
Route::resource('advertisement', 'AdvertisementController');
Route::get('advertisement/{id}/activate', 'AdvertisementController@destroy');
Route::get('advertisement/{id}/inactivate', 'AdvertisementController@inactivate');
/*********Advertisement***********/


/*********Franchise***********/
Route::resource('franchise', 'FranchiseController');
Route::get('franchise/{id}/activate', 'FranchiseController@activate');
Route::get('franchise/{id}/inactivate', 'FranchiseController@destroy');
Route::GET('franchise/{id}/resetPassword', 'FranchiseController@reset');
Route::POST('reset_password', 'FranchiseController@reset_password');

Route::get('franchise_keys', 'FranchiseController@franchise_keys');
Route::post('assign_key/{id}', 'UserKeyController@assign_key_to_franchise');
/*********Franchise***********/

/*********Redeem***********/
Route::get('redeem_requests', 'RedeemController@redeem_requests');
Route::get('redeem_request/{id}/approve', 'RedeemController@getapproved');
Route::post('redeem_request/{id}/approve', 'RedeemController@approved');
Route::get('redeem_request/{id}/reject', 'RedeemController@getreject');
Route::post('redeem_request/{id}/reject', 'RedeemController@reject');
/*********Redeem***********/



/*************API******************/
Route::get('getBankDetails','APIController@getBankDetails');
Route::get('getUserRecord','APIController@getUserRecord');
Route::get('getAdsCounts','APIController@getAdsCounts');
Route::get('getregister','APIController@getregister');
Route::get('verify_otp','APIController@verify_otp');
Route::get('resend_otp','APIController@resend_otp');
Route::get('getAllAds','APIController@getAllAds');
Route::get('checkrc','APIController@checkrc');
Route::get('get_user_point','APIController@get_user_point');
Route::get('get_user_point_new','APIController@get_user_point_new');
Route::get('view_share_ads_by_user','APIController@view_share_ads_by_user');
Route::post('edit_profile','APIController@edit_profile');
Route::post('edit_profile_login','APIController@edit_profile_login');
Route::get('getMyReferral','APIController@getMyReferral');
Route::get('getAdsPoints','APIController@getAdsPoints');
Route::get('getAllNews','APIController@getAllNews');
Route::get('getAllGallery','APIController@getAllGallery');
Route::get('getCity', 'APIController@getCity');
//-----------Redeem----------//
Route::get('redeem_now', 'APIController@redeem_now'); //Redeems now
Route::get('redeem_history', 'APIController@redeem_history'); //Redeems show
Route::get('point_history', 'APIController@point_history'); //Point show
Route::get('add_update_bank_details','APIController@add_update_bank_details');
//-----------Redeem----------//
Route::get('getData','AdminController@getData');
Route::get('test','APIController@test');
/*************API******************/