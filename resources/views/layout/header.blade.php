<nav class="mb-4 navbar navbar-default border-bottom">
  <div class="container-fluid d-flex align-items-center">
    <div class="navbar-header">
      <a class="navbar-brand" href="">CMS</a>
    </div>
    <div class="d-flex-inline">
      <div class="nav-header">
        @if (isset($user_auth) && $user_auth->user_name)
          <a class="btn btn-info">
            <strong>{{$user_auth->user_name}}</strong>
          </a>
          <a href="/auth/logout" class="btn btn-warning">
            <strong>
              LogOut
            </strong>
          </a>
        @else
          <a href="/auth/" class="btn bg-primary">Sign In</a>
        @endif
      </div>
    </div>
  </div>
</nav>