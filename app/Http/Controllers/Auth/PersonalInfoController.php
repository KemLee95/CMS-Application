<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ControllerBase;
use App\Http\Controllers\ApiHelper;
use Illuminate\Http\Request;

class PersonalInfoController extends ControllerBase {
  
  public function update(Request $req) {

    $id = $req->user_id;
    $userInfo = null;
    $roles = [];
    $userRoles = [];
    $userVouchers = [];

    $res = ApiHelper::getWithtoken($this->getBearerToken($req), $this->uriGetUserInfo . "?user_id=". $id);

    if($res && $res->success) {
      $userInfo = $res->userInfo;
      $roles = $res->roles;
      $userRoles = array_map(function($role){
        return $role->id;
      }, $res->userInfo->roles);
    }

    $resVoucher = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetUsersVoucherList);
    if($resVoucher && $resVoucher->success) {
      $userVouchers = $resVoucher->data->data;
    }

    return view("auth.personal-info.update", compact("userInfo", "roles", "userRoles", "userVouchers"));
  }
  
  public function save(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriUpdateUserInfo);
    if($res && $res->success) {
      $success = array("message" => $res->message);
      return redirect()->back()->with('success', $success);
    }
  }

  public function verify(Request $req) {

    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriVerifiedEmail);
    if($res && $res->success) {
      return response()->json([
        "success" => true,
        "message" => $res->message,
        "message_title" => $res->message_title
      ], 200);
    }
    return response() ->json([
      "success" =>false,
      "message" => $res->message,
      "message_title" => $res->message_title
    ],400);
  }
}