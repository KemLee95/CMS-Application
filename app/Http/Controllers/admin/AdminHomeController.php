<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiHelper;

class AdminHomeController extends ControllerBase {
  
  public function index(Request $req) {
    $input = $req->all();
    $filterData = $req->all();
    $iData = http_build_query($input);

    $fieldTitle = [

    ];
    $result = [];
    $posts = [];
    $pagination = [];
    $categories = [];
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPostList . "?" . $iData);
    if($res && $res->success) {
      $result = $res->pagination;
      $posts = $result->data;
      $categories = $res->categories;
      $pagination = $this->pagination($req, $result->data, $result->total ,$result->per_page, $result->current_page);
    }

    return view('admin.index', compact('fieldTitle', 'filterData', 'posts', 'categories', 'pagination'));
  }
}