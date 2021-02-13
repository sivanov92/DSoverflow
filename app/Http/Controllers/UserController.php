<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class UserController extends Controller
{
    //
  public function Login(Request $request)
   {
    if ($request->has(['email','password'])) {
        $email =$request->input('email');
        $password=$request->input('password');
        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
           return response("User successfully logged in !",200);
        }
    }
    return response('Error ! Can not login this user , please check the credentials', 401);            
}  
   public function Register(Request $request)
   {
    $input = $request->input();
     if ($request->has(['name','email','password'])) {
         $name = $request->input('name');
         $email =$request->input('email');
         $password=$request->input('password');
         $created_at = now();
         $user = new User;
         $user->name = $name;
         $user->email = $email;
         $user->created_at = $created_at;
         $user->password = Hash::make($password);
         $user->access_token = '';
         $user->save();
         if (Auth::attempt(['email'=>$email,'password'=>$password])) {
             $token = $request->user()->createToken(Str::random(10));
             $user->access_token = $token->plainTextToken;
             $user->save();
             return response($user, 201);
         }
     }
     return response('Can not register a new user !', 400);            
   }  

}
