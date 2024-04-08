<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

     
        // $tok = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJMYXJhdmVsIFBvcyIsImlhdCI6MTcxMjA4MDkzNywiZXhwIjoxNzI1MDQwOTM3LCJ1c2VyRW1haWwiOiJhZG1pbkBtY3NvZnR0ZWNoLmNvbSIsInVzZXJJRCI6OH0.7goCvdnuTtV0ZWLuJm36EBDqQ0VJr6GEJ0NsNUKmB18";
        $token=$request->cookie('token');
        // EncryptCookies.php file ar  except a 'token' use kora ase jonno token null ashtese na. 
        $result=JWTToken::VerifyToken($token);
        if($result=="unauthorized"){
            return redirect('/userLogin');
        }
        else{
            $request->headers->set('email',$result->userEmail);
            $request->headers->set('id',$result->userID);
            return $next($request);
        }
        
        
        
    }
}
