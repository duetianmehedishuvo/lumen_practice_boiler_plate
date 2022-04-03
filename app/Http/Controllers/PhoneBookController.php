<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\PhoneBookModel;
class PhoneBookController extends Controller
{
    

function onInsert(Request $request){

    $access_token=$request->input('access_token');
    $key = env('TOKEN_KEY');
    $decoded = JWT::decode($access_token, new Key($key, 'HS256'));
    $decoded_array=(array)$decoded ;
   
    $user=$decoded_array['user'];
    $one= $request->input('one');
    $two= $request->input('two');
    $name= $request->input('name');
    $email= $request->input('email');
    $result=PhoneBookModel::insert([
        'username'=>$user,
        'phone_number_one'=>$one,
        'phone_number_two'=>$two,
        'name'=>$name,
        'email'=>$email
        ]);
    if($result==true){
      return "Save Success";
    } 
    else{
        return "Fail ! Try Again";
    }
}

function onSelect(Request $request){
    $access_token=$request->input('access_token');
    $key = env('TOKEN_KEY');
    $decoded = JWT::decode($access_token, new Key($key, 'HS256'));
    $decoded_array=(array)$decoded ;
    $user=$decoded_array['user'];
    $result=PhoneBookModel::where('username', $user)->get();

    return  $result;
    
}

function onDelete(Request $request){
    $email=$request->input('email');
    $access_token=$request->input('access_token');
    $key = env('TOKEN_KEY');
    $decoded = JWT::decode($access_token, new Key($key, 'HS256'));
    $decoded_array=(array)$decoded ;
    $user=$decoded_array['user'];

    $result=PhoneBookModel::where(['username'=>$user, 'email'=> $email])->delete();


    if($result==true){
        return "Delete Success";
    }
    else{

        return "Delete Fail! Try Again";
    }
    
}



}