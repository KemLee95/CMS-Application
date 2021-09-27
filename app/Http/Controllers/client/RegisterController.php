<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\client\ControllerBase;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\client\ApiHelper;

class RegisterController extends ControllerBase {
  
  public function create(Request $req) {
    $fieldTitle = [

    ];
    // $res = ApiHelper::getWithoutToken($this->rootAPI);
    return view('auth.register.index', compact("fieldTitle"));
  }

  public function store(Request $req) {

    dd($req);
  }
}
