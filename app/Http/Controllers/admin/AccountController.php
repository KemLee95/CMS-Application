<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\ApiHelper;

class AccountController extends ControllerBase {
  
  public function index(Request $req) {
    $input = $req->all();
    $filterData = $req->all();
    $iData = http_build_query($input);
    $accounts = [];

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetAccountList);
    dd($res);

    return view('admin.account.index', compact('filterData', 'accounts'));
  }

  public function update($id, Request $req) {
    $input = $req->all();
    
    $roles = [];
    if(is_numeric($id) && $id !==0) {

    } else {
      $roleRes = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetRoleList);
      if(isset($roleRes) && $roleRes->success) {
        $roles = $roleRes->roles;
      }
    }

    return view('admin.account.index', compact('roles'));
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