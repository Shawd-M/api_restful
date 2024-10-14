<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\token;
use Illuminate\support\Facades\Hash;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function createUser(Request $request)
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

        return response()->json($newUser, 200);
    }

    public function deleteUser(Request $request, $id)
    {
        if (user::where("id", $id)) {
            $newUser = user::where("id", $id);
            $newUser->delete();
            // Notification::container()->success('Your account has been permanently removed from the system. Sorry to see you go!');
            return ("Ici ça marche");
        } else {
            return ("Mon gars t'as capté c'est bizarre là");
            
        }
        //return response()->json($newUser, 201);
    }


    public function bearerToken()
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public function updateUser(Request $request, $id)
    {

        $token = $request->bearerToken();
        $valid = token::where('code', $token)->first();
        if ($valid && $valid->user_id == $id && date("Y-m-d") < $valid->expired_at == true) {

            $Validator = Validator::make($request->all(), [
            'username' => 'string|regex:/^[a-zA-Z0-9_-]/|unique:user|max:255',
            'pseudo' => 'string',
            'email' => 'string|email|unique:user',
            'password'=> 'string'
            ]);

            if ($Validator->fails()) {
                return response()->json(['message'=>"Bad Request", "code"=>10001, "data"=>$Validator->errors()], 400);
            }

            if (user::where("id", $id)) {
                $updateUser = user::where("id", $id)->first();
                if ($request->username)
                    $updateUser->username = $request->username;
                if ($request->pseudo)
                    $updateUser->pseudo = $request->pseudo;
                if ($request->email)
                    $updateUser->email = $request->email;
                if ($request->password) {
                    $updateUser->password = $request->password;
                    $updateUser['password'] = bcrypt($updateUser['password']);
                }
           
                $updateUser->save();
                unset($updateUser->password);

                return response()->json(['message'=>"Ok", "data"=>$updateUser], 200);
            } else {
                return ("User not found");
            }
        } else {
            return response()->json(['message'=>"Unauthorized"], 401);
        } 
    }
}