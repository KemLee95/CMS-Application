<?php

namespace App\Http\Controllers\client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


define("apiUri", "api/v1/");

class ControllerBase extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uriLogin = apiUri . 'post/login';
    protected $uriRegister = apiUri . 'post/register';

    public $user;
    public function __construct(Request $req) {
        $this->middleware(function($req, $next){
            $this->init($req);
            return $next($req);
        });
    }
    
    public function init($req) {
        $this->user = $req->session()->get('user_auth');
    }

    public function putUserInfo(Request $req, $userInfo) {
        $req->session()->put('user_auth', $userInfo);
    }

    public function getBearToken(Request $req) {

    }
}
