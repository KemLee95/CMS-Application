<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\ApiHelper;

use App\Http\Controllers\client\ControllerBase;

class LoginController extends ControllerBase {
  
  public function index(Request $req) {
    $fieldData = [

    ];

    return view('auth.login.index', compact("fieldData"));
  }

  public function login(Request $req) {

    $input = $req->all();

    $res = ApiHelper::postWithoutToken($input, $this->uriLogin);

    if(!isset($res)) {
      $this->throwEroor();
    }
    
    if($res && $res->success) {
      $user = $res->user;
      $this->putUserInfo($req, $user);
      return redirect(isset($user->url) ? $user->url : "/auth");
    }

    $error = [];
    $error['message_title'] = $res->message_title;
    $error['message'] = $res->message;
    return redirect('/auth')->with('error', $error);
  }

  public function logout(Request $req) {
    if($req->session()->exists('user_auth')) {
      $req->session()->forget('user_auth');
    }
    if(strpos(url()->full(), '/logout')) {
      return redirect('/auth')->with('success', 'You have finished!');
    }
    return redirect('/auth');
  }
}
