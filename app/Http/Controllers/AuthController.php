<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        
        // Check If Field is empty
        if(empty($email) or empty($password)){
            return response()->json(['status' => 'error', 'message' => 'Please enter email and password']);
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request){
        $name=$request->name;
        $email=$request->email;
        $password=$request->password;

        // check if field is empty
        if(empty($name) or empty($email) or empty($password)){
            return response()->json([
                'status'=>'error',
                'message'=>'You Must fill all the fields'
            ]);
        }

        // check if email is valid
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return response()->json([
                'status'=>'error',
                'message'=>'You Must Enter a valid email'
            ]);
        }

        // check if password is greater than 5 characters
        if(strlen($password)>6){
            return response()->json([
                'status'=>'error',
                'message'=>'Password Should be min 6 character'
            ]);
        }

        // check is user Already exists
        if(User::where('email','=',$email)->exists()){
            return response()->json([
                'status'=>'error',
                'message'=>'User Already exists with this email'
            ]);
        }

        // Create a new User
        try{
            $user=new User();
            $user->name=$name;
            $user->email=$email;
            $user->password=app('hash')->make($password);
            if($user->save()){
                return 'User Registration Successfully.';
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    

}
