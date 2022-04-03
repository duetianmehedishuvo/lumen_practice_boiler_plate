<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationModel;

class RegistrationController extends Controller
{
    function onRegister(Request $request){
       $firstName= $request->input('firstname');
       $lastname= $request->input('lastname');
       $city= $request->input('city');
       $username= $request->input('username');
       $password= $request->input('password');
       $gender= $request->input('gender');

       $userCount= RegistrationModel::where('username',$username)->count();
       if($userCount==0){
        $result= RegistrationModel::insert([
            'firstname'=>$firstName,
            'lastname'=>$lastname,
            'city'=>$city,
            'username'=>$username,
            'password'=>$password,
            'gender'=>$gender,
        ]);

        if($result==true){
            return 'Registration Succesfull';
        }else{
            return 'Registration Fail Try Again';
        }

       }else{
           return 'User Already Exists';
       }

    }
}
