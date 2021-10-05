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

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetAccountList);
    if($res && $res->success) {
      $data = $res->data;
      $accounts = $data->data;
      $pagination = $this->pagination($req, $accounts, $data->total, $data->per_page, $data->current_page);

    }

    return view('admin.account.index', compact('filterData', 'accounts', 'pagination'));
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


    return view("auth.personal-info.update", compact("userInfo", "roles", "userRoles"));
  }

  public function save(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriRegister);
    if(!isset($res)) {
      $this-> throwEroor();
    }

    if($res && $res->success) {
      return redirect(isset($user->url) ? $user->url: "/auth");
    }
  }

  public function delete(Request $req) {
    dd($req);
  }
}