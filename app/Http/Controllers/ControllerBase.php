<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Pagination\LengthAwarePaginator;

use View;

define("apiUri", "api/v1/");

class ControllerBase extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uriLogin = apiUri . 'post/login';
    protected $uriLogout =apiUri . 'auth/get/logout';
    
    protected $uriRegister = apiUri . 'post/register';
    protected $uriCheckUniqueUser = apiUri . 'post/check-unique-user';
    protected $uriUpdateUserInfo = apiUri . 'auth/post/update-user-info';

    protected $uriGetRoleList = apiUri . 'auth/admin/get/role-list';
    protected $uriGetCategoryList = apiUri . 'get/category-list';
    protected $uriGerPostList = apiUri . 'get/post-list';
    protected $uriGetPostDetail = apiUri . 'get/post-detail';
    protected $usiSavePost = apiUri . 'auth/post/save-post';
    protected $uriDeletePost = apiUri . 'auth/post/delete-post';

    protected $uriGetAccountList = apiUri . 'auth/admin/get/account-list';

    protected $uriReaderTracking = apiUri . 'auth/get/reader-tracking';

    protected $uriGetUserInfo = apiUri . 'auth/get/user-info';

    protected $uriVerifiedEmail = apiUri . 'email/verification-notification';

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
    
    public function pagination($req, $data, $total, $per_page, $current_page){

        $iData = http_build_query($req->all());
        return new LengthAwarePaginator( 
            $data, 
            $total, 
            $per_page, 
            $current_page, 
            ['path' => $req->url(). "?" . $iData]
        );
    }

    public function throwEroor() {
    
        $error = [];
        $error['message']="An error occurred, please contact with administrator!";
        $error['message_title']='Request failed';
        return back()->with(["error"=> $error]);
    }
}
