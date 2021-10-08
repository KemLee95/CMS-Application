<nav class="mb-4 navbar navbar-default border-bottom">
  <div class="container-fluid d-flex align-items-center">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{isset($user_auth) && $user_auth->url ? $user_auth->url : "/home" }}">CMS</a>

    </div>
    <div class="d-flex-inline">
      <div class="nav-header">
        @if (isset($user_auth) && $user_auth->user_name)
          <a href="/auth/personal-info?user_id={{isset($user_auth) && $user_auth->id ? $user_auth->id:""}}" class="btn btn-info">
            <strong>{{$user_auth->user_name}}</strong>
          </a>
          <a href="/auth/logout" class="btn btn-warning">
            <strong>
              LogOut
            </strong>
          </a>
        @else
          <a href="/auth/" class="btn btn-primary">Sign In</a>
          <a href="/auth/register" class="btn btn-success"> Sign Up</a>
        @endif
      </div>
    </div>
  </div>
</nav>