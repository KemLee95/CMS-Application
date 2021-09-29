@extends('layout.master')
@section('head_style')
    
@stop
@section('content')
<div class="row justify-content-center">
    <div class="p-4 col-md-6 col-md-offset-2 card">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="registerForm" action="/auth/save" class="form-horizontal" role="form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username" class="col-md-4 control-label">Username</label>
                        <input id="user_name" type="text" class="form-control" name="user_name" value="">
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Name</label>
                        <input  type="text" class="form-control" name="name" value="">
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Email</label>
                        <input id="email"  type="email" class="form-control" name="email" value="">
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" value="">
                    </div>

                    <div class="form-group">
                        <label for="re_password" class="col-md-4 control-label">Re-Password</label>
                        <input id="password" type="password" class="form-control" name="re_password" value="">
                    </div>

                    <div class="form-group">
                        <button id="submitBtn" type="button" class="btn btn-primary">
                            SignUp
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('foot_script')
<script>
    $(document).ready(function(){
        $("#submitBtn").click(function(ev){
            ev.preventDefault();
            
            let isError = false;
            let userName = $("#user_name").val();
            let email = $("#email").val();

            if(!userName.length) {
                toastr.warning('Warning', 'The username is required!');
                isError = true;
            }
            if(isError) return 0;
            
            let userData = {
                'user_name': userName
            };

            $.ajax({
                async: false,
                type: 'POST',
                url: 'view/check-unique-user',
                data: userData,
            }).done(function(res){
                if(!res.success) {
                    toastr.error(res.message, res.message_title);
                    isError = true;
                } else if(!res.unique) {
                    toastr.warning('Warning', 'The username is dupplicated!');
                    isError = true;
                }
            });
            if(isError) return 0;

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

            let emailData = {
                'email': email
            };
            $.ajax({
                async: false,
                type: 'POST',
                url: 'view/check-unique-user',
                data: emailData,
            }).done(function(res){
                if(!res.success) {
                    toastr.error(res.message, res.message_title);
                    isError = true;
                } else if(!res.unique) {
                    toastr.warning('Warning', 'The email is dupplicated!');
                    isError = true;
                }
            });

            if(!isError) {
                console.log($("#registerForm"))
                $("#registerForm").submit()
            };
        });

    })
</script>
@stop