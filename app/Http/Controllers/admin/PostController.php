<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\client\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\ApiHelper;

class PostController extends ControllerBase {
  
  public function update($id, Request $req) {

    $post = null;
    $categories = [];
    $a = new \stdClass();

    if(is_numeric($id) && $id !== 0) {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPostDetail. "/" .$id);
      if($res && $res->success) {
        $post = $res->post;
        $categories = $res->categories;
      }
    } else {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetCategoryList);
      if($res && $res->success) {
        $categories = $res->categories;
      }
    }
    return view("admin.post.update", compact("post", "categories"));
  }

  public function save(Request $req) {
    $input = $req->all();
    
    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->usiSavePost);

  }

  public function delete(Request $req) {
    $input = $req->all();

    // $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriDeletePost);
  }
}