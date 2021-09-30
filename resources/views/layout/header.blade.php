<nav class="mb-4 navbar navbar-default border-bottom">
  <div class="container-fluid d-flex align-items-center">
    <div class="navbar-header">
      <a class="navbar-brand" href="">Content management system</a>
    </div>
    <div class="d-flex-inline">
      <div class="nav-header">
        @if (isset($user_auth) && $user_auth->user_name)
          <a class="btn btn-info">
            <strong>{{$user_auth->user_name}}</strong>
          </a>
          @if (isset($user_auth->isAdmin) && $user_auth->isAdmin)
              <a class="btn btn-success" href="{{Request::url()}}">Create User</a>
          @endif
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