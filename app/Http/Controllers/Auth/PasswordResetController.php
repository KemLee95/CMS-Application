<?php
namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\ApiHelper;
use App\Http\Controllers\ControllerBase;

class PasswordResetController extends ControllerBase {

  public function index(Request $req) {
    
    return view("auth.forgot-password.index");
  }
}