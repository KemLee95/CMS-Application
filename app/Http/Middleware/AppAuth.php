<?php

namespace App\Http\Middleware;

use Closure;

class AppAuth {
  public function handle($req, Closure $next) {
    $user_auth = session('user_auth');
    if(!empty($user_auth)) {
      if(isset($user_auth->logout) && date('Y-m-d H:i', strtotime(now())) >= date('Y-m-d H:i', strtotime($user_auth->logout))) {
        return redirect('/auth');
      }
      return $next($req);
    }
    return redirect('/auth');
  }
}