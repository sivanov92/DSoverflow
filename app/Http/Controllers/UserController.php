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
    if ($request->has(['0.email','0.password'])) {
        $email =$request->input('0.email');
        $password=$request->input('0.password');
        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
            $tokens = $request->user()->tokens;
            dd($tokens[0]);
            return response()->json(['email'=>$email,'password'=>$password,'token'=>$token], 200);
        }
    }
    return response()->json(['details_received'=>['name'=>$name,'email'=>$email,'password'=>$password ]], 400);            
}  
   public function Register(Request $request)
   {
    $input = $request->input();
    //dd($input[0]);
     if ($request->has(['0.name','0.email','0.password'])) {
         $name = $request->input('0.name');
         $email =$request->input('0.email');
         $password=$request->input('0.password');
         $created_at = now();
         $user = new User;
         $user->name = $name;
         $user->email = $email;
         $user->created_at = $created_at;
         $user->password = Hash::make($password);
         $user->save();
         if (Auth::attempt(['email'=>$email,'password'=>$password])) {
             $token = $request->user()->createToken(Str::random(10));
             return response()->json(['name'=>$name,'email'=>$email,'password'=>$password,'token'=>$token], 200);
         }
     }
     return response()->json(['details_received'=>['name'=>$name,'email'=>$email,'password'=>$password ]], 400);            
   }  

}
