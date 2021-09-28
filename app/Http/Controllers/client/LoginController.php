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
      $dataObject = new \stdClass;

      if(!$req->session()->exists('login_counter')) {

        $dataObject->counter = 0;
        $dataObject-> last_click_current = date('Y-m-d H:i:s', strtotime(now()));
        $req->session()->put('login_counter', $dataObject);
      } else {

        $login_counter = $req->session()->get('login_counter');
        if(isset($res->message_code) & $res->message_code === 401) {

          $current = date( 'Y-m-d H:i:s', strtotime(now()) );
          $passTime = $req->session()->get('login_counter')->last_click_current;
          $login_counter->counter+=1;
          $login_counter->last_click_current = date('Y-m-d H:i:s', strtotime(now()));

          $req->session()->put('login_counter', $login_counter);

        } else {

          $login_counter = 0;
          $req->session->put('login_counter', $login_counter);
        }
      }
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
