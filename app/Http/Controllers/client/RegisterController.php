<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\client\ControllerBase;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\client\ApiHelper;

class RegisterController extends ControllerBase {
  
  public function index(Request $req) {
    $fieldTitle = [
      
    ];
    return view('auth.register.index');
  }

  public function register(Request $req) {
    dd($req);
    $input = $req->all();
    $res = ApiHelper::postWithoutToken($input, $this->uriRegister);
    if($res && $res->success) {
      return redirect('/');
    } else {

    }
  }

  public function checkUniqueUser(Request $req) {
    return response()-> json([
      'success'=> true,
      'unique' => true
    ], 200);
  }
}
