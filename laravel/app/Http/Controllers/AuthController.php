<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\Token;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $user = $request->user();
             $data['token'] = $user->createToken('MyApp')->accessToken;
             $data['name']  = $user->name;

             $newToken = new Token();
             $newToken->code = $data['token'];
             $newToken->user_id = $user->id;
             $newToken->expired_at = date("Y-m-d H:i:s", strtotime('+5 hours'));
             $newToken->save();
             unset($user->password);

            return response()->json([
                                      "data" =>[
                                       "token" => $data['token'],
                                       "user" => $user ],
                                       "message" => "Ok"]
                                    , 200);
         }

       return response()->json(['error'=>'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
      $Validator = Validator::make($request->all(), [
          'username' => 'string|required|regex:/^[a-zA-Z0-9_-]/|unique:user|max:255',
          'pseudo' => 'string',
          'email' => 'string|required|email|unique:user',
          'password'=> 'string|required'
      ]);

      if ($Validator->fails()) {
          return response()->json(['message'=>"Bad Request", "code"=>10001, "data"=>$Validator->errors()], 400);
      }

      $newUser = new user();
      $newUser->username = $request->username;
      $newUser->pseudo = $request->pseudo;
      $newUser->created_at = date("Y-m-d H:i:s", strtotime('+2 hours'));
      $newUser->email = $request->email;
      $newUser->password = $request->password;
      $newUser['password'] = bcrypt($newUser['password']);
      $newUser->save();
      unset($newUser->password);

      return response()->json(["data" => $newUser, 
                               "message" => "Ok"]
                               , 200);
  }

    public function userDetail()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }

}
