<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\client\ControllerBase;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\helper\ApiHelper;

class RegisterController extends ControllerBase {
  
  public function index(Request $req) {
    $fieldTitle = [
      
    ];
    return view('auth.register.index');
  }

  public function register(Request $req) {

    $input = $req->all();
    $res = ApiHelper::postWithoutToken($input, $this->uriRegister);
    if($res && $res->success) {
      return redirect('/auth');
    }
    return response()-> json([
      'success'=> false,
      'message' => 'An error occurred, please contact with administrator!',
      'message_title' => "Request failed",
    ], 400);
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
