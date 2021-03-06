<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use View;

define("apiUri", "api/v1/");

class ControllerBase extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uriLogin = apiUri . 'post/login';
    protected $uriLogout =apiUri . 'auth/get/logout';
    
    protected $uriRegister = apiUri . 'post/register';
    protected $uriCheckUniqueUser = apiUri . 'post/check-unique-user';
    protected $uriUpdateUserInfo = apiUri . 'auth/post/update-user-info';

    protected $uriGetRoleList = apiUri . 'auth/admin/get/role-list';
    protected $uriGetCategoryList = apiUri . 'get/category-list';
    protected $uriGetPublishedPostList = apiUri . 'get/post-list';
    protected $uriGetPostList = apiUri . 'auth/get/post-list';
    protected $uriGetPostDetail = apiUri . 'auth/get/post-detail';
    protected $uriGetPublishedPostDetail = apiUri . 'get/published-post-detail';
    protected $usiSavePost = apiUri . 'auth/post/save-post';
    protected $uriDeletePost = apiUri . 'auth/post/delete-post';

    protected $uriGetAccountList = apiUri . 'auth/admin/get/account-list';
    protected $uriDeleteAccount = apiUri . 'auth/admin/post/delete-account';

    protected $uriReaderTracking = apiUri . 'auth/get/reader-tracking';
    protected $uriBeingEdited = apiUri . 'auth/get/posts-being-edited';
    protected $uriEditablePost = apiUri . 'auth/get/set-editable-post';

    protected $uriGetUserInfo = apiUri . 'auth/get/user-info';

    protected $uriVerifiedEmail = apiUri . 'email/verification-notification';
    protected $uriForgotPassword = apiUri . 'forgot-password';
    protected $uriResetPassword = apiUri . 'reset-password';

    protected $uriUpdateAccount = apiUri . 'auth/admin/post/update-account';

    protected $uriGetEventList = apiUri . 'auth/admin/get/event-list';
    protected $uriGetEventDetail = apiUri . 'auth/admin/get/event-detail';

    protected $uriGetVoucherPartial = apiUri . 'auth/admin/get/voucher-partial';
    protected $uriGetVoucherDetail = apiUri . 'auth/admin/get/voucher-detail';
    protected $uriGetVoucherUsers = apiUri . 'auth/admin/get/voucher-users';

    protected $uriSaveEvent = apiUri . 'auth/admin/post/save-event';
    protected $uriCountEnabledEvents = apiUri . 'auth/get/count-enabled-events';
    protected $uriGetEventPartial = apiUri . 'auth/get/event-partial';
    protected $uriGetUsersVoucherList = apiUri . 'auth/get/users-voucher-list';

    protected $uriGetVoucherForUser = apiUri . 'auth/get/voucher-for-user';

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

    public function throwError() {
    
        $error = [];
        $error['message']="An error occurred, please contact with administrator!";
        $error['message_title']='Request failed';
        return back()->with("error", $error);
    }
}
