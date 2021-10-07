<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiHelper;

use App\Http\Controllers\ControllerBase;

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

      $success = array("message" => "Login Successfully!");

      return redirect(isset($user->url) ? $user->url : "/auth")->with('success', $success);
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
      $success = array("message" => "You have finished!");
      return redirect('/auth')->with('success', $success);
    }
    return redirect('/auth');
  }

  public function forgotPassword(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithoutToken($input, $this->uriForgotPassword);
    if($res ) {
      return response()->json([
        "success" => $res->success,
        "message" => $res->message,
      ], 200);
    }
  }

  public function resetPassword(Request $req) {
    $input = $req->all();
    $token = $req->token;
    return view("auth.reset-password.index", compact("token"));
  }

  public function reset(Request $req) {

    $input = $req->all();
    $res = ApiHelper::postWithoutToken($input, $this->uriResetPassword);

    if( $res && $res->success) {
      $success = array(
        "message" => $res->message
      );
      
      return redirect("/auth")->with("success", $success);
    }
    
    $error = array(
      "message" => $res->message,
      "message_title"=> $res->message_title
    );
    return redirect("/auth")->with("error", $error);
  }
}
