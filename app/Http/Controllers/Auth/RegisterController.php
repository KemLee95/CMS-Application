<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerBase;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\ApiHelper;

class RegisterController extends ControllerBase {
  
  public function index(Request $req) {
    $fieldTitle = [
      
    ];
    return view('auth.register.index');
  }

  public function save(Request $req) {

    $input = $req->all();

    $res = ApiHelper::postWithoutToken($input, $this->uriRegister);
    
    if($res && $res->success) {
      $success = array(
        "message" => $res->message
      );
      return redirect('/auth')->with("success", $success);
    }

    $error = [];
    $error["message"] = $res->message;
    $error["message_title"] = $res->message_title;
    return redirect('/auth')->with("error", $error);
  }

  public function checkUniqueUser(Request $req) {

    $input = $req->all();

    $res = ApiHelper::postWithoutToken($input, $this->uriCheckUniqueUser);
    if(isset($res)) {
      return $res;
    }
    return response()-> json([
      'success'=> false,
      'message' => 'An error occurred, please contact with administrator!',
      'message_title' => "Request failed",
    ], 400);
  }
}
