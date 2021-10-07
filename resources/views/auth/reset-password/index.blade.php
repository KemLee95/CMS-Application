@extends('layout.master')
@section('head_style')
    
@stop
@section('content')
<div class="row justify-content-center">
  <div class="p-4 col-md-6 col-md-offset-2 card">
      <div class="panel panel-default">
          <div class="panel-body">
              <form id="submitForm" action="{{Request::url()}}/reset" class="form-horizontal" role="form" method="POST" >
                  {{ csrf_field() }}
                  <input type="hidden" name="token" value="{{isset($token) && $token ? $token:""}}">
                  <div class="form-group">
                      <label for="email" class="col-md-4 control-label">Email</label>
                      <input id="email" type="text" class="form-control" name="email" value="" >
                  </div>

                  <div class="form-group">
                      <label for="password" class="col-md-4 control-label">New password</label>
                      <input id="password" type="password" class="form-control" name="password">
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Confirmation password</label>
                    <input id="re_password" type="password" class="form-control" name="password_confirmation">
                  </div>
                  <div class="form-group">
                      <div >
                          <button id="submit_button" type="button" class="btn btn-primary">
                              Submit
                          </button>
                      </div>
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
        $("#submit_button").click(function(){
        let email = $("#email").val();
          let password = $("#password").val();
          let rePassword = $("#re_password").val();
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
          
          if(!password) {
            toastr.warning('Warning', 'The new password is required!');
            isError = true;
          }
          if(isError) return 0;

          if(!rePassword) {
            toastr.warning('Warning', 'The comfirmation password is required!');
            isError = true;
          }
          if(isError) return 0;

          if(password !== rePassword) {
            toastr.warning('Warning', 'The password and comfirmation password do not match!');
            isError = true;
          }
          if(isError) return 0;

          if(!isError) {
              $("#submitForm").submit()
          };
        });
      });
    </script>
@stop