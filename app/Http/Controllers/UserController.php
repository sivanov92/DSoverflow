<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
  public function Login(Request $request)
   {
    if ($request->has(['email','password'])) {
        $email =$request->input('email');
        $password=$request->input('password');
        $token="";
        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
            $token = $request->user()->currentAccessToken();
            return response()->json(['email'=>$email,'password'=>$password,'token'=>$token], 200);
        }
    }
    return response()->json(['details_received'=>['name'=>$name,'email'=>$email,'password'=>$password ]], 400);            
}  
   public function Register(Request $request)
   {
        dd($request->all());
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
         $user->save();
         $token="";
         if (Auth::attempt(['email'=>$email,'password'=>$password])) {
             $token = $request->user()->createToken($request->token_name);
             return response()->json(['name'=>$name,'email'=>$email,'password'=>$password,'token'=>$token], 200);
         }
     }
     return response()->json(['details_received'=>['name'=>$name,'email'=>$email,'password'=>$password ]], 400);            
   }  

}
