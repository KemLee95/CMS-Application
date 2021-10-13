@extends('admin.master')
@section('head_style')
    
@stop
@section('content')
<div class="row justify-content-around">
    <div class="card col-6">
        <div class="mt-2 d-flex justify-content-center">
            <img class="card-img-top" src="" alt="" style="width: 18rem; height: 25rem;">
        </div>
        <div class="mt-2">
            <label for="your voucher"><strong>Your vouchers:</strong></label>
            <div>
                @foreach ($userVouchers as $voucher)
                    <button class="m-1 btn btn-primary">
                        Reduce {{isset($voucher->percentage_decrease) && $voucher->percentage_decrease ? $voucher->percentage_decrease : 0}} % 
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <div class="p-4 col-md-6 col-md-offset-2 card">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="registerForm" action="{{Request::url()}}/save-user" method="POST" class="form-horizontal" role="form" >
                    <input type="hidden" name="user_id" id="user_id" value={{isset($userInfo->id) && $userInfo->id ? $userInfo->id : ""}}>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username" class="col-md-4 control-label">Username</label>
                        <input id="user_name" type="text" class="form-control" name="user_name"
                            value="{{isset($userInfo) && $userInfo->user_name ? $userInfo->user_name : ""}}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Name</label>
                        <input  type="text" class="form-control" name="name" 
                            value="{{isset($userInfo) && $userInfo->name ? $userInfo->name : ""}}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Email</label>
                        <div class="d-flex">
                            <input id="email"  type="email" class="form-control col-8" name="email"
                            value="{{isset($userInfo) && $userInfo->email ? $userInfo->email : ""}}"
                            >
                            @if (isset($userInfo) && $userInfo->email_verified_at)
                                <button type="button" class="mx-2 col-4 btn btn-success" disabled>Verified Email</button>
                            @else
                                <button type="button" id="verifyButton" class="mx-2 col-4 btn btn-success"
                                    {{$user_auth->id == (isset($userInfo->id) && $userInfo->id ? $userInfo->id: false) ? "" : "disabled"}}
                                >Verify Email</button>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" value="">
                    </div>
                    <div class="form-group">
                        <div class="p-0 col-6">
                            <label for="role" class="col-md-4 control-label">Role</label>
                            @if (isset($user_auth) && $user_auth->isAdmin)
                                <select id="role_id" name="role_id[]" class="select2 form-control" multiple>
                                    @if (isset($roles) && $roles))
                                        @foreach($roles as $role)
                                            @if (in_array($role->id, $userRoles))
                                                <option class="text-capitalize" value="{{$role->id}}" selected >{{$role->name}}</option>
                                            @else
                                            <option class="text-capitalize" value="{{$role->id}}">{{$role->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            @else
                                <select id="role_id" name="role_id[]" class="select2 form-control" multiple>
                                    @if (isset($userInfo->roles) && $userInfo->roles))
                                        @foreach($userInfo->roles as $role)
                                            <option class="text-capitalize" value="{{$role->id}}" selected>{{$role->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 form-group">
                        
                        <button id="submitBtn" type="button" class="btn btn-primary w-100">
                            @if (isset($user_auth) && $user_auth)
                                Save
                            @else
                                SignUp
                            @endif
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
        $('.select2').select2();
        
        $("#submitBtn").click(function(ev){
            ev.preventDefault();
            
            let isError = false;
            let userId = $("#user_id").val();
            let userName = $("#user_name").val();
            let email = $("#email").val();
            let password = $("#password").val();

            if(!userName.length) {
                toastr.warning('Warning', 'The username is required!');
                isError = true;
            }
            if(isError) return 0;
            
            let userData;
            if(userId) {
                userData = {
                    "user_id": userId,
                    'user_name': userName
                };
            } else {
                userData = {
                    'user_name': userName
                };
            }

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

            let emailData;
            if(userId) {
                emailData = {
                    'user_id': userId,
                    'email': email
                };
            } else {
                emailData = {
                    'email': email
                };
            }
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

            if(!password) {
              toastr.warning('Warning', 'The password is required!');
              isError = true;
            }
            if(isError) return 0;

            let roleIds = $("#role_id").val();
            if(roleIds.length < 1) {
              toastr.warning('Warning', 'The role is required!');
                isError = true;
            }
            if(isError) return 0;

            if(!isError) {
                $("#registerForm").submit()
            };
        });

        $("#verifyButton").click(function(){
           $.ajax({
               type: 'GET',
               url: '/auth/verify-email'
           }).done(function(data) {
               if(data.success) {
                    toastr.success(data.message);
               }else {
                    toastr.error(data.message, data.message_title);
               }
           })
        });
    })
</script>
@stop