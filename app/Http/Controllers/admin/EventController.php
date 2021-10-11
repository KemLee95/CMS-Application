<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiHelper;
use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;

class EventController extends ControllerBase {

  public function index(Request $req) {
    $input = $req->all();
    $filterData = $req->all();
    $iData = http_build_query($input);

    $events = [];
    $pagination = [];
    $startCount = 0;
    
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetEventList . "?". $iData);
    if($res && $res->success) {
      $data = $res->data;
      $events = $data->data;
      $startCount = $data->per_page *($data->current_page -1);
      $pagination = $this->pagination($req, $events, $data->total, $data->per_page, $data->current_page);
    }
    return view("admin.event.index", compact("events", "startCount", "pagination"));
  }

  public function update($id, Request $req) {
    $input = $req->all();

    $event = null;
    if(is_numeric($id) && $id != 0) {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetEventDetail . "?event_id=" . $id);
      if($res && $res->success) {
        $event = $res->event;
      }
    }
    return view("admin.event.update", compact('event'));
  }

  public function save(Request $req) {
    $input = $req->all();
    dd($input);
    $res = ApiHelper::postWithToken($this->getBearerToken($req), $input, $this->uriSaveEvent);
    if($res && $res->success) {
      $success['message'] = $res->message;
      return redirect()->back()->with("success", $success);
    }
    $error = array(
      "message" => $res->message,
      "message_title" => $res->message_title
    );
    return redirect()->back()->with("error", $error);
  }

  public function partial(Request $req) {
    $index = $req->index;
    $input = $req->all();
    $iParam = http_build_query($input);
    $page = 0;
    $vouchers = [];

    if($req->has("event_id")) {
      $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetVoucherPartial . "?" . $iParam);
      if($res && $res->success) {
        $vouchers = $res->data->data;
        $page = $res->data->current_page;
      }
    }

    return view('admin.event.partial', compact('vouchers', 'index', 'page'));
  }
}