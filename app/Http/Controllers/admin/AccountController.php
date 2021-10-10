<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiHelper;

class AccountController extends ControllerBase {
  
  public function index(Request $req) {
    $input = $req->all();
    $filterData = $req->all();
    $iData = http_build_query($input);

    $accounts = [];
    $pagination = [];
    $startCount = 0;

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetAccountList . "?" . $iData);
    if($res && $res->success) {
      $data = $res->data;
      $accounts = $data->data;
      $startCount = $data->per_page *($data->current_page -1);
      $pagination = $this->pagination($req, $accounts, $data->total, $data->per_page, $data->current_page);
    }

    return view('admin.account.index', compact('filterData', 'accounts', 'startCount','pagination'));
  }

  public function update($id, Request $req) {

    $userInfo = null;
    $roles = [];
    $userRoles = [];
    if(is_numeric($id)&& $id != 0) {
      $res = ApiHelper::getWithtoken($this->getBearerToken($req), $this->uriGetUserInfo . "?user_id=". $id);

      if($res && $res->success) {
        $userInfo = $res->userInfo;
        $roles = $res->roles;
        $userRoles = array_map(function($role){
          return $role->id;
        }, $res->userInfo->roles);
      }
    } else {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetRoleList);
      if($res && $res->success) {
        $roles = $res->roles;
      }
    }


    return view("admin.account.update", compact("userInfo", "roles", "userRoles"));
  }

  public function save(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriUpdateAccount);
    if(!$res) {
      $error = [];
      $error['message']="An error occurred, please contact with administrator!";
      $error['message_title']='Request failed';
      return back()->with("error", $error);
    }

    if($res && $res->success) {
      $success = [];
      $success["message"] = $res->message;
      return redirect()->back()->with("success", $success);
    }
    $error = [];
    $error['message'] = $res->message;
    $error['message_title'] = $res->message_title;
    return redirect()->back()->with("error", $error);
  }

  public function delete(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriDeleteAccount);
    if(!$res) {
      $error = [];
      $error['message']="An error occurred, please contact with administrator!";
      $error['message_title']='Request failed';
      return back()->with("error", $error);
    }

    if($res && $res->success) {
      $success = [];
      $success["message"] = $res->message;
      return redirect()->back()->with("success", $success);
    }
    $error = [];
    $error['message'] = $res->message;
    $error['message_title'] = $res->message_title;
    return redirect()->back()->with("error", $error);
  }
}