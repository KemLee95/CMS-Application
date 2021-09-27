<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\api\ApiBase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class UserApi extends ApiBase {

  public function login() {
    \Log::info("UserApi: login");
    try {
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        $user = Auth::user(); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        return response()->json(['success' => $success], $this-> successStatus); 
      } 
      else{ 
          return response()->json(['error'=>'Unauthorised'], 401); 
      } 

    } catch (\Exception $e) {
        \Log::error("UserApi: can't login!", ['eror message' => $e->getMessage()]);
        report($e);
        return response()->json([
            'success' => false,
            'message' => 'Please try again',
            'message_title' => "Request failed",
        ], 400 );
    }
  }
  public function register(Request $req) {
    \Log::info("UserApi: register");
    try {
      $validator = Validator::make($req->all(), [
          'name' => 'required',
          'email' => 'required|email',
          'password' => 'required',
          'c_password' => 'required|same:password'
      ]);
      if($validator->fails()) {
        return response()->json([
          "success"=> false,
          'errors'=> $validator->errors()->toArray(),
        ], 401);
      }
      $input = $req->all();
      $input['password'] = bcrypt($input['password']);
      $user = User::create($input);

      $success['token'] =  $user->createToken('MyApp')-> accessToken; 
      $success['name'] =  $user->name;

      return response()->json([
        "success" => true,
      ], 200);
      
    } catch (\Exception $e) {
        \Log::error("UserApi: can't register!", ['eror message' => $e->getMessage()]);
        report($e);
        return response()->json([
            'success' => false,
            'message' => 'Please try again',
            'message_title' => "Request failed"
        ], 400);
    }
  }
  public function logout(Request $req) {
    
  }
}