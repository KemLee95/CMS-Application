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

  }
}
