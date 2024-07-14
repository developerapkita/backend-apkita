<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserToken;
class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("Authorization");
        if(!$token || !Str::startsWith($token, 'Bearer ')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = Str::substr($token, 7);
        $user = UserToken::where('token', $token)->first();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
