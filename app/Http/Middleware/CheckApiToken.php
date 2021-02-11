<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if($token == '')
         {
           return response('No Auth Token is passed in the Authorization header !',401);  
         }
        $users = User::all();
        foreach($users as $user)
         {
          $user_token = $user->access_token;
          if( $token == $user_token){  
            return $next($request);
          }
         }
        return response('The passed token does not match any user !',401);
    }
}
