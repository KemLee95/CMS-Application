<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\client\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\ApiHelper;

class AdminController extends ControllerBase {
  
  public function index(Request $req) {
    $input = $req->all();
    $iData = http_build_query($input);

    $fieldTitle = [

    ];
    $result = [];
    $posts = [];
    $pagination = [];
    $categories = [];

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGerPostList . "?" . $iData . "&" ."paginate=5");
    if($res && $res->success) {
      $result = $res->data;
      $posts = $result->data;
      $pagination = $this->pagination($req, $result->data, $result->total ,$result->per_page, $result->current_page);
    }

    $cRes = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetCategories);
    if($cRes && $cRes->success) {
      $categories = $cRes->categories;
    }
    return view('admin.index', compact('fieldTitle', 'posts', 'categories', 'pagination'));
  }

  public function register(Request $req) {
    $input = $req->all();
    
    $roles = [];
    $roleRes = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetRoleList);

    if(isset($roleRes) && $roleRes->success) {
      $roles = $roleRes->roles;
    }
    return view('admin.register.index', compact('roles'));
  }

  public function save(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriAdminRegister);
    
    if($res && $res->success) {

      $user = $res->user;
      $this->putUserInfo($req, $user);
      return redirect(isset($user->url) ? $user->url: "/auth");
    }

    $this-> throwEroor($req);
  }
}