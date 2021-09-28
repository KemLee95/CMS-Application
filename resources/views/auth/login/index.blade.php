@extends('layout.master')
@section('head_style')
    
@stop
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-md-offset-2 card p-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/auth/login">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="username" class="col-md-4 control-label">Username</label>
                        <input type="text" class="form-control" name="user_name" value="" >
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember_me" > Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div >
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('foot_script')
    
@stop