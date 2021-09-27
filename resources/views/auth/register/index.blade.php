@extends('layout.master')
@section('style')
    
@stop
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Sign Up</div>
            <div class="panel-body">
                <form action="/auth/save" class="form-horizontal" role="form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username" class="col-md-4 control-label">Username</label>
                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="username" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input  type="email" class="form-control" name="name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="password" class="col-md-4 control-label">Email</label>
                      <div class="col-md-6">
                          <input  type="password" class="form-control" name="email" value="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="password" class="col-md-4 control-label">Password</label>
                      <div class="col-md-6">
                          <input type="password" class="form-control" name="password" value="">
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                SignUp
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    
@stop