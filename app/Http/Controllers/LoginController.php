<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\RegistrationModel;

class LoginController extends Controller
{
    function onLogin(Request $request){
        print('jejej'.$request);
        $username= $request->input('username');
        $password= $request->input('password');
        $userCount= RegistrationModel::where(["username"=>$username,"password"=>$password,])->count();
        if($userCount==1){

            

            $user= RegistrationModel::where(["username"=>$username,"password"=>$password,])->first();
            if($user->password==$password){
                $key = env('TOKEN_KEY');
                $payload=array(
                    "site"=>"http://demo.com",
                    "user"=>$user->username,
                    "iat"=>time(),
                    "exp"=>time()+3600,
                    "user"=>$user->username,
                    "id"=>$user->id,
                );
                $jwt = JWT::encode($payload, $key, 'HS256');
                return response()->json(['token'=>$jwt,'status'=>' Login Success']);
            }else{
                return 'Login Fail Try Again';
            }
        }else{
            return 'User Not Found';
        }
    }

    function tokenTest(){
        return 'token is Okay';
    }

}
