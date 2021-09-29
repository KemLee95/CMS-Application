<?php

namespace App\Http\Controllers\client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use View;

define("apiUri", "api/v1/");

class ControllerBase extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uriLogin = apiUri . 'post/login';
    protected $uriRegister = apiUri . 'post/register';
    protected $uriCheckUniqueUser = apiUri . 'post/check-unique-user';

    public $user;
    public function __construct(Request $req) {
        $this->middleware(function($req, $next){
            $this->init($req);
            return $next($req);
        });
    }
    
    public function init($req) {
        $this->user = $req->session()->get('user_auth');
        View::share("user_auth", $this->user);
    }

    public function putUserInfo(Request $req, $userInfo) {
        $req->session()->put('user_auth', $userInfo);
    }

    public function getBearerToken(Request $req) {
        if($req->session()->exists("user_auth")) {
            return $req->session()->get('user_auth')->token;
        }
        return null;
    }
}
