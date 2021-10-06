@extends('layout.master')
@section('head_style')
    
@stop
@section('content')
<div class="row justify-content-center">
    <div class="p-4 col-md-6 col-md-offset-2 card">
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
                            <a id="forgotPassword" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">
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
<section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body from-group">
                <input class="form-control" type="email" name="email" id="email" placeholder="Your verified email">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="submitButton" type="button" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </div>
</section>
@section('foot_script')
    <script>
        $(document).ready(function(){
            $("#submitButton").click(function(){   
                let email = $("#email").val()
                let isError = false;
                
                if(!email.length) {
                    toastr.warning('Warning', 'The email is required!');
                    isError = true;
                }
                if(isError) return 0;
            
                let email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+[^<>()\.,;:\s@\"]{2,})$/;
                if( !email_regex.test(email)) {
                    toastr.warning('Warning', 'The email is invalid!');
                    isError = true;
                }
                if(isError) return 0;

                $.ajax({
                    type: 'GET',
                    'url': 'auth/password/reset?email='+email
                }).done(function(data){
                    if(data.success) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data->message, data->message_title);
                    }
                });
                
                $('#exampleModal').modal("toggle");
            });
        });
    </script>
@stop