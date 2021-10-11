<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiHelper;
use App\Http\Controllers\ControllerBase;
use Illuminate\Http\Request;

class VoucherController extends ControllerBase{

  public function view($id, Request $req) {
    $input = $req->all();
    $paramData = http_build_query($input);

    $voucher =  null;
    $users = [];
    $pagination = null;
    $res = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetVoucherDetail ."?voucher_id=" .$id);
    if($res && $res->success) {
      $voucher = $res->voucher;
      $resUser = ApiHelper::getWithToken($this->getBearerToken($req), $this->uriGetVoucherUsers . "?voucher_id=" . $id . "&" . $paramData);
      if($resUser && $resUser->success) {
        $result = $resUser->data;
        $users = $result->data;

        $pagination = $this->pagination($req, $result->data, $result->total ,$result->per_page, $result->current_page);
      }
    }
    return view("admin.voucher.index", compact("voucher", "users", "pagination"));
  }

}