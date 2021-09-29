<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
      return redirect()->back();
    }

    if($res && !$res->success) {
 
      $error = [];
      $error['message_title'] = $res->message_title;
      $error['message'] = $res->message;

      $getSession = $req->session()->get('login_counter')->counter;
      return redirect()->back()->with(['getSession'=>$getSession, 'erro'=>$error]);
    }
    
    $this->putUserInfo($req, $res->user);
    return redirect('/');
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
