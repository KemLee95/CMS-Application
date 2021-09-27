<?php

namespace App\Http\Controllers\client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ControllerBase extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $rootAPI = 'http://127.0.0.1:8000/api/v1/';

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
    
    public function getBearToken(Request $req) {

    }
}
