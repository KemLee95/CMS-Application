<?php
namespace App\Http\Middleware;
use Closure;

class AdminAuth {

  public function handle($req, Closure $next) {
    $user = session('user_auth');

    if(isset($user->isAdmin) && $user->isAdmin) {
      return $next($req);
    }
    return redirect('/home');
  }
}