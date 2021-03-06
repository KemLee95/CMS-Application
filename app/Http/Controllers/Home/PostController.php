<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiHelper;

class PostController extends ControllerBase {
  
  public function update($id, Request $req) {

    $post = null;
    $categories = [];
    $canUpdate = false;
    $editingUser = null;
    $avaibleEventTotal = 0;


    if(is_numeric($id) && $id !== 0) {
      if(session()->exists("user_auth")) {
        $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPostDetail. "/" .$id);
      } else {
        $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetPublishedPostDetail. "/" .$id);
      }
      if($res && $res->success) {
        $post = $res->post;
        $editingUser = $post->editing_user;
        $canUpdate = $res->canUpdate;

        $resEvent = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriCountEnabledEvents);
        if($resEvent && $resEvent->success){
          $avaibleEventTotal = $resEvent->total;
        } 
      }
    }

    $resCate = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetCategoryList);
    if($resCate && $resCate->success) {
      $categories = $resCate->categories;
    }

    return view("home.post.update", compact("post", "categories", 'canUpdate', 'editingUser', 'avaibleEventTotal'));
  }

  public function save(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->usiSavePost);
    if($res) {
      if($res->success) {
        $success = array(
          "message" => $res->message
        );
        return redirect()->back()->with("success", $success);
      }
      
      $error = [];
      $error['message'] = $res->message;
      $error['message_title'] = $res->message_title;
      return redirect()->back()->with("error", $error);
    }
    $this->throwError();
  }

  public function delete(Request $req) {
    $input = $req->all();

    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriDeletePost);
    if($res) {
      if($res->success) {
        $success = [];
        $success['message'] = $res->message;
        return redirect()->back()->with("success", $success);
      }

      $error = [];
      $error['message'] = $res->message;
      $error['message_title'] = $res->message_title;
      return redirect()->back()->with("error", $error);
    }
    $this->throwError();
    
  }

  public function track(Request $req) {
    
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriReaderTracking . "?post_id=" . $req->post_id);
  }

  public function edited(Request $req) {
    $input = $req->all();

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriBeingEdited . "?post_id=" . $req->post_id);
  }

  public function editable(Request $req) {
    $input = $req->all();
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriEditablePost . "?post_id=" . $req->post_id);
  }

  public function getEventPartial(Request $req) {
    $input = $req->all();
    $iParam = http_build_query($input);
    $events = [];
    $vouchers = [];
    $page = $req->page;
    
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetEventPartial . "?" . $iParam);
    if($res && $res->success) {
      
      $events = $res->data->data;
    }
    return view("home.post.event-partial", compact("events", "page"));
  }

  public function getVoucherForUser(Request $req) {
    $input=$req->all();
    $iParam = http_build_query($input);

    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetVoucherForUser . "?" . $iParam);
    if($res && $res->success) {
      return response()->json([
        "success" => true,
        "message" => $res->message
      ], 200);
    }
    return $res;
    return response()->json([
      "success" => false,
      "message" => $res->message,
      "message_title" => $res->message_title
    ]);
  }
}