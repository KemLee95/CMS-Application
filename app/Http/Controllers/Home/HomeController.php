<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\ControllerBase;
use App\Http\Controllers\ApiHelper;
use Illuminate\Http\Request;


class HomeController extends ControllerBase {
  
  public function index(Request $req) {
    $input = $req->all();
    $filterData = $req->all();
    $iData = http_build_query($input);

    $fieldTitle = [];
    $result = [];
    $posts = [];
    $pagination = [];
    $categories = [];

    if($req->session()->exists("user_auth")) {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPostList . "?" . $iData);
    } else {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPublishedPostList . "?" . $iData);
    }
    
    if($res && $res->success) {
      $result = $res->pagination;
      $posts = $result->data;
      
      $pagination = $this->pagination($req, $result->data, $result->total ,$result->per_page, $result->current_page);
    }
    
    $resCate = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetCategoryList);
    if($resCate && $resCate->success) {
      $categories = $resCate->categories;
    }
    return view('home.index', compact('posts', 'categories', 'filterData','pagination'));
  }
} 