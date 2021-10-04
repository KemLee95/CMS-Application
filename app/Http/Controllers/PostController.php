<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\ApiHelper;

class PostController extends ControllerBase {
  
  public function update($id, Request $req) {

    $post = null;
    $categories = [];
    $isUpdate = false;

    if(is_numeric($id) && $id !== 0) {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPostDetail. "/" .$id);
      if($res && $res->success) {
        $post = $res->post;
        $categories = $res->categories;
        $isUpdate = true;
      }
    } else {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetCategoryList);
      if($res && $res->success) {
        $categories = $res->categories;
      }
    }
    return view("admin.post.update", compact("post", "categories", 'isUpdate'));
  }

  public function save(Request $req) {
    $input = $req->all();
    
    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->usiSavePost);
    if($res) {
      if($res->success) {
        $success = [];
        $success['notify'] = $res->message;
        return redirect('/admin')->with("success", $success);
      }
      $error = [];
      $error['message'] = $res->message;
      $error['message_title'] = $res->message_title;
      return redirect('/admin')->with("error", $error);
    }
    $this->throwError();
  }

  public function delete(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriDeletePost);
    if($res) {
      if($res->success) {
        $success = [];
        $success['notify'] = $res->message;
        return redirect('/admin')->with("success", $success);
      }

      $error = [];
      $error['message'] = $res->message;
      $error['message_title'] = $res->message_title;
      return redirect('/admin')->with("error", $error);
    }
    $this->throwError();
    
  }

  public function track(Request $req) {
    
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriReaderTracking . "?post_id=" . $req->post_id);
    if($res && $res->success) {
      return response() ->json([
        "success"=> true,
        "message" => $res->message,
        "message_title" => $res->message_title,
      ], 200);
    }
    return $req->all();
  }
}