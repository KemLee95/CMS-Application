<?php
namespace App\Http\Controllers\client;

use App\Http\Controllers\client\ControllerBase;
use Illuminate\Http\Request;


class HomeController extends ControllerBase {
  
  public function index(Request $req) {
    
    return view('home.index');
  }
  public function something(Request $req) {
    dd($this->getBearerToken($req));
  }
} 